/**
 * The image upload functionality of the plugin.
 *
 * Uses the default WordPress media uploader to set the image URL value
 * in the Row Divider widget.
 *
 * @since      1.1.5
 *
 */
 
(function( $ ) {

	$( document ).ready( function() {
		
	    // Prepare the variable that holds our custom media manager.
	    var media_frame;
	    
	    // Bind to our click event in order to open up the new media experience.
	    $( document.body ).on( 'click.ewcOpenMediaManager', '.custom-media-button', function( e ) {
		    
	        // Prevent the default action from occuring.
	        e.preventDefault();
	
	        // If the frame already exists, re-open it.
	        if ( media_frame ) {
	        	media_frame.open();
	            return;
	        }
	
	        //Create custom media frame. Refer to the wp-includes/js/media-views.js file for more default options.
	        media_frame = wp.media.frames.media_frame = wp.media( {
		        
	            // Custom class name for our media frame.
	            className: 'media-frame ewc-media-frame',
	            // Assign 'select' workflow since we only want to upload an image. Use the 'post' workflow for posts.
	            frame: 'select',
	            // Allow mutiple file uploads.
	            multiple: false,
	            // Set custom media workflow title using the localized script object 'widget_script_handle'.
	            title: 'Choose or Upload Image',
	            // Limit media library access to images only.
	            library: {
	                type: 'image'
	            },
	            // Set custom button text using the localized script object 'widget_script_handle'.
	            button: {
	                text:'Insert Image'
	            }
	            
	        } );
	
	        media_frame.on('select', function() {
		        
	            // Grab our attachment selection and construct a JSON representation of the model.
	            var media_attachment = media_frame.state().get( 'selection' ).first().toJSON();
	            
	            // Send the attachment URL to our custom input field via jQuery.
	            $( '.custom-media-url' ).val( media_attachment.url );
	            $( '.custom-media-url' ).trigger( 'change' ); // Necessary to trigger refresh in Customizer.
	            
	        } );
	        
	        // Now that everything has been set, let's open up the frame.
	        media_frame.open();
	        
	    } );
	    
	} );

} ) ( jQuery );
