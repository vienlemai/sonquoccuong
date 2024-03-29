<?php
/*
 * Post relationship code.
 *
 * $HeadURL: https://www.onthegosystems.com/misc_svn/cck/tags/1.5.6/embedded/includes/post-relationship.php $
 * $LastChangedDate: 2014-04-28 16:20:36 +0000 (Mon, 28 Apr 2014) $
 * $LastChangedRevision: 21804 $
 * $LastChangedBy: marcin $
 *
 */
require_once WPCF_EMBEDDED_INC_ABSPATH . '/editor-support/post-relationship-editor-support.php';

add_action( 'wpcf_admin_post_init', 'wpcf_pr_admin_post_init_action', 10, 4 );
add_action( 'save_post', 'wpcf_pr_admin_save_post_hook', 20, 2 ); // Trigger afer main hook

/**
 * Init function.
 * 
 * Enqueues styles and scripts on post edit page.
 * 
 * @param type $post_type
 * @param type $post
 * @param type $groups
 * @param type $wpcf_active 
 */
function wpcf_pr_admin_post_init_action( $post_type, $post, $groups,
        $wpcf_active ) {

    // See if any data
    $has = wpcf_pr_admin_get_has( $post_type );
    $belongs = wpcf_pr_admin_get_belongs( $post_type );

    /*
     * 
     * Enqueue styles and scripts
     */
    if ( !empty( $has ) || !empty( $belongs ) ) {

        $output = wpcf_pr_admin_post_meta_box_output( $post,
                array('post_type' => $post_type, 'has' => $has, 'belongs' => $belongs) );
        add_meta_box( 'wpcf-post-relationship', __( 'Fields table', 'wpcf' ),
                'wpcf_pr_admin_post_meta_box', $post_type, 'normal', 'default',
                array('output' => $output) );
        if ( !empty( $output ) ) {
            wp_enqueue_script( 'wpcf-post-relationship',
                    WPCF_EMBEDDED_RELPATH . '/resources/js/post-relationship.js',
                    array('jquery'), WPCF_VERSION );
            wp_enqueue_style( 'wpcf-post-relationship',
                    WPCF_EMBEDDED_RELPATH . '/resources/css/post-relationship.css',
                    array(), WPCF_VERSION );
            if ( !$wpcf_active ) {
                wpcf_enqueue_scripts();
                wp_enqueue_style( 'wpcf-pr-post',
                        WPCF_EMBEDDED_RES_RELPATH . '/css/fields-post.css',
                        array(), WPCF_VERSION );
                wp_enqueue_script( 'wpcf-form-validation',
                        WPCF_EMBEDDED_RES_RELPATH . '/js/'
                        . 'jquery-form-validation/jquery.validate.min.js',
                        array('jquery'), WPCF_VERSION );
                wp_enqueue_script( 'wpcf-form-validation-additional',
                        WPCF_EMBEDDED_RES_RELPATH . '/js/'
                        . 'jquery-form-validation/additional-methods.min.js',
                        array('jquery'), WPCF_VERSION );
            }
            wpcf_admin_add_js_settings( 'wpcf_pr_del_warning',
                    '\'' . __( 'Are you sure about deleting this post?', 'wpcf' ) . '\'' );
            wpcf_admin_add_js_settings( 'wpcf_pr_pagination_warning',
                    '\'' . __( 'If you continue without saving your changes, it might get lost.',
                            'wpcf' ) . '\'' );
        }
    }
}

/**
 * Gets post types that belong to current post type.
 * 
 * @param type $post_type
 * @return type 
 */
function wpcf_pr_admin_get_has( $post_type ) {
    static $cache = array();
    if ( isset( $cache[$post_type] ) ) {
        return $cache[$post_type];
    }
    $relationships = get_option( 'wpcf_post_relationship', array() );
    if ( empty( $relationships[$post_type] ) ) {
        return false;
    }
    // See if enabled
    foreach ( $relationships[$post_type] as $temp_post_type => $temp_post_type_data ) {
        $active = get_post_type_object( $temp_post_type );
        if ( !$active ) {
            unset( $relationships[$post_type][$temp_post_type] );
        }
    }
    $cache[$post_type] = !empty( $relationships[$post_type] ) ? $relationships[$post_type] : false;
    return $cache[$post_type];
}

/**
 * Gets post types that current post type belongs to.
 * 
 * @param type $post_type
 * @return type 
 */
function wpcf_pr_admin_get_belongs( $post_type ) {
    static $cache = array();
    if ( isset( $cache[$post_type] ) ) {
        return $cache[$post_type];
    }
    $relationships = get_option( 'wpcf_post_relationship', array() );
    $results = array();
    if ( is_array( $relationships ) ) {
        foreach ( $relationships as $has => $belongs ) {
            // See if enabled
            $active = get_post_type_object( $has );
            if ( !$active ) {
                continue;
            }
            if ( array_key_exists( $post_type, $belongs ) ) {
                $results[$has] = $belongs[$post_type];
            }
        }
    }
    $cache[$post_type] = !empty( $results ) ? $results : false;
    return $cache[$post_type];
}

