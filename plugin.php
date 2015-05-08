<?php
/*
Plugin Name: Simply Pinterest
Plugin URI: https://github.com/terriann/betterpinterestplugin
Description: Simply Pinterest is a WordPress plugin designed to be light weight, easy to use while achieving one goal: making it easy for your visitors to share your content on Pinterest. This plugin puts a Pinterest button over the corner of each image with customizabele options making it clear & easy for your visitors to share your content with their followers.
Version: 1.1
Author: Terri Ann Swallow
Author URI: http://terriswallow.com/
License: GPLv2
*/

define('BPP_PLUGIN_FILE', __FILE__);

require_once( dirname(__FILE__) . '/includes/simple-pinterest-base.php' );
/**
 * Load & activate front end manipulation for front end facing site only
 */
require_once( dirname(__FILE__) . '/includes/simple-pinterest-plugin.php' );
add_action( 'init', array( 'Simple_Pinterest_Plugin', 'init' ) );


/**
 * Load & activate admin manipulation for admin site only
 *
 * @todo check if this should just be wrapped in is_admin() rather than relying on admin_init?
 */
require_once( dirname(__FILE__) . '/includes/simple-pinterest-plugin-admin.php' );
add_action( 'admin_init', array( 'Simple_Pinterest_Plugin_Admin', 'admin_init' ) );

// Some things apparently need to be called on init not admin_init....Grrr wordpress
add_action('init', array( 'Simple_Pinterest_Plugin_Admin', 'init' ) );

// When the plugin is activated, set defaults
register_activation_hook( __FILE__, array( 'Simple_Pinterest_Plugin_Admin', 'settings_default' ) );
// When the plugin is deactivated, remove options from database
register_deactivation_hook( __FILE__, array( 'Simple_Pinterest_Plugin_Admin', 'settings_remove' ) );



/* Combatting tinyMCE's hatreat of all things not typical
https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
https://www.leighton.com/blog/stop-tinymce-in-wordpress-3-x-messing-up-your-html-code
*/
// This should not be released this way, it allows all kinds of HTML - I really just want to add nopin as an ATTR to img but that seems impossible....Sigh
function myformatTinyMCE($initArray) {
    $initArray['verify_html'] = false;
    return $initArray;
}
//add_filter('tiny_mce_before_init', 'myformatTinyMCE' );

/**
 * Add to extended_valid_elements for TinyMCE
 *
 * @param $init assoc. array of TinyMCE options
 * @return $init the changed assoc. array
 */
function change_mce_options( $init ) {
 //code that adds additional attributes to the pre tag
 $ext = "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|id|style|nopin|data-bpp-pinhover]";

 //if extended_valid_elements alreay exists, add to it
 //otherwise, set the extended_valid_elements to $ext
 if ( isset( $init['extended_valid_elements'] ) ) {
  $init['extended_valid_elements'] .= ',' . $ext;
 } else {
  $init['extended_valid_elements'] = $ext;
 }

 //important: return $init!
 return $init;
}
add_filter('tiny_mce_before_init', 'change_mce_options');



// This prevents wordpress from stripping out additional attributes on elements - This code seems good to go.
add_action( 'init', 'kses_allow_nopin_on_img' );
/**
 * Prevent Kses from eatting nopin attribute
 * Source: https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 * @return null
 */
function kses_allow_nopin_on_img()
{
    global $allowedposttags;

    $tags = array( 'img' );
    $new_attributes = array( 'nopin' => true, 'data-bpp-pinhover' => true);

    foreach( $tags as $tag ) {
        if( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
            $allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
        }
    }
}
