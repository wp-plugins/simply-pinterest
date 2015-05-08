            <div class="wrap" id="bpp_pin_plugin_admin">
            <h2>Simply Pinterest - a WordPress Plugin</h2>

            <p>This plugin allows for the same options listed on the <a href="https://business.pinterest.com/en/widget-builder#do_pin_it_button" target="_Blank">Pinterest widget builder</a> page to be applied to all the images in your post unless otherwise specified.  We respect the <code>nopin="nopin"</code> attribute and will not show the button on an image smaller than 200px wide.</p>
            <p>Pinterest recommends that your images be a minimum of 600px wide.</p>

            <form method="post" action="options.php">
                <?php
                    // this outputs the
                    settings_fields( 'bpp-settings-group' );
                    // This could be moved to a constructor once the plugin is class based
                    do_settings_sections( 'bpp-settings-group' );
                ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Pin it Button Color</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Red"><input type="radio" name="bpp_color" value="red"<?php checked( 'red' == get_option('bpp_color') ); ?>> <span>Red</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            <label title="White"><input type="radio" name="bpp_color" value="white"<?php checked( 'white' == get_option('bpp_color') ); ?>> <span>White</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_white_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            <label title="Gray"><input type="radio" name="bpp_color" value="gray"<?php checked( 'gray' == get_option('bpp_color') ); ?>> <span>Gray</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_gray_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Size</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Size</span></legend>
                            <label title="Large"><input type="radio" name="bpp_size" value="28"<?php checked( '28' == get_option('bpp_size') ); ?>> <span>Large (28px)</span>  <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            <label title="Small"><input type="radio" name="bpp_size" value="20"<?php checked( '20' == get_option('bpp_size') ); ?>> <span>Small (20px)</span>  <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_20.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Corner</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Corner</span></legend>
                            <label title="Northwest"><input type="radio" name="bpp_corner" value="northwest"<?php checked( 'northwest' == get_option('bpp_corner') ); ?>> <span>Northwest (top left)</span></label><br>
                            <label title="Northeast"><input type="radio" name="bpp_corner" value="northeast"<?php checked( 'northeast' == get_option('bpp_corner') ); ?>> <span>Northeast (top right)</span></label><br>
                            <label title="Southwest"><input type="radio" name="bpp_corner" value="southwest"<?php checked( 'southwest' == get_option('bpp_corner') ); ?>> <span>Southwest (bottom left)</span></label><br>
                            <label title="Southeast"><input type="radio" name="bpp_corner" value="southeast"<?php checked( 'southeast' == get_option('bpp_corner') ); ?>> <span>Southeast (bottom right)</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Count</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Count</span></legend>
                            <label title="Above the button"><input type="radio" name="bpp_count" value="above"<?php checked( 'above' == get_option('bpp_count') ); ?>> <span>Above the button</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28-above.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            <label title="Beside the button"><input type="radio" name="bpp_count" value="beside"<?php checked( 'beside' == get_option('bpp_count') ); ?>> <span>Beside the button (<em>If count is 0 no numbers show</em>)</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28-side.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            <label title="None"><input type="radio" name="bpp_count" value="none"<?php checked( 'none' == get_option('bpp_count') ); ?>> <span>None</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Hover Settings</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Hover Settings</span></legend>
                            <label title="Show on Hover Only"><input type="radio" name="bpp_onhover" value="true"<?php checked( 'true' == get_option('bpp_onhover') ); ?>> <span>Only show Pin it button on hover/mouseover</span></label><br>
                            <label title="Always Show Pin"><input type="radio" name="bpp_onhover" value="false"<?php checked( 'false' == get_option('bpp_onhover') ); ?>> <span>Always show pin it button</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">What Pages Types Should this Apply To</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>What Pages Types Should this Apply To</span></legend>
                            <?php
                                // Needed only for serilialized array storage
                                $options = get_option('bpp_pagetype');
                                if(!is_array($options)) {
                                    $options = array();
                                }
                            ?>
                            <label title="Posts"><input type="checkbox" name="bpp_pagetype[]" value="posts"<?php checked( in_array('posts', $options) ); ?>> <span>Posts</span></label><br>
                            <label title="Pages"><input type="checkbox" name="bpp_pagetype[]" value="pages"<?php checked( in_array('pages', $options) ); ?>> <span>Pages</span></label><br>
                            <label title="Home"><input type="checkbox" name="bpp_pagetype[]" value="home"<?php checked( in_array('home', $options) ); ?>> <span>Home</span></label><br>
                            <label title="Archives"><input type="checkbox" name="bpp_pagetype[]" value="archives"<?php checked( in_array('archives', $options) ); ?>> <span>Archives</span></label><br>
                            <label title="Search"><input type="checkbox" name="bpp_pagetype[]" value="search"<?php checked( in_array('search', $options) ); ?>> <span>Search</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Append to description</th>
                    <td>
                        <p>If you have a string you'd like to always append to a Pin's description</p>
                        <fieldset>
                            <legend class="screen-reader-text"><span>End description with</span></legend>
                            <label title="end of description"><input type="text" class="regular-text" name="bpp_description_append" value="<?php echo esc_attr(get_option('bpp_description_append')); ?>"></label>
                        </fieldset>
                    </td>
                    </tr>
                </table>
                <div class="note">
                    <h3>Advanced Settings</h3>

                    <table class="form-table">

                        <tr valign="top">
                        <th scope="row">Pin it Button Language</th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                                <label title="English"><input type="radio" name="bpp_lang" value="en"<?php checked( 'en' == get_option('bpp_lang') ); ?>> <span>English</span> <img src="<?php echo plugins_url( '/images/pinit_fg_en_rect_red_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                                <label title="Japanese"><input type="radio" name="bpp_lang" value="ja"<?php checked( 'ja' == get_option('bpp_lang') ); ?>> <span>Japanese</span> <img src="<?php echo plugins_url( '/images/pinit_fg_ja_rect_red_28.png', BPP_PLUGIN_FILE ); ?>" /></label><br>
                            </fieldset>
                        </td>
                        </tr>

                        <tr valign="top">
                        <th scope="row">Load pinit.js Asyncronously?</th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span>Loading </span></legend>
                                <label title="Load Async"><input type="radio" name="bpp_load" value="async"<?php checked( 'async' == get_option('bpp_load') ); ?>> <span>Load pinit.js Asyncronously  (default)</span></label><br>
                                <label title="Do not load Async"><input type="radio" name="bpp_load" value="sync"<?php checked( 'sync' == get_option('bpp_load') ); ?>> <span>Load pinit.js Syncronously</span></label><br>
                                <label title="Do not load at all"><input type="radio" name="bpp_load" value="none"<?php checked( 'none' == get_option('bpp_load') ); ?>> <span>Do not load pinit.js (advanced setting; not recommended)</span></label><br>
                            </fieldset>
                        </td>
                        </tr>

                        <tr valign="top">
                        <th scope="row">!important in CSS?
                        <td>
                            <p>If your center aligned images all end up on the left after you enable the plugin, check this box to fix it.</p></th>
                            <fieldset>
                                <legend class="screen-reader-text"><span>Use CSS classes with !important</span></legend>
                                <label title="Use CSS classes with !important"><input type="checkbox" name="bpp_important" value="important"<?php checked( 'important' == get_option('bpp_important') ); ?>> <span>Use CSS classes with !important (recommended only if image alignemnt is wrong after install)</span></label><br>
                            </fieldset>
                        </td>
                        </tr>

                        <tr valign="top">
                        <th scope="row">Load jQuery?</th>
                        <td>
                            <p>In the unlikely case the version of jQuery we use conflicts with the version another plugin uses you may nee to disable jQuery from being loaded. Please only use this advanced setting if necessary</p>
                            <fieldset>
                                <legend class="screen-reader-text"><span>Loading jQuery</span></legend>
                                <label title="Do Not Load jQuery"><input type="checkbox" name="bpp_load_jq" value="nojquery"<?php checked( 'nojquery' == get_option('bpp_load_jq') ); ?>> <span>Do not load jQuery (advanced setting; not recommended)</span></label><br>
                            </fieldset>
                        </td>
                        </tr>
                    </table>
                </div>

                <?php submit_button(); ?>

            </form>
            </div>

            <style type="text/css">
            #bpp_pin_plugin_admin img {
                vertical-align: middle;
                float: left;
                margin-right: 10px;
            }
            </style>