/**
 * Meta boxes contents.
 * 
 * @param type $post
 * @param type $args 
 */
function wpcf_pr_admin_post_meta_box( $post, $args ) {
    if ( !empty( $args['args']['output'] ) ) {
        echo $args['args']['output'];
    } else {
        _e( 'You will be able to add/edit child posts after saving the parent post.',
                'wpcf' );
    }
}

/**
 * Meta boxes contents output.
 * 
 * @param type $post
 * @param type $args 
 */
function wpcf_pr_admin_post_meta_box_output( $post, $args ) {

    if ( empty( $post->ID ) ) {
        return false;
    }

    global $wpcf;

    $output = '';
    $relationships = $args;
    $post_id = !empty( $post->ID ) ? $post->ID : -1;
    $current_post_type = wpcf_admin_get_edited_post_type( $post );
    /*
     * 
     * 
     * 
     * Render has form (child form)
     */
    if ( !empty( $relationships['has'] ) ) {
        foreach ( $relationships['has'] as $post_type => $data ) {
            $output .= $wpcf->relationship->child_meta_form( $post, $post_type,
                    $data );
        }
    }
    /*
     * 
     * 
     * 
     * Render belongs form (parent form)
     */
    if ( !empty( $relationships['belongs'] ) ) {
        $meta = get_post_custom( $post_id );
        $belongs = array('belongs' => array(), 'posts' => array());
        foreach ( $meta as $meta_key => $meta_value ) {
            if ( strpos( $meta_key, '_wpcf_belongs_' ) === 0 ) {
                $temp_post = get_post( $meta_value[0] );
                if ( !empty( $temp_post ) ) {
                    $belongs['posts'][$temp_post->ID] = $temp_post;
                    $belongs['belongs'][$temp_post->post_type] = $temp_post->ID;
                }
            }
        }
        $output_temp = '';
        foreach ( $relationships['belongs'] as $post_type => $data ) {
            $output_temp .= wpcf_form_simple( wpcf_pr_admin_post_meta_box_belongs_form( $post,
                            $post_type, $belongs ) );
        }
        if ( !empty( $output_temp ) ) {
            $output .= '<div style="margin: 20px 0 10px 0">' . sprintf( __( 'This %s belongs to:',
                                    'wpcf' ), $current_post_type ) . '</div>' . $output_temp;
        }
    }
    return $output;
}

/**
 * AJAX delete child item call.
 * 
 * @param type $post_id
 * @return string 
 */
function wpcf_pr_admin_delete_child_item( $post_id ) {
    wp_delete_post( $post_id, true );
    return __( 'Post deleted', 'wpcf' );
}

/**
 * Belongs form.
 * 
 * @param type $post
 * @param type $post_type
 * @param type $data
 * @param type $parent_post_type
 */
