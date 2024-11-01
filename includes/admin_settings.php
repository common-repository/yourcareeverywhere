<div class="yce wrap">
<h1>YourCareEverywhere Feed</h1>
<div class="left">
<fieldset><legend>Default Settings</legend>
<form method="post" action="options.php">
    <?php settings_fields( 'yce-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'yce-plugin-settings-group' ); ?>
    <?php $format = esc_attr( get_option('yce_feed_format') ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Custom Title</th>
        <td><input type="text" name="yce_feed_title" placeholder="YourCareEverywhere" value="<?php echo esc_attr( get_option('yce_feed_title') ); ?>" class="widefat"/></td>
        </tr>
        <tr valign="top">
        <th scope="row">Format</th>
        <td><!--<input type="text" name="format" value="<?php echo esc_attr( get_option('yce_feed_format') ); ?>" />-->
        <select name="yce_feed_format" id="<?php echo esc_attr( get_option('yce_feed_format') ); ?>" class="widefat">
<?php 
$options = array('horizontal', 'vertical');
foreach ($options as $option) {
echo '<option value="' . $option . '" id="' . $option . '"', $format == $option ? ' selected="selected"' : '', '>', $option, '</option>';
}
?>
</select><br>
<em>Select the direction of the feed, horizontal or vertical. Default is horizontal.</em>
       </td>
        </tr>
        <tr valign="top">
        <th scope="row">Height</th>
        <td><input type="number"  min="250" name="yce_feed_h" placeholder="340" value="<?php echo esc_attr( get_option('yce_feed_h') ); ?>" />px<br>
<em>Height of feed container. Default/Minimum is 340.</em></td>
        </tr>
        <tr valign="top">
        <th scope="row">Width</th>
        <td><input type="number"  min="1" name="yce_feed_w" value="<?php echo esc_attr( get_option('yce_feed_w') ); ?>" />px<br>
<em>Width of feed container, only used on vertical feeds. Default is full width.</em></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
	</fieldset>
	</div>
<div class="right">
<fieldset><legend>Instructions</legend>
	<h2>YourCareEverywhere Content Widget Implementation Guide</h2>
<p>The YourCareEverywhere content widget allows you to display content from YourCareEverywhere.com to visitors on your website for free. The widget automatically refreshes as YourCareEverywhere.com is refreshed with new articles, content, and health and wellness information. You may customize the default settings below. </p>
	<p>There are two ways to use this feed on your website: shortcode and widgets.</p>
	<h3>Shortcode</h3>
	<p>Place the shortcode [yce-feed] anywhere on your site to display the YourCareEverywhere feed. When using the shortcode, you may change the settings for an individual feed by adding any of the corresponding the corresponding attributes like so: </p>
	<p>[yce-feed title="Your Title Here" format="vertical" width ="400" height="700"] </p>
	<h3>Widget</h3>
	<p>Use the YourCareEveryWhere widget to place a feed in a sidebar on your site. The widget also allows you to override the default settings.</p>
	</fieldset>
	</div>
	
</div>