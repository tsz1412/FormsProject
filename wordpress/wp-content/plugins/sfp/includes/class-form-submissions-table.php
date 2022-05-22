<?php
/**
 * The classes responsible for rendering the list of licenses.
 */
class Form_Submissions_Table extends Forms_Submissions_Table_List {

    /**
     * The plugin's text domain.
     *
     * @access  private
     * @var     string  The plugin's text domain. Used for localization.
     */
    private $text_domain;

    /**
     * Initializes the WP_List_Table implementation.
     *
     * @param $text_domain  string  The text domain used for localizing the plugin.
     */
    public function __construct( $text_domain ) {
        parent::__construct();

        $this->text_domain = $text_domain;
    }
    /**
     * Defines the database columns shown in the table and a
     * header for each column. The order of the columns in the
     * table define the order in which they are rendered in the list table.
     *
     * @return array    The database columns and their headers for the table.
     */
    public function get_columns() {
        return array(
            'fname' => __( 'First Name', $this->text_domain ),
            'lname'       => __( 'Last Name', $this->text_domain ),
            'email'  => __( 'Email Address', $this->text_domain ),
            'phone'  => __( 'Phone Number', $this->text_domain ),
            'country'  => __( 'Country', $this->text_domain ),
            'date_of_birth'  => __( 'Date of Birth', $this->text_domain ),
            'tou_agreement'  => __( 'Agreed to TOU?', $this->text_domain ),


        );
    }

    /**
     * Returns the names of columns that should be hidden from the list table.
     *
     * @return array    The database columns that should not be shown in the table.
     */
    public function get_hidden_columns() {
        return array();
    }

    /**
     * Returns the columns that can be used for sorting the list table data.
     *
     * @return array    The database columns that can be used for sorting the table.
     */
    public function get_sortable_columns() {
        return array(
            'fname' => array( 'fname', false ),
            'lname'       => array( 'lname', false ),
            'email'  => array( 'email', false ),
            'phone'  => array( 'phone', false ),
            'country'  => array( 'country', false ),
            'date_of_birth'  => array( 'date_of_birth', false ),
        );
    }


//    function column_customer_name($item){
//        global $wpdb;
//        $license= $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}bina_licenses WHERE id = {$item['license_id']}", ARRAY_A);
//
//        $user = get_userdata( $license['customer_id'] );
//        return $user->display_name;
//    }

    /**
     * Get ea Object from db
     */
    /**
     * Default rendering for table columns.
     *
     * @param $item         array   The database row being printed out.
     * @param $column_name  string  The column currently processed.
     * @return string       The text or HTML that should be shown for the column.
     */
    function column_default( $item, $column_name ) {
        global $wpdb;
        switch( $column_name ) {

            case 'country':
                return '<span style="font-size: 12px; text-align: center">  <img src="'.trailingslashit(get_template_directory_uri()).'assets/flags/'.$item[$column_name].'.svg" width="24" height="18" alt="'.$item[$column_name].'"><br>'.$item[$column_name].'</span>';

            default:
                return $item[$column_name];
        }

    }
    function column_tou_agreement($item)
    {
        if (($item['tou_agreement']) == 1){
            return 'V';
        }
        else{
            return 'X';
        }
    }
    /**
     * Populates the class fields for displaying the list of licenses.
     */
    public function prepare_items() {
        global $wpdb;
        $table_name = $wpdb->prefix . get_option('sfp_db_name');

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );

        // Pagination
        $licenses_per_page = 20;
        $total_items = $wpdb->get_var( "SELECT COUNT(id) FROM $table_name" );

