/**
 * The image upload functionality of the plugin.
 *
 * Uses the default WordPress media uploader to set the image URL value
 * in the Row Divider widget.
 *
 * @since	1.1.5
 *
 */
 
(function( $ ) {

	$( document ).ready( function() {
		
	    // Prepare the variable that holds our custom media manager.
	    var media_frame;
	    
	    // Prepare the variable that holds our custom input field ID.
	    var target_input;
	    
	    // Bind to our click event in order to open up the new media experience.
	    $( document.body ).on( 'click.ajvOpenMediaManager', '.custom-media-button', function( e ) {
		    
	        // Prevent the default action from occuring.
	        e.preventDefault();
	        
	        // Get our custom input field ID.
		    var target_input = $( this ).prev().attr( 'id' );
	        
	        // Create custom media frame. Refer to the wp-includes/js/media-views.js file for more default options.
	        media_frame = wp.media.frames.media_frame = wp.media( {
		        
	            // Custom class name for our media frame.
	            className: 'media-frame ajv-media-frame',
	            // Assign 'select' workflow since we only want to upload an image. Use the 'post' workflow for posts.
	            frame: 'select',
	            // Allow mutiple file uploads.
	            multiple: false,
	            // Set custom media workflow title using the localized script object 'ajv_image_upload'.
	            title: ajv_image_upload.frame_title,
	            // Limit media library access to images only.
	            library: {
	                type: 'image'
	            },
	            // Set custom button text using the localized script object 'ajv_image_upload'.
	            button: {
	                text: ajv_image_upload.frame_button
	            }
	            
	        } );
	
	        media_frame.on( 'select', function() {
		        
	            // Grab our attachment selection and construct a JSON representation of the model.
	            var media_attachment = media_frame.state().get( 'selection' ).first().toJSON();
	            
	            // Send the attachment URL to our custom input field via jQuery.
	            $( '#' + target_input ).val( media_attachment.url );
	            $( '#' + target_input ).trigger( 'change' ); // Necessary to trigger refresh in Customizer.
	            
	        } );
	        
	        // Now that everything has been set, let's open up the frame.
	        media_frame.open();
	        
	    } );
	    
	} );

} ) ( jQuery );
