<?php
/**
 * Plugin Name: Custom Schema Manager
 * Plugin URI:  https://elsner.com
 * Description: Add, edit, and remove multiple JSON-LD schema blocks per Post/Page from a single admin screen — no theme editing required.
 * Version:     1.0.0
 * Author:      Elsner Technologies Pvt Ltd
 * Text Domain: custom-schema-manager
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Custom_Schema_Manager {

    // Multiple schemas stored as an array of { id, schema } under this key.
    private $meta_key = '_custom_schema_markup_list';

    // Old key from v1 (single schema). Kept read-only for backward-compat output.
    private $legacy_meta_key = '_custom_schema_markup';

    private $nonce_action = 'custom_schema_manager_save';
    private $nonce_name   = 'custom_schema_manager_nonce';

    public function __construct() {
        add_action( 'wp_head', array( $this, 'output_schema' ), 99 );

        add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

        // AJAX endpoints
        add_action( 'wp_ajax_csm_get_posts_by_type', array( $this, 'ajax_get_posts_by_type' ) );
        add_action( 'wp_ajax_csm_get_schemas_for_post', array( $this, 'ajax_get_schemas_for_post' ) );
        add_action( 'wp_ajax_csm_save_schema_entry', array( $this, 'ajax_save_schema_entry' ) );
        add_action( 'wp_ajax_csm_delete_schema_entry', array( $this, 'ajax_delete_schema_entry' ) );
    }

    /**
     * Register the "Schema Manager" top-level admin page.
     */
    public function register_admin_page() {
        add_menu_page(
            'Schema Manager',
            'Schema Manager',
            'edit_posts',
            'custom-schema-manager',
            array( $this, 'render_admin_page' ),
            'dashicons-code-standards',
            80
        );
    }

    /**
     * Enqueue Select2 + our own admin JS/CSS, only on our settings page.
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_custom-schema-manager' !== $hook ) {
            return;
        }

        // WordPress core does NOT ship a 'select2' handle. Register our own copy.
        wp_register_style(
            'csm-select2',
            // 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css',
            array(),
            '4.1.0-rc.0'
        );
        wp_register_script(
            'csm-select2',
            // 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            plugin_dir_url( __FILE__ ) . 'assets/js/select2.min.js',
            array( 'jquery' ),
            '4.1.0-rc.0',
            true
        );

        wp_enqueue_style( 'csm-select2' );
        wp_enqueue_script( 'csm-select2' );

        wp_enqueue_style(
            'csm-admin-css',
            plugin_dir_url( __FILE__ ) . 'assets/css/csm-admin.css',
            array(),
            '2.0.0'
        );

        wp_enqueue_script(
            'csm-admin-js',
            plugin_dir_url( __FILE__ ) . 'assets/js/csm-admin.js',
            array( 'jquery', 'csm-select2' ),
            '2.0.0',
            true
        );

        wp_localize_script( 'csm-admin-js', 'csmAdmin', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'csm_admin_nonce' ),
        ) );
    }

    /**
     * Render the admin page markup: post type dropdown, post/page dropdown, schema list.
     */
    public function render_admin_page() {
        $post_types = get_post_types( array( 'public' => true ), 'objects' );
        unset( $post_types['attachment'] );
        ?>
        <div class="wrap">
            <h1>Schema Manager</h1>
            <p>Select a content type, then select the specific post/page to see, add, edit, or remove its schemas.</p>

            <table class="form-table">
                <tr>
                    <th><label for="csm-post-type">1. Select Type</label></th>
                    <td>
                        <select id="csm-post-type" style="min-width:300px;">
                            <option value="">-- Select post type --</option>
                            <?php foreach ( $post_types as $pt ) : ?>
                                <option value="<?php echo esc_attr( $pt->name ); ?>">
                                    <?php echo esc_html( $pt->labels->singular_name ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="csm-post-id">2. Select Post/Page</label></th>
                    <td>
                        <select id="csm-post-id" style="min-width:400px;" disabled>
                            <option value="">-- Select type first --</option>
                        </select>
                        <span id="csm-post-loading" style="display:none;">Loading…</span>
                    </td>
                </tr>
            </table>

            <div id="csm-schemas-panel" style="display:none; margin-top:20px;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                    <h2 style="margin:0;">Schemas for this post</h2>
                    <button type="button" class="button button-primary" id="csm-add-schema-btn">+ Add Schema</button>
                </div>

                <div id="csm-add-schema-row" class="csm-schema-card csm-new-card" style="display:none;">
                    <textarea
                        class="csm-schema-textarea"
                        rows="14"
                        placeholder='{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "..."
}'
                    ></textarea>
                    <p class="description">
                        Paste the full <code>&lt;script type="application/ld+json"&gt;...&lt;/script&gt;</code> block,
                        or just the raw JSON — it's wrapped automatically if the tag is missing.
                    </p>
                    <p>
                        <button type="button" class="button button-primary csm-save-new-btn">Save Schema</button>
                        <button type="button" class="button csm-cancel-new-btn">Cancel</button>
                        <span class="csm-row-status"></span>
                    </p>
                </div>

                <div id="csm-schema-list"></div>

                <p id="csm-no-schemas" style="display:none; color:#666;">No schemas added yet for this post.</p>
            </div>
        </div>

        <script type="text/template" id="csm-schema-row-template">
            <div class="csm-schema-card" data-id="__ID__">
                <div class="csm-schema-preview"><pre>__PREVIEW__</pre></div>
                <div class="csm-schema-actions">
                    <button type="button" class="button-link csm-edit-btn">Edit</button>
                    <button type="button" class="button-link csm-delete-btn" style="color:#b32d2e;">Delete</button>
                </div>
                <div class="csm-schema-edit" style="display:none;">
                    <textarea class="csm-schema-textarea">__RAW__</textarea>
                    <p>
                        <button type="button" class="button button-primary csm-save-edit-btn">Save</button>
                        <button type="button" class="button csm-cancel-edit-btn">Cancel</button>
                        <span class="csm-row-status"></span>
                    </p>
                </div>
            </div>
        </script>
        <?php
    }

    /**
     * Normalize whatever is stored under $meta_key into a clean list of
     * { id, schema } entries. Handles brand-new posts (no meta yet).
     */
    private function get_schema_entries( $post_id ) {
        $entries = get_post_meta( $post_id, $this->meta_key, true );

        if ( ! is_array( $entries ) ) {
            $entries = array();
        }

        // One-time migration view: if nothing in the new list yet, but the old
        // single-schema field has something, surface it as entry #1 (read-only
        // until they Edit+Save it, at which point it moves into the new format).
        if ( empty( $entries ) ) {
            $legacy = get_post_meta( $post_id, $this->legacy_meta_key, true );
            if ( ! empty( $legacy ) ) {
                $entries[] = array(
                    'id'     => 'legacy',
                    'schema' => $legacy,
                );
            }
        }

        return $entries;
    }

    /**
     * AJAX: given a post type, return matching posts for the searchable dropdown.
     */
    public function ajax_get_posts_by_type() {
        check_ajax_referer( 'csm_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( 'Permission denied', 403 );
        }

        $post_type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : '';
        $search    = isset( $_GET['search'] ) ? sanitize_text_field( wp_unslash( $_GET['search'] ) ) : '';

        if ( empty( $post_type ) || ! post_type_exists( $post_type ) ) {
            wp_send_json_error( 'Invalid post type' );
        }

        $args = array(
            'post_type'      => $post_type,
            'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
            'posts_per_page' => 50,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );

        if ( ! empty( $search ) ) {
            $args['s'] = $search;
        }

        $query   = new WP_Query( $args );
        $results = array();

        foreach ( $query->posts as $p ) {
            $count  = count( $this->get_schema_entries( $p->ID ) );
            $status = 'publish' !== $p->post_status ? ' — ' . ucfirst( $p->post_status ) : '';
            $results[] = array(
                'id'   => $p->ID,
                'text' => $p->post_title . ' (ID: ' . $p->ID . ')' . $status . ( $count ? " — {$count} schema" . ( $count > 1 ? 's' : '' ) : '' ),
            );
        }

        wp_send_json_success( $results );
    }

    /**
     * AJAX: fetch all schema entries for a given post ID.
     */
    public function ajax_get_schemas_for_post() {
        check_ajax_referer( 'csm_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( 'Permission denied', 403 );
        }

        $post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;

        if ( ! $post_id || ! get_post( $post_id ) ) {
            wp_send_json_error( 'Invalid post' );
        }

        wp_send_json_success( array( 'entries' => $this->get_schema_entries( $post_id ) ) );
    }

    /**
     * AJAX: create a new schema entry, or update an existing one by id.
     */
    public function ajax_save_schema_entry() {
        check_ajax_referer( 'csm_admin_nonce', 'nonce' );

        $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

        if ( ! $post_id || ! get_post( $post_id ) ) {
            wp_send_json_error( 'Invalid post' );
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            wp_send_json_error( 'Permission denied', 403 );
        }

        $entry_id  = isset( $_POST['entry_id'] ) ? sanitize_text_field( wp_unslash( $_POST['entry_id'] ) ) : '';
        $raw_value = isset( $_POST['schema'] ) ? trim( wp_unslash( $_POST['schema'] ) ) : '';

        // If wrapped in <script>...</script>, strip the wrapper and keep only the JSON body.
        // (wp_kses() would otherwise strip <script> and its contents entirely.)
        if ( preg_match( '/<script\b[^>]*>(.*)<\/script>/is', $raw_value, $matches ) ) {
            $raw_value = trim( $matches[1] );
        }

        $sanitized = trim( wp_strip_all_tags( $raw_value ) );

        if ( '' === $sanitized ) {
            wp_send_json_error( 'Schema cannot be empty. Use Trash to remove it instead.' );
        }

        // Validate it's actually parseable JSON, so we don't silently store garbage.
        json_decode( $sanitized );
        if ( JSON_ERROR_NONE !== json_last_error() ) {
            wp_send_json_error( 'That doesn\'t look like valid JSON. Please check the schema and try again.' );
        }

        $entries = $this->get_schema_entries( $post_id );
        $found   = false;

        if ( '' !== $entry_id ) {
            foreach ( $entries as &$entry ) {
                if ( $entry['id'] === $entry_id ) {
                    $entry['schema'] = $sanitized;
                    $found = true;
                    break;
                }
            }
            unset( $entry );
        }

        if ( ! $found ) {
            // New entry (either explicitly "add new", or an id we didn't recognize,
            // e.g. editing the migrated "legacy" entry for the first time).
            $entries[] = array(
                'id'     => 'schema_' . uniqid(),
                'schema' => $sanitized,
            );
            // If we just promoted the legacy single-schema entry, drop the old duplicate.
            if ( 'legacy' === $entry_id ) {
                $entries = array_values( array_filter( $entries, function( $e ) {
                    return 'legacy' !== $e['id'];
                } ) );
                delete_post_meta( $post_id, $this->legacy_meta_key );
            }
        }

        update_post_meta( $post_id, $this->meta_key, $entries );

        wp_send_json_success( array(
            'message' => 'Schema saved.',
            'entries' => $entries,
        ) );
    }

    /**
     * AJAX: delete a single schema entry by id.
     */
    public function ajax_delete_schema_entry() {
        check_ajax_referer( 'csm_admin_nonce', 'nonce' );

        $post_id  = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
        $entry_id = isset( $_POST['entry_id'] ) ? sanitize_text_field( wp_unslash( $_POST['entry_id'] ) ) : '';

        if ( ! $post_id || ! get_post( $post_id ) ) {
            wp_send_json_error( 'Invalid post' );
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            wp_send_json_error( 'Permission denied', 403 );
        }

        if ( 'legacy' === $entry_id ) {
            delete_post_meta( $post_id, $this->legacy_meta_key );
            wp_send_json_success( array( 'message' => 'Schema removed.', 'entries' => $this->get_schema_entries( $post_id ) ) );
        }

        $entries = $this->get_schema_entries( $post_id );
        $entries = array_values( array_filter( $entries, function( $e ) use ( $entry_id ) {
            return $e['id'] !== $entry_id;
        } ) );

        if ( empty( $entries ) ) {
            delete_post_meta( $post_id, $this->meta_key );
        } else {
            update_post_meta( $post_id, $this->meta_key, $entries );
        }

        wp_send_json_success( array( 'message' => 'Schema removed.', 'entries' => $entries ) );
    }

    /**
     * Output all schema entries in <head> on the frontend.
     */
    public function output_schema() {
        if ( ! is_singular() ) {
            return;
        }

        global $post;
        if ( ! $post ) {
            return;
        }

        $entries = $this->get_schema_entries( $post->ID );

        if ( empty( $entries ) ) {
            return;
        }

        // foreach ( $entries as $entry ) {
        //     $trimmed = trim( $entry['schema'] );
        //     if ( '' === $trimmed ) {
        //         continue;
        //     }
        //     if ( stripos( $trimmed, '<script' ) === false ) {
        //         echo esc_html("\n<script type=\"application/ld+json\">\n" . $trimmed . "\n</script>\n");
        //     } else {
        //         echo "\n" . $trimmed . "\n";
        //     }
        // }

        foreach ( $entries as $entry ) {
            $trimmed = trim( $entry['schema'] );

            if ( '' === $trimmed ) {
                continue;
            }

            // If a complete script tag was provided, extract the JSON inside it.
            if ( stripos( $trimmed, '<script' ) !== false ) {
                $trimmed = preg_replace(
                    '/^.*?<script[^>]*>(.*?)<\/script>.*$/is',
                    '$1',
                    $trimmed
                );
            }

            // Decode and validate the JSON-LD.
            $schema_data = json_decode( trim( $trimmed ), true );

            if ( JSON_ERROR_NONE !== json_last_error() || ! is_array( $schema_data ) ) {
                continue;
            }

            // Output valid JSON-LD.
            echo '<script type="application/ld+json">';
            echo wp_json_encode(
                $schema_data,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
            echo '</script>';
        }
    }
}

new Custom_Schema_Manager();
