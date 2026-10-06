jQuery(function ($) {
    var $postType     = $('#csm-post-type');
    var $postId       = $('#csm-post-id');
    var $loading      = $('#csm-post-loading');
    var $panel        = $('#csm-schemas-panel');
    var $list         = $('#csm-schema-list');
    var $noSchemas    = $('#csm-no-schemas');
    var $addBtn       = $('#csm-add-schema-btn');
    var $addRow       = $('#csm-add-schema-row');
    var rowTemplate   = $('#csm-schema-row-template').html();

    function escapeHtml(str) {
        return $('<div>').text(str || '').html();
    }
    function preview(schema) {
        return (schema || '').trim();
    }

    function resetPostDropdown(placeholder) {
        if ($postId.hasClass('select2-hidden-accessible')) {
            $postId.select2('destroy');
        }
        $postId.empty().append($('<option>', { value: '', text: placeholder }));
        $postId.prop('disabled', true);
        hidePanel();
    }

    function hidePanel() {
        $panel.hide();
        $addRow.hide();
        $list.empty();
    }

    function currentPostId() {
        return $postId.val();
    }

    // Step 1: post type changes -> enable + populate step 2 via AJAX (Select2 remote search)
    $postType.on('change', function () {
        var postType = $(this).val();
        hidePanel();

        if (!postType) {
            resetPostDropdown('-- Select type first --');
            return;
        }

        resetPostDropdown('-- Search or select --');
        $postId.prop('disabled', false); // enable BEFORE Select2 initializes on it

        $postId.select2({
            width: '400px',
            placeholder: '-- Search or select --',
            allowClear: true,
            ajax: {
                url: csmAdmin.ajaxUrl,
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return {
                        action: 'csm_get_posts_by_type',
                        nonce: csmAdmin.nonce,
                        post_type: postType,
                        search: params.term || ''
                    };
                },
                processResults: function (response) {
                    var items = (response && response.success) ? response.data : [];
                    return {
                        results: items.map(function (item) {
                            return { id: item.id, text: item.text };
                        })
                    };
                }
            },
            minimumInputLength: 0
        });
    });

    // Step 2: post/page selected -> load its schema list
    $postId.on('select2:select', function (e) {
        var postId = e.params.data.id;
        if (!postId) {
            hidePanel();
            return;
        }
        loadSchemas(postId);
    });

    $postId.on('select2:clear', function () {
        hidePanel();
    });

    function loadSchemas(postId) {
        $loading.show();
        hidePanel();

        $.get(csmAdmin.ajaxUrl, {
            action: 'csm_get_schemas_for_post',
            nonce: csmAdmin.nonce,
            post_id: postId
        }).done(function (response) {
            $loading.hide();
            $panel.show();

            var entries = (response && response.success) ? response.data.entries : [];
            renderList(entries);
        }).fail(function () {
            $loading.hide();
            $panel.show();
            renderList([]);
        });
    }

    function renderList(entries) {
        $list.empty();

        if (!entries || !entries.length) {
            $noSchemas.show();
            return;
        }
        $noSchemas.hide();

        entries.forEach(function (entry) {
            var html = rowTemplate
                .replace('__ID__', escapeHtml(entry.id))
                .replace('__PREVIEW__', escapeHtml(preview(entry.schema)))
                .replace('__RAW__', escapeHtml(entry.schema));
            $list.append(html);
        });
    }

    // Add Schema button -> reveal the add-new card
    $addBtn.on('click', function () {
        $addRow.find('.csm-schema-textarea').val('');
        $addRow.find('.csm-row-status').text('');
        $addRow.show();
    });

    $(document).on('click', '.csm-cancel-new-btn', function () {
        $addRow.hide();
    });

    $(document).on('click', '.csm-save-new-btn', function () {
        var postId = currentPostId();
        if (!postId) { return; }

        var $card   = $(this).closest('.csm-schema-card');
        var $status = $card.find('.csm-row-status');
        var schema  = $card.find('.csm-schema-textarea').val().trim();

        if (!schema) {
            $status.text('Please paste some schema first.').css('color', 'red');
            return;
        }

        $status.text('Saving…').css('color', '#666');

        $.post(csmAdmin.ajaxUrl, {
            action: 'csm_save_schema_entry',
            nonce: csmAdmin.nonce,
            post_id: postId,
            entry_id: '',
            schema: schema
        }).done(function (response) {
            if (response && response.success) {
                $addRow.hide();
                renderList(response.data.entries);
            } else {
                var msg = (response && response.data) ? response.data : 'Save failed.';
                $status.text('✗ ' + msg).css('color', 'red');
            }
        }).fail(function () {
            $status.text('✗ Request failed.').css('color', 'red');
        });
    });

    // Existing row: Edit -> reveal that row's editor
    $(document).on('click', '.csm-edit-btn', function () {
        var $card = $(this).closest('.csm-schema-card');
        $card.find('.csm-schema-edit').show();
        $card.find('.csm-schema-preview').hide();
        $card.find('.csm-schema-actions').hide();
    });

    $(document).on('click', '.csm-cancel-edit-btn', function () {
        var $card = $(this).closest('.csm-schema-card');
        $card.find('.csm-schema-edit').hide();
        $card.find('.csm-schema-preview').show();
        $card.find('.csm-schema-actions').show();
    });

    // Existing row: Save edit
    $(document).on('click', '.csm-save-edit-btn', function () {
        var postId = currentPostId();
        if (!postId) { return; }

        var $card    = $(this).closest('.csm-schema-card');
        var entryId  = $card.data('id');
        var $status  = $card.find('.csm-row-status');
        var schema   = $card.find('.csm-schema-edit .csm-schema-textarea').val().trim();

        if (!schema) {
            $status.text('Schema cannot be empty — use Trash to remove it.').css('color', 'red');
            return;
        }

        $status.text('Saving…').css('color', '#666');

        $.post(csmAdmin.ajaxUrl, {
            action: 'csm_save_schema_entry',
            nonce: csmAdmin.nonce,
            post_id: postId,
            entry_id: String(entryId),
            schema: schema
        }).done(function (response) {
            if (response && response.success) {
                renderList(response.data.entries);
            } else {
                var msg = (response && response.data) ? response.data : 'Save failed.';
                $status.text('✗ ' + msg).css('color', 'red');
            }
        }).fail(function () {
            $status.text('✗ Request failed.').css('color', 'red');
        });
    });

    // Existing row: Trash -> delete just that entry
    $(document).on('click', '.csm-delete-btn', function () {
        var postId = currentPostId();
        if (!postId) { return; }

        if (!window.confirm('Remove this schema? This cannot be undone.')) {
            return;
        }

        var $card   = $(this).closest('.csm-schema-card');
        var entryId = $card.data('id');

        $.post(csmAdmin.ajaxUrl, {
            action: 'csm_delete_schema_entry',
            nonce: csmAdmin.nonce,
            post_id: postId,
            entry_id: String(entryId)
        }).done(function (response) {
            if (response && response.success) {
                renderList(response.data.entries);
            } else {
                window.alert((response && response.data) ? response.data : 'Remove failed.');
            }
        }).fail(function () {
            window.alert('Request failed.');
        });
    });
});
