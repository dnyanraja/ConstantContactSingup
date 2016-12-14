<?php
/*
Plugin Name: Constant Contact email singup
Plugin URI: 
Description: Constant Contant widget for submitting email address to signup for campaign
Version: 
Author: Ganesh Veer
Author URI: 
License: GPL2
*/

function cc_enqueue_scripts(){
	//wp_enqueue_style('cc_css', 'https://static.ctctcdn.com/h/contacts-embedded-signup-assets/1.0.2/css/signup-form.css', array(), '1.0.0', 'all');	
	wp_enqueue_style('ccsingup', plugin_dir_url(__FILE__).'/css/ccsingup.css', array(), '1.0.0', 'all');	
	//wp_register_script('cc_js', 'https://static.ctctcdn.com/h/contacts-embedded-signup-assets/1.0.2/js/signup-form.js');
	//wp_enqueue_script( 'cc_js' );
}
add_action('wp_enqueue_scripts', 'cc_enqueue_scripts');

function constantcontact_form($ca, $listin, $fname){ 
	?>
<div class="ctct-embed-signup" style="font: 16px Helvetica Neue, Arial, sans-serif; font: 1rem Helvetica Neue, Arial, sans-serif; line-height: 1.5; -webkit-font-smoothing: antialiased;">
   <div style="color:#5b5b5b; background-color:#e8e8e8; border-radius:5px;padding:10px;">
       <div id="success_message" style="display:none;">
           <div style="text-align:center;">Thanks for signing up! <span class="close" style="float:right;">X</span></div>
       </div>
       <form id="singupform" data-id="embedded_signup:form" class="ctct-custom-form Form" name="embedded_signup" method="POST" 
       action="https://visitor2.constantcontact.com/api/signup">
                   
           <input data-id="ca:input" name="ca" value="<?php echo $ca; ?>" type="hidden">
           <input data-id="list:input" name="list" value="<?php echo $listin; ?>" type="hidden">
           <input data-id="source:input" name="source" value="EFD" type="hidden">
           <input data-id="required:input" name="required" value="list,email" type="hidden">
           <input data-id="url:input" name="url" value="" type="hidden">
           <?php if($fname=="Yes" || $fname == "on"){ ?>
           <p data-id="First Name:p" ><label data-id="First Name:label" data-name="first_name">Name</label> <input data-id="First Name:input" name="first_name" value="" maxlength="50" type="text"></p>
           <?php } ?>          
           <p data-id="Email Address:p" ><label data-id="Email Address:label" data-name="email" class="ctct-form-required">Email</label> <input data-id="Email Address:input" name="email" value="" maxlength="80" type="text"></p>
            <button  type="submit" class="btn btn-small ctct-button" data-enabled="enabled">Sign Up</button><br style="clear:both;"/>
       	<div style="display:block;"><p class="ctct-form-footer">By submitting this form, you are granting: <?php echo get_bloginfo('name'); ?> permission to email you.</p></div>
       </form>
   </div>
</div>
<script type='text/javascript'>
   var localizedErrMap = {};
   localizedErrMap['required'] = 		'This field is required.';
   localizedErrMap['ca'] = 			'An unexpected error occurred while attempting to send email.';
   localizedErrMap['email'] = 			'Please enter your email address in name@email.com format.';
   localizedErrMap['birthday'] = 		'Please enter birthday in MM/DD format.';
   localizedErrMap['anniversary'] = 	'Please enter anniversary in MM/DD/YYYY format.';
   localizedErrMap['custom_date'] = 	'Please enter this date in MM/DD/YYYY format.';
   localizedErrMap['list'] = 			'Please select at least one email list.';
   localizedErrMap['generic'] = 		'This field is invalid.';
   localizedErrMap['shared'] = 		'Sorry, we could not complete your sign-up. Please contact us to resolve this.';
   localizedErrMap['state_mismatch'] = 'Mismatched State/Province and Country.';
	localizedErrMap['state_province'] = 'Select a state/province';
   localizedErrMap['selectcountry'] = 	'Select a country';
   var postURL = 'https://visitor2.constantcontact.com/api/signup';

jQuery(document).ready(function($){
	// Attach a submit handler to the form
	$( "#singupform" ).submit(function( event ) {
	  	// Stop form from submitting normally
	  	event.preventDefault();
  		// Get some values from elements on the page:
  		var $form 	= $( this ),
    	caval 		= $form.find( "input[name='ca']" ).val(),
    	listval 	= $form.find( "input[name='list']" ).val(),
    	sourceval 	= $form.find( "input[name='source']" ).val(),
    	urlval 		= $form.find( "input[name='url']" ).val(),
    	emailval 	= $form.find( "input[name='email']" ).val(),
    	url 		= $form.attr( "action" );
  		// Send the data using post
  		var posting = $.post( url, {ca: caval, list:listval, source:sourceval, url:urlval, email:emailval} );
   		// Put the results in a div
		posting.done(function(data) {	  	
    		if(data.success){
    			//If Success Remove form and display success message
    			$( "#singupform" ).fadeOut();
    			$( "#success_message" ).empty().append('Thanks for signing up! <span class="close" id="close" style="display:inline-block;float:right;">X</span>').fadeIn('slow');	
	    		}
  			});
		});	
		//Remove success msg and display form again
		$("#success_message").on("click", function(){
			$( "#singupform" ).fadeIn("slow");
			$( "#success_message" ).fadeOut("slow");		
		});
});
</script>
<?php
}