function wpcf_pr_admin_post_meta_box_belongs_form( $post, $type, $belongs ) {

    global $wpdb;

    if ( empty( $post ) || empty( $post->ID ) ) {
        return array();
    }
    $temp_type = get_post_type_object( $type );
    if ( empty( $temp_type ) ) {
        return array();
    }
    $form = array();
    $options = array(
        __( 'Not selected', 'wpcf' ) => 0,
    );

//    $items = get_posts( 'post_type=' . $type . '&numberposts=-1&post_status=null&order=ASC&orderby=title&suppress_filters=0&fields=ids' );

//    if ( empty( $items ) ) {
//        return array();
    //    }

    /**
     * create sql query
     */
    $sql = sprintf( 'SELECT p.ID, p.post_title, p.post_status FROM %s p ', $wpdb->posts);

    /**
     * add WMPL support
     */
    $wpml_where = '';
    if (
        defined('ICL_SITEPRESS_VERSION')
        && function_exists('wpml_get_language_information')
    ) {
        global $sitepress;
        if (
            is_object( $sitepress )
            &&  $sitepress->is_translated_post_type($type)
        ) {
            $post_language_information = wpml_get_language_information($post->ID);
            $sql .= sprintf( ' LEFT JOIN %sicl_translations t on t.element_id = p.ID and t.element_type = \'post_%s\' ', $wpdb->prefix, $type);
            $sql .= sprintf( ' LEFT JOIN %sicl_languages l on l.code = t.language_code ', $wpdb->prefix);
            $wpml_where = sprintf( ' AND l.default_locale = \'%s\'', $post_language_information['locale'] );
        }
    }

    /**
     * add where
     */
    $sql .= ' WHERE p.post_type = %s AND p.post_status <> %s ' . $wpml_where;

    /**
     * add order by
     */
    $sql .= ' ORDER BY FIELD(p.post_status, \'pending\', \'draft\', \'publish\') DESC, p.post_title';

    /**
     * get items
     */
    $items = $wpdb->get_results( $wpdb->prepare( $sql, $type, 'auto-draft'), OBJECT_K );
    if ( empty( $items ) ) {
        return array();
    }

//    foreach ( $items as $temp_post ) {
//        if ( !isset( $_titles[$temp_post]->post_title ) ) {
//            continue;
//        }
//        $options[] = array(
//            '#title' => $_titles[$temp_post]->post_title,
//            '#value' => $temp_post,
//        );
    //    }
    //
    //
    foreach ( $items as $item ) {
        $_title_add = $item->post_status != 'publish' ? ' (' . $item->post_status . ')' : '';
        $options[] = array(
            '#title' => $item->post_title . $_title_add,
            '#value' => $item->ID,
        );
    }

    $form[$type] = array(
        '#type' => 'select',
        '#name' => 'wpcf_pr_belongs[' . $post->ID . '][' . $type . ']',
        '#default_value' => isset( $belongs['belongs'][$type] ) ? $belongs['belongs'][$type] : 0,
        '#options' => $options,
        '#prefix' => $temp_type->label . '&nbsp;',
        '#suffix' => '&nbsp;<a href="'
        . admin_url( 'admin-ajax.php?action=wpcf_ajax'
                . '&amp;wpcf_action=pr-update-belongs&amp;_wpnonce='
                . wp_create_nonce( 'pr-update-belongs' )
                . '&amp;post_id=' . $post->ID )
        . '" class="button-secondary wpcf-pr-update-belongs">' . __( 'Update',
                'wpcf' ) . '</a>',
    );
    return $form;
}

/**
 * Updates belongs data.
 * 
 * @param type $post_id
 * @param array $data $post_type => $post_id
 * @return string 
 */
function wpcf_pr_admin_update_belongs( $post_id, $data ) {

    $errors = array();
    $post = get_post( intval( $post_id ) );
    if ( empty( $post->ID ) ) {
        return new WP_Error( 'wpcf_update_belongs',
                sprintf( __( 'Missing child post ID %d', 'wpcf' ),
                        intval( $post_id ) ) );
    }

    foreach ( $data as $post_type => $post_owner_id ) {
        // Check if relationship exists
        if ( !wpcf_relationship_is_parent( $post_type, $post->post_type ) ) {
            $errors[] = sprintf( __( 'Relationship do not exist %s -> %s',
                            'wpcf' ), strval( $post_type ),
                    strval( $post->post_type ) );
            continue;
        }
        if ( $post_owner_id == '0' ) {
            delete_post_meta( $post_id, "_wpcf_belongs_{$post_type}_id" );
            continue;
        }
        $post_owner = get_post( intval( $post_owner_id ) );
        // Check if owner post exists
        if ( empty( $post_owner->ID ) ) {
            $errors[] = sprintf( __( 'Missing parent post ID %d', 'wpcf' ),
                    intval( $post_owner_id ) );
            continue;
        }
        // Check if owner post type matches required
        if ( $post_owner->post_type != $post_type ) {
            $errors[] = sprintf( __( 'Parent post ID %d is not type of %s',
                            'wpcf' ), intval( $post_owner_id ),
                    strval( $post_type ) );
            continue;
        }
        update_post_meta( $post_id, "_wpcf_belongs_{$post_type}_id", $post_owner->ID );
    }

    if ( !empty( $errors ) ) {
        return new WP_Error( 'wpcf_update_belongs', implode( '; ', $errors ) );
    }

    return __( 'Post updated', 'wpcf' );
}

/**
 * Pagination link.
 * 
 * @param type $post
 * @param type $post_type
 * @param type $page
 * @param type $prev
 * @param type $next
 * @return string 
 */
