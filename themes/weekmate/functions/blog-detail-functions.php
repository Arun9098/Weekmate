<?php
// Breadcrom for the blog detail page 
function custom_blog_breadcrumb() {
    echo '<nav class="custom-breadcrumb" aria-label="breadcrumb">';

    // Home
    echo '<a href="' . esc_url(home_url('/')) . '">Home</a> &raquo; ';

    if (is_singular('post')) {
        // Blog
        $blog_page = get_option('page_for_posts');
        if ($blog_page) {
            echo '<a href="' . esc_url(get_permalink($blog_page)) . '">Blog</a> &raquo; ';
        } else {
            echo '<a href="' . esc_url(home_url('/blog/')) . '">Blog</a> &raquo; ';
        }
        // Category
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            echo '<span class="category">'. esc_html($category->name). '</span> &raquo; ';
        }
    }
      echo '<span class="current">' . esc_html(get_the_title()) . '</span>';
    echo '</nav>';
}
// Table of content for the blog detail page 
// function auto_generate_toc( $content ) {
//     if ( ! is_singular( 'post' ) || ! is_main_query() ) {
//         return $content;
//     }
//     preg_match_all( '/<h2([^>]*)>(.*?)<\/h2>/is', $content, $matches, PREG_SET_ORDER );
//     if ( empty( $matches ) ) {
//         return $content;
//     }
//     $toc_items = array();
//     $used_ids  = array();
//     foreach ( $matches as $match ) {
//         $title = wp_strip_all_tags( $match[2] );
//         $id    = sanitize_title( $title );
//         $base  = $id;
//         $i     = 1;
//         while ( in_array( $id, $used_ids, true ) ) {
//             $id = $base . '-' . $i++;
//         }
//         $used_ids[] = $id;
//         $content = str_replace(
//             $match[0],
//             '<h2' . $match[1] . ' id="' . esc_attr( $id ) . '">' . $match[2] . '</h2>',
//             $content
//         );
//         $toc_items[] = array(
//             'level' => 2,
//             'title' => $title,
//             'id'    => $id,
//         );
//     }
//     global $blog_toc_items;
//     $blog_toc_items = $toc_items;
//     return $content;
// }
function auto_generate_toc( $content ) {
    if ( ! is_singular( 'post' ) || ! is_main_query() ) {
        return $content;
    }
    preg_match_all( '/<h2([^>]*)>(.*?)<\/h2>/is', $content, $matches, PREG_SET_ORDER );
    if ( empty( $matches ) ) {
        return $content;
    }
    $toc_items = array();
    $used_ids  = array();
    foreach ( $matches as $match ) {
        $title = wp_strip_all_tags( $match[2] );
        $id    = sanitize_title( $title );
        $base  = $id;
        $i     = 1;
        while ( in_array( $id, $used_ids, true ) ) {
            $id = $base . '-' . $i++;
        }
        $used_ids[] = $id;
        $content = str_replace(
            $match[0],
            '<h2' . $match[1] . ' id="' . esc_attr( $id ) . '">' . $match[2] . '</h2>',
            $content
        );
        $toc_items[] = array(
            'level' => 2,
            'title' => $title,
            'id'    => $id,
        );
    }
    global $blog_toc_items;
    $blog_toc_items = $toc_items;
    return $content;
}
add_filter( 'the_content', 'auto_generate_toc', 5 );
// function render_blog_toc() {
//     global $blog_toc_items;
//     if ( empty( $blog_toc_items ) ) {
//         return;
//     }
//     echo '<div class="blog-toc collapsed" id="blog-toc">';
//     echo '<div class="blog-toc-header">
//             <span>Table of Contents</span>
//             <button class="toc-toggle" aria-label="Toggle table of contents">
//              <svg class="icon-up" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
//                 <polyline points="18 15 12 9 6 15"></polyline>
//             </svg>
//             <svg class="icon-down" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
//                 <polyline points="6 9 12 15 18 9"></polyline>
//             </svg>
//             </button>
//         </div>';
//     echo '<ul class="toc-list">';
//     foreach ( $blog_toc_items as $item ) {
//         echo '<li class="toc-level-' . $item['level'] . '">';
//         echo '<a href="#' . esc_attr( $item['id'] ) . '" class="toc-link">' . esc_html( $item['title'] ) . '</a>';
//         echo '</li>';
//     }
//     echo '</ul></div>';
// }
function render_blog_toc() {
    global $blog_toc_items;
    if ( empty( $blog_toc_items ) ) {
        return;
    }
    echo '<div class="blog-toc collapsed" id="blog-toc">';
    echo '<div class="blog-toc-header">
            <span>Table of Contents</span>
            <button class="toc-toggle" aria-label="Toggle table of contents">
             <svg class="icon-up" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
            <svg class="icon-down" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
            </button>
        </div>';
    echo '<ul class="toc-list">';
    foreach ( $blog_toc_items as $item ) {
        echo '<li class="toc-level-' . $item['level'] . '">';
        echo '<a href="#' . esc_attr( $item['id'] ) . '" class="toc-link">' . esc_html( $item['title'] ) . '</a>';
        echo '</li>';
    }
    echo '</ul></div>';
}
?>
