jQuery(document).ready(function($){
	// Attach a submit handler to the form
	$( "#singupform" ).submit(function(event){
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

   var localizedErrMap = {};
   localizedErrMap['required'] =    'This field is required.';
   localizedErrMap['ca'] =      'An unexpected error occurred while attempting to send email.';
   localizedErrMap['email'] =       'Please enter your email address in name@email.com format.';
   localizedErrMap['birthday'] =    'Please enter birthday in MM/DD format.';
   localizedErrMap['anniversary'] =   'Please enter anniversary in MM/DD/YYYY format.';
   localizedErrMap['custom_date'] =   'Please enter this date in MM/DD/YYYY format.';
   localizedErrMap['list'] =      'Please select at least one email list.';
   localizedErrMap['generic'] =     'This field is invalid.';
   localizedErrMap['shared'] =    'Sorry, we could not complete your sign-up. Please contact us to resolve this.';
   localizedErrMap['state_mismatch'] = 'Mismatched State/Province and Country.';
  localizedErrMap['state_province'] = 'Select a state/province';
   localizedErrMap['selectcountry'] =   'Select a country';
   var postURL = 'https://visitor2.constantcontact.com/api/signup';