function wpcf_pr_admin_has_pagination( $post, $post_type, $page, $prev, $next,
        $per_page = 20, $count = 20 ) {

    global $wpcf;

    $link = '';
    $add = '';
    if ( isset( $_GET['sort'] ) ) {
        $add .= '&sort=' . $_GET['sort'];
    }
    if ( isset( $_GET['field'] ) ) {
        $add .= '&field=' . $_GET['field'];
    }
    if ( isset( $_GET['post_type_sort_parent'] ) ) {
        $add .= '&post_type_sort_parent=' . $_GET['post_type_sort_parent'];
    }
    if ( $prev ) {
        $link .= '<a class="button-secondary wpcf-pr-pagination-link wpcf-pr-prev" href="'
                . admin_url( 'admin-ajax.php?action=wpcf_ajax&amp;wpcf_action=pr_pagination&amp;page='
                        . ($page - 1) . '&amp;dir=prev&amp;post_id=' . $post->ID . '&amp;post_type='
                        . $post_type
                        . '&amp;' . $wpcf->relationship->items_per_page_option_name
                        . '=' . $wpcf->relationship->items_per_page
                        . '&amp;_wpnonce='
                        . wp_create_nonce( 'pr_pagination' ) . $add ) . '">'
                . __( 'Prev', 'wpcf' ) . '</a>&nbsp;&nbsp;';
    }
    if ( $per_page < $count ) {
        $total_pages = ceil( $count / $per_page );
        $link .= '<select class="wpcf-pr-pagination-select" name="wpcf-pr-pagination-select">';
        for ( $index = 1; $index <= $total_pages; $index++ ) {
            $link .= '<option';
            if ( ($index) == $page ) {
                $link .= ' selected="selected"';
            }
            $link .= ' value="' . admin_url( 'admin-ajax.php?action=wpcf_ajax&amp;wpcf_action=pr_pagination&amp;page='
                            . $index . '&amp;dir=next&amp;post_id=' . $post->ID . '&amp;post_type='
                            . $post_type
                            . '&amp;' . $wpcf->relationship->items_per_page_option_name
                            . '=' . $wpcf->relationship->items_per_page
                            . '&amp;_wpnonce='
                            . wp_create_nonce( 'pr_pagination' ) . $add ) . '">' . $index . '</option>';
        }
        $link .= '</select>';
    }
    if ( $next ) {
        $link .= '<a class="button-secondary wpcf-pr-pagination-link wpcf-pr-next" href="'
                . admin_url( 'admin-ajax.php?action=wpcf_ajax&amp;wpcf_action=pr_pagination&amp;page='
                        . ($page + 1) . '&amp;dir=next&amp;post_id=' . $post->ID . '&amp;post_type='
                        . $post_type
                        . '&amp;' . $wpcf->relationship->items_per_page_option_name
                        . '=' . $wpcf->relationship->items_per_page
                        . '&amp;_wpnonce='
                        . wp_create_nonce( 'pr_pagination' ) . $add ) . '">'
                . __( 'Next', 'wpcf' ) . '</a>';
    }
    return !empty( $link ) ? '<div class="wpcf-pagination-top">' . $link . '</div>' : '';
}

/**
 * Save post hook.
 * 
 * @param type $parent_post_id
 * @return string 
 */
function wpcf_pr_admin_save_post_hook( $parent_post_id ) {

    global $wpcf;
    /*
     * TODO https://icanlocalize.basecamphq.com/projects/7393061-toolset/todo_items/159760120/comments#225005357
     * Problematic This should be done once per save (on saving main post)
     * remove_action( 'save_post', 'wpcf_pr_admin_save_post_hook', 11);
     */
    static $cached = array();
    /*
     * 
     * TODO Monitor this
     */
    // Remove main hook?
    // CHECKPOINT We remove temporarily main hook
//    remove_action( 'save_post', 'wpcf_admin_save_post_hook', 10, 2 );
    if ( !isset( $cached[$parent_post_id] ) ) {
        if ( isset( $_POST['wpcf_post_relationship'][$parent_post_id] ) ) {
            $wpcf->relationship->save_children( $parent_post_id,
                    (array) $_POST['wpcf_post_relationship'][$parent_post_id] );
        }
        // Save belongs if any
        if ( isset( $_POST['wpcf_pr_belongs'][intval( $parent_post_id )] ) ) {
            wpcf_pr_admin_update_belongs( intval( $parent_post_id ),
                    $_POST['wpcf_pr_belongs'][intval( $parent_post_id )] );
        }

        // WPML
        wpcf_wpml_relationship_save_post_hook( $parent_post_id );

        // Restore main hook?
//    add_action( 'save_post', 'wpcf_admin_save_post_hook', 10, 2 );
        // Actually needs looping over all relationships
//        debug($_POST['wpcf_pr_belongs']);

        $cached[$parent_post_id] = true;
    }

}

/**
 * Filters AJAX 'cd_verify' action data.
 * 
 * @global type $wpcf
 * @param type $posted
 * @param type $field
 * @return type
 */
function wpcf_relationship_ajax_data_filter( $posted, $field ) {

    global $wpcf;

    $value = $wpcf->relationship->get_submitted_data(
            $wpcf->relationship->parent->ID, $wpcf->relationship->child->ID,
            $field );

    return is_null( $value ) ? $posted : $value;
}

/**
 * Checks if post type is parent
 * @param type $parent_post_type
 * @param type $child_post_type
 * @return type
 */
function wpcf_relationship_is_parent( $parent_post_type, $child_post_type ) {
    $has = wpcf_pr_admin_get_has( $parent_post_type );
    return isset( $has[$child_post_type] );
}
