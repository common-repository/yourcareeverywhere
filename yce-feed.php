<?php
/*
Plugin Name: YourCareEverywhere 
Description: The YourCareEverywhere plugin allows you to display content from YourCareeverywhere.com to visitors on your website for free.
Version: 1.0
Author: YourCareEverywhere
Author URI: https://www.yourcareeverywhere.com/
License: GPL2
*/
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
$default_settings = array();
function yce_feed_load_custom_wp_admin_style($hook) {
	//wp_die($hook);
        if($hook != 'toplevel_page_yce_feed_plugin') {
                return;
        }
        wp_enqueue_style( 'yce_feed_custom_wp_admin_css', plugins_url('css/admin.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'yce_feed_load_custom_wp_admin_style' );

class YCE_Feed_Plugin {
	
  public function __construct() {
  if (is_admin()) {
	  
    register_activation_hook(__FILE__, array(&$this, 'activate'));
	add_action('admin_menu',array(&$this,'admin_menu'));
    add_action('admin_init',function() {
    register_setting( 'yce-plugin-settings-group', 'yce_feed_title' );
	register_setting( 'yce-plugin-settings-group', 'yce_feed_format' );
	register_setting( 'yce-plugin-settings-group', 'yce_feed_h' );
	register_setting( 'yce-plugin-settings-group', 'yce_feed_w' );
    });
  }
	  add_action( 'wp_enqueue_scripts', 'yce_feed_enqueued_assets' );

function yce_feed_enqueued_assets() {
	wp_register_style( 'yce-styles', 'https://yourcareeverywhere.com/content/dam/medhost/yce/hospital-widget/widget.css', 'all' );
	wp_enqueue_style( 'yce-styles');
	}
add_action( 'wp_enqueue_scripts', 'yce_feed_enqueued_js' );
function yce_feed_enqueued_js() {
	 wp_register_script( 'yce-js', 'https://yourcareeverywhere.com/content/dam/medhost/yce/hospital-widget/widget.js', '', '', true );
}
	  
	add_shortcode('yce-feed',function($atts){
    wp_enqueue_script( 'yce-js');
		extract(shortcode_atts(array(
		 'title' => '',
		 'format' => '',
		 'height' => '',
		 'width' => ''
	   ), $atts));
	if(!empty($title)) { $title = $title; } else { $title = esc_attr( get_option('yce_feed_title') ); }
   	if(!empty($format)) { $format = $format; } else {   $format = esc_attr( get_option('yce_feed_format') ); }
	if(!empty($height)) { $yce_feed_h = $height; } else {   $yce_feed_h = esc_attr( get_option('yce_feed_h') ); }
	if(!empty($width)) { $yce_feed_w = $width; } else {  $yce_feed_w = esc_attr( get_option('yce_feed_w') ); }
   //  $textarea = '';
    // $checkbox = '';

	$return_string = '';
	if(empty($format)){ $format = 'horizontal';} else {$format = $format;}
	if(empty($yce_feed_h)){ $h = '';} else {$h = 'height:'.$yce_feed_h.'px!important;';} //height
	if($format == 'vertical') { //only add a width if it's vertical
		if(empty($yce_feed_w) ){ $w = '';} else {$w = 'max-width:'.$yce_feed_w.'px!important;';} //width
	} else {$w = '';}
	if(empty($yce_feed_api)){ $a = '28aa2be7-9271-4d81-a12e-bb9945a207d8';} else {$a = $yce_feed_api;} //api
	$return_string .= '<div class="yce-feed-container"><div style="'.$h.$w.'" class="yce-widget" id="'.$a.'" data-widget-id="'.$a.'" format="'.$format.'"';
	if(!empty ($title)) { $return_string .='title="'.$title.'"'; }
	$return_string .= '></div></div>';
	//$return_string .= '<script type="text/JavaScript" src="https://yourcareeverywhere.com/content/dam/medhost/yce/hospital-widget/widget.js"></script>'; //Loading script via wp_enqueue_script aboce
	return $return_string;

		
  });
}
 
public function activate() { }
	
public function admin_menu() {
add_menu_page('YCE Settings', 'YCE Feed', 'administrator', 'yce_feed_plugin', array(&$this,'plugin_options'), 'dashicons-admin-generic');
}
public function plugin_options() {
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }
  $this->options=get_option('yce_feed_plugin');
  include('includes/admin_settings.php');
}
	
	
} //END YCE_Feed_Plugin class
 
$yce_feed_plugin = new YCE_Feed_Plugin();


/*======================
Build the Widget 
======================*/
class yce_feed_wp_plugin extends WP_Widget {
	// constructor
function yce_feed_wp_plugin() {
        parent::WP_Widget(false, $name = __('YourCareEverywhere Feed', 'wp_widget_plugin') );
    }
// widget form creation
function form($instance) {
// Check values
if( $instance) {
     $title = esc_attr($instance['yce_feed_title']);
     $format = esc_attr($instance['yce_feed_format']);
     $yce_feed_h = esc_attr($instance['yce_feed_h']);
     $yce_feed_w = esc_attr($instance['yce_feed_w']);
     //$textarea = esc_textarea($instance['textarea']);
    // $checkbox = esc_attr($instance['checkbox']);
} else {
	settings_fields( 'yce-plugin-settings-group' );
	do_settings_sections( 'yce-plugin-settings-group' );
    $title = esc_attr( get_option('yce_feed_title') ); 
	$format = esc_attr( get_option('yce_feed_format') ); 
	$yce_feed_h = esc_attr( get_option('yce_feed_h') ); 
	$yce_feed_w = esc_attr( get_option('yce_feed_w') ); 
   //  $textarea = '';
    // $checkbox = '';
}
?>

<p>
<label for="<?php echo $this->get_field_id('yce_feed_title'); ?>"><?php _e('Feed Title', 'wp_widget_plugin'); ?></label><br>
<input id="<?php echo $this->get_field_id('yce_feed_title'); ?>" name="<?php echo $this->get_field_name('yce_feed_title'); ?>" type="text" value="<?php echo $title; ?>"  class="widefat"/>
</p>

<p>
<label for="<?php echo $this->get_field_id('yce_feed_format'); ?>"><?php _e('Format', 'wp_widget_plugin'); ?></label><br>
<select name="<?php echo $this->get_field_name('yce_feed_format'); ?>" id="<?php echo $this->get_field_id('yce_feed_format'); ?>" class="widefat">
<?php
$options = array('horizontal', 'vertical');
foreach ($options as $option) {
echo '<option value="' . $option . '" id="' . $option . '"', $format == $option ? ' selected="selected"' : '', '>', $option, '</option>';
}
?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('yce_feed_h'); ?>"><?php _e('Height:', 'wp_widget_plugin'); ?></label><br>
<input id="<?php echo $this->get_field_id('yce_feed_h'); ?>" name="<?php echo $this->get_field_name('yce_feed_h'); ?>" type="number"  min="250" value="<?php echo $yce_feed_h; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('yce_feed_w'); ?>"><?php _e('Width (vertical format only):', 'wp_widget_plugin'); ?></label><br>
<input id="<?php echo $this->get_field_id('yce_feed_w'); ?>" name="<?php echo $this->get_field_name('yce_feed_w'); ?>" type="number"  min="1" value="<?php echo $yce_feed_w; ?>" />
</p>


<?php  } //end function form()
// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['yce_feed_title'] = strip_tags($new_instance['yce_feed_title']);
      $instance['yce_feed_h'] = strip_tags($new_instance['yce_feed_h']);
      $instance['yce_feed_w'] = strip_tags($new_instance['yce_feed_w']);
    //  $instance['textarea'] = strip_tags($new_instance['textarea']);
    //  $instance['checkbox'] = strip_tags($new_instance['checkbox']);
      $instance['yce_feed_format'] = strip_tags($new_instance['yce_feed_format']);
     return $instance;
}
function widget($args, $instance) {
	wp_enqueue_script( 'yce-js');
    extract( $args );
   // these are the widget options
   //$title = apply_filters('widget_title', $instance['yce_feed_title']);
    $title = $instance['yce_feed_title'];
	$yce_feed_h = $instance['yce_feed_h'];
	$yce_feed_w = $instance['yce_feed_w'];
	$format = $instance['yce_feed_format'];
 //  $textarea = $instance['textarea'];
   
include('includes/widget.php');}
	
} // end yce_feed_wp_plugin class
// register widget
add_action('widgets_init', create_function('', 'return register_widget("yce_feed_wp_plugin");'));
?>