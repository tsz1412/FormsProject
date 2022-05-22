(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( document ).ready(function() {
		$( "#application" ).validate({
			rules: {
				// simple rule, converted to {required:true}
				fname: "required",
				lname: "required",
				tou: "required",

				// compound rule
				email: {
					required: true,
					email: true
				},
				date_of_birth: {
					validDate: true
				}
			},
			errorPlacement:function(error,element){
				console.log(element.parent())
				error.appendTo(element.parent().first().after());
			},
			errorElement: 'span',
			submitHandler: function() {
				let data = {
					action : 'save_form_submission',
					fname : $('input[name=fname]').val(),
					lname : $('input[name=lname]').val(),
					phone : $('input[name=phone]').val(),
					email : $('input[name=email]').val(),
					country : $('select[name=country] option:selected').val(),
					date_of_birth : $('input[name=date]').val(),
					tou_agreement : $('input[name=tou]').is(':checked')?$('input[name=tou]').val():false
				}
				let ajax_url = myAjax.ajaxurl;
				$.post( ajax_url, data, function(response) {
					const res = JSON.parse(response);
					console.log(res);
					if(res.type == 'success'){
						$('#form-content').addClass('hidden');
						$('#form-success-message').removeClass('hidden');
					}

				});
			}
		});
	});
})( jQuery );
