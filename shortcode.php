 <?php 
 /* @Constant Contact Email Singup - Shortcode */
	echo '<div class="css_widget" style="max-width:300px;">';	
	if(!empty($atts['ca']) && !empty($atts['list']) && !empty($atts['firstname'])){ 
				echo  '<h2 class="widgettitle">Sign up to stay in touch!</h2>';
				constantcontact_form($atts['ca'], $atts['list'], $atts['firstname']);
		}
		else{
			echo '<p>Please setup CA Input, List Input & First Name attribute for shortcode.</p>';
		}	
	echo '</div>';
 ?>