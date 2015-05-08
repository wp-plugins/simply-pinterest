<?php

    /**
     * Class that manages manipulation on the admin in wordpress
     */

    class Simple_Pinterest_Plugin_Admin  extends Simple_Pinterest_Base {

        public static function admin_init()
        {
            // Enqueue editor things - used in post.php and pages.php
            add_action( 'wp_enqueue_editor', array( __CLASS__, 'enqueue' ), 10, 1 );
            add_action( 'print_media_templates', array( __CLASS__, 'template' ) );

            // Add settings link under plugin actions on plugins page
            add_filter( 'plugin_action_links_' . plugin_basename(BPP_PLUGIN_FILE), array( __CLASS__, 'plugin_action_links') );

            // Adds sidebar metabox to disable spp on a per post basis
            add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
            // Saves all metadata for quiltalongs
            add_action( 'save_post', array( __CLASS__, 'save_meta_box_data' ) );
        }

        public static function init()
        {
            // create custom plugin settings menu
            add_action('admin_menu', array(  __CLASS__, 'create_settings_menu' ) );
            // registeres settings so POST knows to look for them
            add_action('admin_init', array(  __CLASS__, 'register_settings' ) );
        }


        public static function enqueue( $options )
        {

            if ( $options['tinymce'] ) {
                // Note: An additional dependency "media-views" is not listed below
                // because in some cases such as /wp-admin/press-this.php the media
                // library isn't enqueued and shouldn't be. The script includes
                // safeguards to avoid errors in this situation
                wp_enqueue_script( 'advanced-pinterest-settings', plugins_url( 'scripts/advanced-pinterest-settings.js', BPP_PLUGIN_FILE), array( 'jquery' ), self::VERSION, true );
            }
        }

        /**
         * Backbone template for advanced settings through editing an image in the visual editor for posts/pages
         * @return null
         */
        public static function template()
        {
            include( plugin_dir_path(BPP_PLUGIN_FILE) . 'templates/advanced-pinterest-settings-tmpl.php');
        }

        /**
         * Register settings so wordpress knows to update them when editing plugin settings
         * @return null
         */
        public static function register_settings()
        {
            //register our settings
            register_setting( 'bpp-settings-group', 'bpp_color' );
            register_setting( 'bpp-settings-group', 'bpp_onhover' );
            register_setting( 'bpp-settings-group', 'bpp_corner' );
            register_setting( 'bpp-settings-group', 'bpp_size', 'intval' );
            register_setting( 'bpp-settings-group', 'bpp_lang' );
            register_setting( 'bpp-settings-group', 'bpp_count' );
            register_setting( 'bpp-settings-group', 'bpp_load' );
            register_setting( 'bpp-settings-group', 'bpp_load_jq' );
            register_setting( 'bpp-settings-group', 'bpp_description_append', 'trim' );
            register_setting( 'bpp-settings-group', 'bpp_pagetype' );
            register_setting( 'bpp-settings-group', 'bpp_important' );
        }


        public static function settings_default()
        {
            // Set default values
            self::update_option('bpp_color', 'red');
            self::update_option('bpp_onhover', 'false');
            self::update_option('bpp_corner', 'northeast');
            self::update_option('bpp_size', 20);
            self::update_option('bpp_lang', 'en');
            self::update_option('bpp_count', 'above');
            self::update_option('bpp_load', 'async');
            self::update_option('bpp_load_jq', '');
            self::update_option('bpp_description_append', '');
            self::update_option('bpp_pagetype', array('posts','pages','home','archives'));
            self::update_option('bpp_important', '');
        }

        public static function update_option($name, $value)
        {
            if (get_option($name) !== false) {
                update_option( $name, $new_value );
            } else {
                add_option( $name, $value);
            }
        }

        public static function settings_remove()
        {
            self::settings_remove_deprecated();

            delete_option('bpp_color');
            delete_option('bpp_onhover');
            delete_option('bpp_corner');
            delete_option('bpp_size');
            delete_option('bpp_lang');
            delete_option('bpp_count');
            delete_option('bpp_load');
            delete_option('bpp_load_jq');
            delete_option('bpp_description_append');
            delete_option('bpp_pagetype');
            delete_option('bpp_important');
        }

        public static function settings_remove_deprecated()
        {
            // @deprecated
            delete_option('bpp_description_end');
            delete_option('bpp_loadasync');
        }

        /**
         * Add submenu under settings
         * @return null
         */
        public static  function create_settings_menu()
        {
            add_submenu_page( 'options-general.php', 'Simply Pinterest Settings', 'Pinterest Settings', 'update_plugins', 'settings_spp', array( __CLASS__, 'settings_page' ) );
        }

        public static function settings_page() {
            include('settings-page.php');
        }

        public static function meta_box($post) {
            include('settings-metabox.php');
        }

        public static function plugin_action_links( $links ) {
           $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=settings_spp') .'">Settings</a>';
           $links[] = '<a href="https://github.com/terriann/simple-pinterest-plugin/wiki" target="_blank">Wiki</a>';
           return $links;
        }





        // DAAAAAA Meta Boxes


        public static function add_meta_box()
        {

            $screens = array( 'post', 'page' );

            foreach ( $screens as $screen ) {
                add_meta_box(
                    'bpp_metabox_config',
                    __( 'Simply Pinterest Settings'),
                    array( __CLASS__, 'meta_box' ),
                    $screen,
                    'side'
                );
            }
        }






        /**
         * When the post is saved, saves our custom data.
         *
         * @param int $post_id The ID of the post being saved.
         */
        public static function save_meta_box_data( $post_id ) {

            /*
             * We need to verify this came from our screen and with proper authorization,
             * because the save_post action can be triggered at other times.
             */

            // Check if our nonce is set.
            if ( ! isset( $_POST['bpp_meta_box_nonce'] ) ) {
                return;
            }

            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $_POST['bpp_meta_box_nonce'], 'bpp_meta_box' ) ) {
                return;
            }

            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // Check the user's permissions.
            if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

                if ( ! current_user_can( 'edit_page', $post_id ) ) {
                    return;
                }

            } else {

                if ( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                }
            }

            /* OK, it's safe for us to save the data now. */

            // If it's not set then make sure there's no unnecessary post meta empty value hanging around
            if ( ! isset( $_POST['bpp_disable_pinit'] ) ) {
                delete_post_meta( $post_id, 'bpp_disable_pinit' );
                return;
            }

            // Sanitize user input.
            $value = sanitize_text_field( $_POST['bpp_disable_pinit'] );
            // Update the meta field in the database.
            update_post_meta( $post_id, 'bpp_disable_pinit', $value );
        }


    }
