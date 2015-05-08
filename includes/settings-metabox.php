<?php

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'bpp_meta_box', 'bpp_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, 'bpp_disable_pinit', true );
?>
    <label for="bpp_disable_pinit">
    <input type="checkbox" id="bpp_disable_pinit" name="bpp_disable_pinit" value="1" <?php checked( 1 == $value ); ?> />
    Disable Pin It button for all images in this post
    </label>
