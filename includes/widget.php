<?php
echo $before_widget;
 // Display the widget
   echo '<div>';
   //  $textarea = '';
    // $checkbox = '';
	$return_string = '';
	if(empty($format)){ $format = 'horizontal';} else {$format = $format;}
	if(empty($yce_feed_h)){ $h = '';} else {$h = 'height:'.$yce_feed_h.'px!important;';} //height
	if($format == 'vertical') { //only add a width if it's vertical
		if(empty($yce_feed_w) ){ $w = '';} else {$w = 'max-width:'.$yce_feed_w.'px!important;';} //width
	} else {$w = '';}
	if(empty($yce_feed_api)){ $a = '28aa2be7-9271-4d81-a12e-bb9945a207d8';} else {$a = $yce_feed_api;} //api
	$return_string .= '<div style="'.$h.$w.'" class="yce-widget" id="'.$a.'" data-widget-id="'.$a.'" format="'.$format.'"';
	if(!empty ($title)) { $return_string .='title="'.$title.'"'; }
	$return_string .= '></div>';
	echo $return_string;
   echo '</div>';
   echo $after_widget;