        $offset = 0;
        if ( isset( $_REQUEST['paged'] ) ) {
            $page = max( 0, intval( $_REQUEST['paged'] ) - 1 );
            $offset = $page * $licenses_per_page;
        }

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page' => $licenses_per_page,
                'total_pages' => ceil( $total_items / $licenses_per_page )
            )
        );

        // Sorting
        $order_by = 'fname'; // Default sort key
        if ( isset( $_REQUEST['orderby'] ) ) {
            // If the requested sort key is a valid column, use it for sorting
            if ( in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns() ) ) ) {
                $order_by = $_REQUEST['orderby'];
            }
        }

        $order = 'asc'; // Default sort order
        if ( isset( $_REQUEST['order'] ) ) {
            if ( in_array( $_REQUEST['order'], array( 'asc', 'desc' ) ) ) {
                $order = $_REQUEST['order'];
            }
        }

        // Do the SQL query and populate items
        if(isset($_GET['s']))
        {

            $search=$_GET['s'];

            $search = trim($search);
            $this->items = $wpdb->get_results(
                $wpdb->prepare( "SELECT * FROM $table_name WHERE customer_name LIKE '%$search%' ORDER BY $order_by $order LIMIT %d OFFSET %d", $licenses_per_page, $offset ),
                ARRAY_A );
        }
        else {
            $this->items = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM $table_name ORDER BY $order_by $order LIMIT %d OFFSET %d", $licenses_per_page, $offset),
                ARRAY_A);
        }
    }

    function column_license_id($item) {
        global $wpdb;
        $license_id = $item['id'];

        $license= $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}bina_licenses WHERE id = {$item['license_id']}", ARRAY_A);
        //$actions['edit'] = sprintf('<a href="?page=%s&action=%s&license=%d">Edit</a>',$_REQUEST['page'], 'edit', $item['id']);
        $actions['delete'] = sprintf('<a class="revenue-delete-button submitdelete" onclick="return confirm( \'%s\' );" data-revenue-id="%d">'.__("Delete", $this->text_domain).'</a>','Are you sure?', $item['id']);
        $show_value = "alert('{$license['license_key']}')";
        $copy_license_to_clipboard = "copyTextToClipboard('{$license['license_key']}')";
        $copy_invoice_to_clipboard = "copyTextToClipboard('{$item['invoice_link']}')";

        $actions['copy-license'] = sprintf('<a href="#copy-license" onclick="%s">'.__("Copy License", $this->text_domain).'</a>', $copy_license_to_clipboard);
        $actions['view'] = sprintf('<a href="#show-license" onclick="%s">'.__("Show", $this->text_domain).'</a>', $show_value);
        $actions['copy-invoice'] = sprintf('<a href="#copy-invoice" onclick="%s">'.__("Copy Invoice", $this->text_domain). '</a>', $copy_invoice_to_clipboard);

        return sprintf('%1$s %2$s', $license['id'], $this->row_actions($actions) );
    }


    public function process_bulk_action() {
        wp_redirect(home_url());

    }


    /**
     * Outputs the hidden row displayed when inline editing
     *
     * @since 3.1.0
     *
     * @global string $mode List table view mode.
     */
    public function inline_edit() {
        global $mode;

        $screen = $this->screen;

        $post             = get_default_post_to_edit( $screen->post_type );
        $post_type_object = get_post_type_object( $screen->post_type );

        $taxonomy_names          = get_object_taxonomies( $screen->post_type );
        $hierarchical_taxonomies = array();
        $flat_taxonomies         = array();

        foreach ( $taxonomy_names as $taxonomy_name ) {
            $taxonomy = get_taxonomy( $taxonomy_name );

            $show_in_quick_edit = $taxonomy->show_in_quick_edit;

            /**
             * Filters whether the current taxonomy should be shown in the Quick Edit panel.
             *
             * @since 4.2.0
             *
             * @param bool   $show_in_quick_edit Whether to show the current taxonomy in Quick Edit.
             * @param string $taxonomy_name      Taxonomy name.
             * @param string $post_type          Post type of current Quick Edit post.
             */
            if ( ! apply_filters( 'quick_edit_show_taxonomy', $show_in_quick_edit, $taxonomy_name, $screen->post_type ) ) {
                continue;
            }

            if ( $taxonomy->hierarchical ) {
                $hierarchical_taxonomies[] = $taxonomy;
            } else {
                $flat_taxonomies[] = $taxonomy;
            }
        }

        $m            = ( isset( $mode ) && 'excerpt' === $mode ) ? 'excerpt' : 'list';
        $can_publish  = current_user_can( $post_type_object->cap->publish_posts );
        $core_columns = array(
            'cb'         => true,
            'date'       => true,
            'title'      => true,
            'categories' => true,
            'tags'       => true,
            'comments'   => true,
            'author'     => true,
        );
        ?>

        <form method="get">
            <table style="display: none"><tbody id="inlineedit">
                <?php
                $hclass              = count( $hierarchical_taxonomies ) ? 'post' : 'page';
                $inline_edit_classes = "inline-edit-row inline-edit-row-$hclass";
                $bulk_edit_classes   = "bulk-edit-row bulk-edit-row-$hclass bulk-edit-{$screen->post_type}";
                $quick_edit_classes  = "quick-edit-row quick-edit-row-$hclass inline-edit-{$screen->post_type}";

                $bulk = 0;

                while ( $bulk < 2 ) :
                    $classes  = $inline_edit_classes . ' ';
                    $classes .= $bulk ? $bulk_edit_classes : $quick_edit_classes;
                    ?>
                    <tr id="<?php echo $bulk ? 'bulk-edit' : 'inline-edit'; ?>" class="<?php echo $classes; ?>" style="display: none">
                        <td colspan="<?php echo $this->get_column_count(); ?>" class="colspanchange">

                            <fieldset class="inline-edit-col-left">
                                <legend class="inline-edit-legend"><?php echo $bulk ? __( 'Bulk Edit' ) : __( 'Quick Edit' ); ?></legend>
                                <div class="inline-edit-col">

                                    <?php if ( post_type_supports( $screen->post_type, 'title' ) ) : ?>

                                        <?php if ( $bulk ) : ?>

                                            <div id="bulk-title-div">
                                                <div id="bulk-titles"></div>
                                            </div>

                                        <?php else : // $bulk ?>

                                            <label>
                                                <span class="title"><?php _e( 'Title' ); ?></span>
                                                <span class="input-text-wrap"><input type="text" name="post_title" class="ptitle" value="" /></span>
                                            </label>

                                            <?php if ( is_post_type_viewable( $screen->post_type ) ) : ?>

                                                <label>
                                                    <span class="title"><?php _e( 'Slug' ); ?></span>
                                                    <span class="input-text-wrap"><input type="text" name="post_name" value="" /></span>
                                                </label>

                                            <?php endif; // is_post_type_viewable() ?>

                                        <?php endif; // $bulk ?>

                                    <?php endif; // post_type_supports( ... 'title' ) ?>

                                    <?php if ( ! $bulk ) : ?>
                                        <fieldset class="inline-edit-date">
                                            <legend><span class="title"><?php _e( 'Date' ); ?></span></legend>
                                            <?php touch_time( 1, 1, 0, 1 ); ?>
                                        </fieldset>
                                        <br class="clear" />
                                    <?php endif; // $bulk ?>

                                    <?php
                                    if ( post_type_supports( $screen->post_type, 'author' ) ) {
                                        $authors_dropdown = '';

                                        if ( current_user_can( $post_type_object->cap->edit_others_posts ) ) {
                                            $users_opt = array(
                                                'hide_if_only_one_author' => false,
                                                'who'                     => 'authors',
                                                'name'                    => 'post_author',
                                                'class'                   => 'authors',
                                                'multi'                   => 1,
                                                'echo'                    => 0,
                                                'show'                    => 'display_name_with_login',
                                            );

                                            if ( $bulk ) {
                                                $users_opt['show_option_none'] = __( '&mdash; No Change &mdash;' );
                                            }

                                            /**
                                             * Filters the arguments used to generate the Quick Edit authors drop-down.
                                             *
                                             * @since 5.6.0
                                             *
                                             * @see wp_dropdown_users()
                                             *
                                             * @param array $users_opt An array of arguments passed to wp_dropdown_users().
                                             * @param bool  $bulk      A flag to denote if it's a bulk action.
                                             */
                                            $users_opt = apply_filters( 'quick_edit_dropdown_authors_args', $users_opt, $bulk );

                                            $authors = wp_dropdown_users( $users_opt );

                                            if ( $authors ) {
                                                $authors_dropdown  = '<label class="inline-edit-author">';
                                                $authors_dropdown .= '<span class="title">' . __( 'Author' ) . '</span>';
                                                $authors_dropdown .= $authors;
                                                $authors_dropdown .= '</label>';
                                            }
                                        } // current_user_can( 'edit_others_posts' )

                                        if ( ! $bulk ) {
                                            echo $authors_dropdown;
                                        }
                                    } // post_type_supports( ... 'author' )
                                    ?>

                                    <?php if ( ! $bulk && $can_publish ) : ?>

                                        <div class="inline-edit-group wp-clearfix">
                                            <label class="alignleft">
                                                <span class="title"><?php _e( 'Password' ); ?></span>
                                                <span class="input-text-wrap"><input type="text" name="post_password" class="inline-edit-password-input" value="" /></span>
                                            </label>

                                            <span class="alignleft inline-edit-or">
                            <?php
                            /* translators: Between password field and private checkbox on post quick edit interface. */
                            _e( '&ndash;OR&ndash;' );
                            ?>
                        </span>
                                            <label class="alignleft inline-edit-private">
                                                <input type="checkbox" name="keep_private" value="private" />
                                                <span class="checkbox-title"><?php _e( 'Private' ); ?></span>
                                            </label>
                                        </div>

                                    <?php endif; ?>

                                </div>
                            </fieldset>

                            <?php if ( count( $hierarchical_taxonomies ) && ! $bulk ) : ?>

                                <fieldset class="inline-edit-col-center inline-edit-categories">
                                    <div class="inline-edit-col">

                                        <?php foreach ( $hierarchical_taxonomies as $taxonomy ) : ?>

                                            <span class="title inline-edit-categories-label"><?php echo esc_html( $taxonomy->labels->name ); ?></span>
                                            <input type="hidden" name="<?php echo ( 'category' === $taxonomy->name ) ? 'post_category[]' : 'tax_input[' . esc_attr( $taxonomy->name ) . '][]'; ?>" value="0" />
                                            <ul class="cat-checklist <?php echo esc_attr( $taxonomy->name ); ?>-checklist">
                                                <?php wp_terms_checklist( null, array( 'taxonomy' => $taxonomy->name ) ); ?>
                                            </ul>

                                        <?php endforeach; // $hierarchical_taxonomies as $taxonomy ?>

                                    </div>
                                </fieldset>

                            <?php endif; // count( $hierarchical_taxonomies ) && ! $bulk ?>

                            <fieldset class="inline-edit-col-right">
                                <div class="inline-edit-col">

                                    <?php
                                    if ( post_type_supports( $screen->post_type, 'author' ) && $bulk ) {
                                        echo $authors_dropdown;
                                    }
                                    ?>

                                    <?php if ( post_type_supports( $screen->post_type, 'page-attributes' ) ) : ?>

                                        <?php if ( $post_type_object->hierarchical ) : ?>

                                            <label>
                                                <span class="title"><?php _e( 'Parent' ); ?></span>
                                                <?php
                                                $dropdown_args = array(
                                                    'post_type'         => $post_type_object->name,
                                                    'selected'          => $post->post_parent,
                                                    'name'              => 'post_parent',
                                                    'show_option_none'  => __( 'Main Page (no parent)' ),
                                                    'option_none_value' => 0,
                                                    'sort_column'       => 'menu_order, post_title',
                                                );

                                                if ( $bulk ) {
                                                    $dropdown_args['show_option_no_change'] = __( '&mdash; No Change &mdash;' );
                                                }

                                                /**
                                                 * Filters the arguments used to generate the Quick Edit page-parent drop-down.
                                                 *
                                                 * @since 2.7.0
                                                 * @since 5.6.0 The `$bulk` parameter was added.
                                                 *
                                                 * @see wp_dropdown_pages()
                                                 *
                                                 * @param array $dropdown_args An array of arguments passed to wp_dropdown_pages().
                                                 * @param bool  $bulk          A flag to denote if it's a bulk action.
                                                 */
                                                $dropdown_args = apply_filters( 'quick_edit_dropdown_pages_args', $dropdown_args, $bulk );

                                                wp_dropdown_pages( $dropdown_args );
                                                ?>
                                            </label>

                                        <?php endif; // hierarchical ?>

                                        <?php if ( ! $bulk ) : ?>

                                            <label>
                                                <span class="title"><?php _e( 'Order' ); ?></span>
                                                <span class="input-text-wrap"><input type="text" name="menu_order" class="inline-edit-menu-order-input" value="<?php echo $post->menu_order; ?>" /></span>
                                            </label>

                                        <?php endif; // ! $bulk ?>

                                    <?php endif; // post_type_supports( ... 'page-attributes' ) ?>

                                    <?php if ( 0 < count( get_page_templates( null, $screen->post_type ) ) ) : ?>

                                        <label>
                                            <span class="title"><?php _e( 'Template' ); ?></span>
                                            <select name="page_template">
                                                <?php if ( $bulk ) : ?>
                                                    <option value="-1"><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                <?php endif; // $bulk ?>
                                                <?php
                                                /** This filter is documented in wp-admin/includes/meta-boxes.php */
                                                $default_title = apply_filters( 'default_page_template_title', __( 'Default template' ), 'quick-edit' );
                                                ?>
                                                <option value="default"><?php echo esc_html( $default_title ); ?></option>
                                                <?php page_template_dropdown( '', $screen->post_type ); ?>
                                            </select>
                                        </label>

                                    <?php endif; ?>

                                    <?php if ( count( $flat_taxonomies ) && ! $bulk ) : ?>

                                        <?php foreach ( $flat_taxonomies as $taxonomy ) : ?>

                                            <?php if ( current_user_can( $taxonomy->cap->assign_terms ) ) : ?>
                                                <?php $taxonomy_name = esc_attr( $taxonomy->name ); ?>

                                                <label class="inline-edit-tags">
                                                    <span class="title"><?php echo esc_html( $taxonomy->labels->name ); ?></span>
                                                    <textarea data-wp-taxonomy="<?php echo $taxonomy_name; ?>" cols="22" rows="1" name="tax_input[<?php echo $taxonomy_name; ?>]" class="tax_input_<?php echo $taxonomy_name; ?>"></textarea>
                                                </label>

                                            <?php endif; // current_user_can( 'assign_terms' ) ?>

                                        <?php endforeach; // $flat_taxonomies as $taxonomy ?>

                                    <?php endif; // count( $flat_taxonomies ) && ! $bulk ?>

                                    <?php if ( post_type_supports( $screen->post_type, 'comments' ) || post_type_supports( $screen->post_type, 'trackbacks' ) ) : ?>

                                        <?php if ( $bulk ) : ?>

                                            <div class="inline-edit-group wp-clearfix">

                                                <?php if ( post_type_supports( $screen->post_type, 'comments' ) ) : ?>

                                                    <label class="alignleft">
                                                        <span class="title"><?php _e( 'Comments' ); ?></span>
                                                        <select name="comment_status">
                                                            <option value=""><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                            <option value="open"><?php _e( 'Allow' ); ?></option>
                                                            <option value="closed"><?php _e( 'Do not allow' ); ?></option>
                                                        </select>
                                                    </label>

                                                <?php endif; ?>

                                                <?php if ( post_type_supports( $screen->post_type, 'trackbacks' ) ) : ?>

                                                    <label class="alignright">
                                                        <span class="title"><?php _e( 'Pings' ); ?></span>
                                                        <select name="ping_status">
                                                            <option value=""><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                            <option value="open"><?php _e( 'Allow' ); ?></option>
                                                            <option value="closed"><?php _e( 'Do not allow' ); ?></option>
                                                        </select>
                                                    </label>

                                                <?php endif; ?>

                                            </div>

                                        <?php else : // $bulk ?>

                                            <div class="inline-edit-group wp-clearfix">

                                                <?php if ( post_type_supports( $screen->post_type, 'comments' ) ) : ?>

                                                    <label class="alignleft">
                                                        <input type="checkbox" name="comment_status" value="open" />
                                                        <span class="checkbox-title"><?php _e( 'Allow Comments' ); ?></span>
                                                    </label>

                                                <?php endif; ?>

                                                <?php if ( post_type_supports( $screen->post_type, 'trackbacks' ) ) : ?>

                                                    <label class="alignleft">
                                                        <input type="checkbox" name="ping_status" value="open" />
                                                        <span class="checkbox-title"><?php _e( 'Allow Pings' ); ?></span>
                                                    </label>

                                                <?php endif; ?>

                                            </div>

                                        <?php endif; // $bulk ?>

                                    <?php endif; // post_type_supports( ... comments or pings ) ?>

                                    <div class="inline-edit-group wp-clearfix">

                                        <label class="inline-edit-status alignleft">
                                            <span class="title"><?php _e( 'Status' ); ?></span>
                                            <select name="_status">
                                                <?php if ( $bulk ) : ?>
                                                    <option value="-1"><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                <?php endif; // $bulk ?>

                                                <?php if ( $can_publish ) : // Contributors only get "Unpublished" and "Pending Review". ?>
                                                    <option value="publish"><?php _e( 'Published' ); ?></option>
                                                    <option value="future"><?php _e( 'Scheduled' ); ?></option>
                                                    <?php if ( $bulk ) : ?>
                                                        <option value="private"><?php _e( 'Private' ); ?></option>
                                                    <?php endif; // $bulk ?>
                                                <?php endif; ?>

                                                <option value="pending"><?php _e( 'Pending Review' ); ?></option>
                                                <option value="draft"><?php _e( 'Draft' ); ?></option>
                                            </select>
                                        </label>

                                        <?php if ( 'post' === $screen->post_type && $can_publish && current_user_can( $post_type_object->cap->edit_others_posts ) ) : ?>

                                            <?php if ( $bulk ) : ?>

                                                <label class="alignright">
                                                    <span class="title"><?php _e( 'Sticky' ); ?></span>
                                                    <select name="sticky">
                                                        <option value="-1"><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                        <option value="sticky"><?php _e( 'Sticky' ); ?></option>
                                                        <option value="unsticky"><?php _e( 'Not Sticky' ); ?></option>
                                                    </select>
                                                </label>

                                            <?php else : // $bulk ?>

                                                <label class="alignleft">
                                                    <input type="checkbox" name="sticky" value="sticky" />
                                                    <span class="checkbox-title"><?php _e( 'Make this post sticky' ); ?></span>
                                                </label>

                                            <?php endif; // $bulk ?>

                                        <?php endif; // 'post' && $can_publish && current_user_can( 'edit_others_posts' ) ?>

                                    </div>

                                    <?php if ( $bulk && current_theme_supports( 'post-formats' ) && post_type_supports( $screen->post_type, 'post-formats' ) ) : ?>
                                        <?php $post_formats = get_theme_support( 'post-formats' ); ?>

                                        <label class="alignleft">
                                            <span class="title"><?php _ex( 'Format', 'post format' ); ?></span>
                                            <select name="post_format">
                                                <option value="-1"><?php _e( '&mdash; No Change &mdash;' ); ?></option>
                                                <option value="0"><?php echo get_post_format_string( 'standard' ); ?></option>
                                                <?php if ( is_array( $post_formats[0] ) ) : ?>
                                                    <?php foreach ( $post_formats[0] as $format ) : ?>
                                                        <option value="<?php echo esc_attr( $format ); ?>"><?php echo esc_html( get_post_format_string( $format ) ); ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </label>

                                    <?php endif; ?>

                                </div>
                            </fieldset>

                            <?php
                            list( $columns ) = $this->get_column_info();

                            foreach ( $columns as $column_name => $column_display_name ) {
                                if ( isset( $core_columns[ $column_name ] ) ) {
                                    continue;
                                }

                                if ( $bulk ) {

                                    /**
                                     * Fires once for each column in Bulk Edit mode.
                                     *
                                     * @since 2.7.0
                                     *
                                     * @param string $column_name Name of the column to edit.
                                     * @param string $post_type   The post type slug.
                                     */
                                    do_action( 'bulk_edit_custom_box', $column_name, $screen->post_type );
                                } else {

                                    /**
                                     * Fires once for each column in Quick Edit mode.
                                     *
                                     * @since 2.7.0
                                     *
                                     * @param string $column_name Name of the column to edit.
                                     * @param string $post_type   The post type slug, or current screen name if this is a taxonomy list table.
                                     * @param string $taxonomy    The taxonomy name, if any.
                                     */
                                    do_action( 'quick_edit_custom_box', $column_name, $screen->post_type, '' );
                                }
                            }
                            ?>

                            <div class="submit inline-edit-save">
                                <button type="button" class="button cancel alignleft"><?php _e( 'Cancel' ); ?></button>

                                <?php if ( ! $bulk ) : ?>
                                    <?php wp_nonce_field( 'inlineeditnonce', '_inline_edit', false ); ?>
                                    <button type="button" class="button button-primary save alignright"><?php _e( 'Update' ); ?></button>
                                    <span class="spinner"></span>
                                <?php else : ?>
                                    <?php submit_button( __( 'Update' ), 'primary alignright', 'bulk_edit', false ); ?>
                                <?php endif; ?>

                                <input type="hidden" name="post_view" value="<?php echo esc_attr( $m ); ?>" />
                                <input type="hidden" name="screen" value="<?php echo esc_attr( $screen->id ); ?>" />
                                <?php if ( ! $bulk && ! post_type_supports( $screen->post_type, 'author' ) ) : ?>
                                    <input type="hidden" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
                                <?php endif; ?>
                                <br class="clear" />

                                <div class="notice notice-error notice-alt inline hidden">
                                    <p class="error"></p>
                                </div>
                            </div>

                        </td></tr>

                    <?php
                    $bulk++;
                endwhile;
                ?>
                </tbody></table>
        </form>
        <?php
    }


}