function admin_js_css(){
	?>
<script type='text/javascript'> 
	jQuery(document).ready(function($){
   			$('.cainput').on('focus', function(){
   				var th = "."+$(this).attr("class");   				
   				$('.cainput_description').fadeIn("slow");
   			}).focusout(function(){
   					$('.cainput_description').fadeOut("slow")
	   		});
	   		$('.listinput').on('focus', function(){
   				var th = "."+$(this).attr("class");   				
   				$('.calist_description').fadeIn("slow");
   			}).focusout(function(){
   					$('.calist_description').fadeOut("slow")
	   		});
	});
</script>
	<?php
}
add_action('admin_head', 'admin_js_css');

/**
 * Adds ConstantContact_Widget widget.
 */
class ConstantContact_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'constantcontact_widget', // Base ID
			esc_html__( 'Constant Contact Singup', 'ccsignup' ), // Name
			array( 'description' => esc_html__( 'Constant Contact Singup', 'ccsignup' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		constantcontact_form($instance['cainput'], $instance['listinput'], $instance['firstname']);
		
		//echo esc_html__( 'Hello, World!', 'ccsignup' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Sign up to stay in touch!', 'ccsignup' );
		$cainput = ! empty( $instance['cainput'] ) ? $instance['cainput'] : '';
		$listinput = ! empty( $instance['listinput'] ) ? $instance['listinput'] : '';
		$firstname = ! empty( $instance['firstname'] ) ? $instance['firstname'] : '';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ccsignup' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"><br/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'cainput' ) ); ?>"><?php esc_attr_e( 'CA Input:', 'ccsignup' ); ?></label> 
		<input class="widefat cainput" id="<?php echo esc_attr( $this->get_field_id( 'cainput' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cainput' ) ); ?>" type="text" value="<?php echo esc_attr( $cainput ); ?>">
		<p class="cainput_description" style="display:none;">(Login to your constant contact account. Goto contacts-> list growth tools->select form & click on "Action" -> "embed Code".
		Then you will get the html code, Within this code you have to search for ca:input field and copy its value here )</p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'listinput' ) ); ?>"><?php esc_attr_e( 'List Input:', 'ccsignup' ); ?></label> 
		<input class="widefat listinput" id="<?php echo esc_attr( $this->get_field_id( 'listinput' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'listinput' ) ); ?>" type="text" value="<?php echo esc_attr( $listinput ); ?>">
		<p class="calist_description" style="display:none;">(Login to your constant contact account. Goto contacts-> list growth tools->select form & click on "Action" -> "embed Code".
		Then you will get the html code, Within this code you have to search for ca:list field and copy its value here )</p><br/>	
		<label for="<?php echo esc_attr( $this->get_field_id( 'firstname' ) ); ?>"><?php esc_attr_e( 'Display First Name Input Field:', 'ccsignup' ); ?></label> 
		<input class="widefat firstname" id="<?php echo esc_attr( $this->get_field_id( 'firstname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'firstname' ) ); ?>" <?php checked( $instance[ 'firstname' ], 'on' ); ?> type="checkbox" >
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cainput'] =	 $new_instance['cainput'];
		$instance['listinput'] = $new_instance['listinput'];
		$instance['firstname'] = $new_instance['firstname'];
		return $instance;
	}

} // class ConstantContact_Widget

// register ConstantContact_Widget widget
function register_ccsignup_widget() {
    register_widget( 'ConstantContact_Widget' );
}
add_action( 'widgets_init', 'register_ccsignup_widget' );

/*--------------------------------------------------------------	
	Constant Contact Signup Shortcode
[ccsingup ca="xxxxxxxx-xxx-xxxx-xxxx-xxxxxxxxxxxx" list="xxxxxxxxxx" firstname="Yes/No"] 
----------------------------------------------------------------*/
function ccsingup_func( $atts ) {
	$atts = shortcode_atts( 
		array(
		'ca' => 'xxxxxxxx-xxx-xxxx-xxxx-xxxxxxxxxxxx',
		'list' => 'xxxxxxxxxx',
		'firstname' => 'Yes'
		), 
		$atts, 'ccsingup' );

	require 'shortcode.php';
}
add_shortcode( 'ccsingup', 'ccsingup_func' );