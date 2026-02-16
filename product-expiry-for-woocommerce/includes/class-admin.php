<?php
namespace WOOPE;

if ( ! defined( 'ABSPATH' ) ) exit;

class Admin {

    public function __construct() {

        // Settings submenu
        add_action(
            'admin_menu',
            [ $this, 'add_settings_page' ]
        );

        // AJAX save
        add_action(
            'wp_ajax_woope_save_admin_settings',
            [ $this, 'save_settings' ]
        );

        // Admin scripts
        add_action(
            'admin_enqueue_scripts',
            [ $this, 'enqueue_scripts' ]
        );

        // Plugin quick settings link
        add_filter(
            'plugin_action_links',
            [ $this, 'add_settings_link' ],
            10,
            2
        );
    }

    /* -------------------------------------------------------------
     *  ADD SETTINGS PAGE
     * ----------------------------------------------------------- */

    public function add_settings_page() {

        add_submenu_page(
            'edit.php?post_type=product',
            __( 'Product Expiry Settings', 'product-expiry-for-woocommerce' ),
            __( 'Expiry Settings', 'product-expiry-for-woocommerce' ),
            'manage_options',
            'products_expiry_settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function render_settings_page() {

        include WOOPE_PATH . 'admin/views/settings.php';
    }

    /* -------------------------------------------------------------
     *  AJAX SAVE SETTINGS
     * ----------------------------------------------------------- */

    public function save_settings() {

        if (
            ! isset( $_POST['woope_save_admin_settings_nonce'] ) ||
            ! wp_verify_nonce(
                $_POST['woope_save_admin_settings_nonce'],
                'woope_save_admin_settings_nonce'
            ) ||
            ! current_user_can( 'manage_options' )
        ) {
            wp_die( __( 'Security check failed.', 'product-expiry-for-woocommerce' ) );
        }

        $settings = [
            'single_hook'        => sanitize_text_field( $_POST['single_hook'] ?? '' ),
            'archive_hook'       => sanitize_text_field( $_POST['archive_hook'] ?? '' ),
            'date_format'        => sanitize_text_field( $_POST['date_format'] ?? '' ),
            'notify_emails'      => sanitize_text_field( $_POST['notify_emails'] ?? '' ),
            'display'            => sanitize_text_field( $_POST['display'] ?? '' ),
            'orderdetails'       => sanitize_text_field( $_POST['orderdetails'] ?? '' ),
            'orderdetailsadmin'  => sanitize_text_field( $_POST['orderdetailsadmin'] ?? '' ),
            'markup'             => wp_kses_post( $_POST['markup'] ?? '' ),
            'notify_on_expired'  => sanitize_text_field( $_REQUEST['notify_on_expired'] ?? 'enable' ),
            'notify_before_days' => sanitize_text_field( $_REQUEST['notify_before_days'] ?? '' ),
            'email_subject'      => sanitize_text_field( $_REQUEST['email_subject'] ?? '' ),
            'email_body'         => wp_kses_post( $_REQUEST['email_body'] ?? '' ),            
        ];

        $updated = update_option(
            'woope_admin_settings',
            $settings
        );

        /*
         * Preserve WPML integration
         */
        if ( isset( $_POST['markup'] ) ) {

            do_action(
                'wpml_register_single_string',
                'product-expiry-for-woocommerce',
                'date-markup',
                sanitize_text_field( $_POST['markup'] )
            );
        }

        if ( $updated ) {
            echo __( 'Settings Saved!', 'product-expiry-for-woocommerce' );
        } else {
            echo __( 'Unable to update, or no changes detected.', 'product-expiry-for-woocommerce' );
        }

        wp_die();
    }

    /* -------------------------------------------------------------
     *  ADMIN SCRIPTS
     * ----------------------------------------------------------- */

    public function enqueue_scripts( $hook ) {

        global $post;

        // Product edit screen
        if ( $hook === 'post-new.php' || $hook === 'post.php' ) {

            if ( isset( $post->post_type ) && $post->post_type === 'product' ) {

                wp_enqueue_script(
                    'woope-product-meta',
                    WOOPE_URL . 'assets/js/trigger-date-picker.js',
                    [ 'wc-admin-product-meta-boxes' ],
                    WOOPE_VERSION,
                    true
                );
            }
        }

        // Settings page
        if ( $hook === 'product_page_products_expiry_settings' ) {
            wp_enqueue_style(
                'woope-admin-style',
                WOOPE_URL . 'assets/css/admin.css',
                [],
                WOOPE_VERSION
            );

            wp_enqueue_script(
                'woope-admin',
                WOOPE_URL . 'assets/js/admin.js',
                [ 'jquery' ],
                WOOPE_VERSION,
                true
            );

            wp_localize_script(
                'woope-admin',
                'woope_admin',
                [
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'nonce'    => wp_create_nonce( 'woope_save_admin_settings_nonce' ),
                ]
            );
        }
    }

    /* -------------------------------------------------------------
     *  PLUGIN SETTINGS LINK
     * ----------------------------------------------------------- */

    public function add_settings_link( $links, $file ) {

        if ( strpos( $file, 'product-expiry-for-woocommerce.php' ) !== false ) {

            $settings_url = admin_url(
                'edit.php?post_type=product&page=products_expiry_settings'
            );

            $links[] = '<a href="' . esc_url( $settings_url ) . '">' .
                __( 'Settings', 'product-expiry-for-woocommerce' ) .
                '</a>';
        }

        return $links;
    }
}