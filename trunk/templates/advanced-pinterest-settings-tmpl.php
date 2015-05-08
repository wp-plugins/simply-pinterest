<script type="text/html" id="tmpl-advanced-pinterst-settings">
    
    <div id="bpp-mediasettings">
        <h3>Pinterest Settings</h3>
        <div class="setting link-target">
            <label><input type="checkbox" data-setting="nopin" value="nopin" <# if ( data.nopin ) { #>checked="checked"<# } #>><?php _e( 'Prevent from being pinned to Pinterest?' ); ?></label>
        </div>
        <div id="bpp-overridehover" class="setting link-target">
        <h4>Override default hover settings</h4>
            <label><input type="radio" name="pinhover" data-setting="pinhover" value="onhover" <# if ( data.pinhover == 'onhover' ) { #>checked="checked"<# } #>><?php _e( 'Only show Pin it button on hover (will override default settings)' ); ?></label><br>
            <label><input type="radio" name="pinhover" data-setting="pinhover" value="always" <# if ( data.pinhover == 'always' ) { #>checked="checked"<# } #>><?php _e( 'Always show Pin it button (will override default settings)' ); ?></label><br>
            <label><input type="radio" name="pinhover" data-setting="pinhover" value="" <# if ( data.pinhover == '' ) { #>checked="checked"<# } #>><?php _e( 'Do not override' ); ?></label>
        </div>
    </div>

</script>
