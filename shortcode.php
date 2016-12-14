 <?php 
	echo '<div class="css_widget" style="max-width:300px;">';
	echo  '<h2 class="widgettitle">Sign up to stay in touch!</h2>';
	constantcontact_form($atts['ca'], $atts['list'], $atts['firstname']);
	echo '</div>';
 ?>