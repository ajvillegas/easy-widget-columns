/**
 * The Customizer-specific functionality of the plugin.
 *
 * Handles the selective refresh logic for widgets in the Customizer.
 *
 * @since      1.1.5
 * @author     Weston Ruter <weston@xwp.co>
 *
 */

(function( $ ) {
	
	if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh || ! wp.customize.widgetsPreview || ! wp.customize.widgetsPreview.WidgetPartial ) {
		return;
	}

	// Check the value of the attribute after partial content has been rendered.
	wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {

		// Abort if the partial is not for a widget.
		if ( ! placement.partial.extended( wp.customize.widgetsPreview.WidgetPartial ) ) {
			return;
		}
		
		// Abort if the widget was not refreshed but rather just re-initialized.
		if ( ! placement.removedNodes ) {
			return;
		}

		// Refresh the page if the attribute has changed.
		if ( placement.container.attr( 'data-column' ) !== placement.removedNodes.attr( 'data-column' ) ) {
			wp.customize.selectiveRefresh.requestFullRefresh();
		}
		
		// Debugging
		console.log( 'old attribute: ' + placement.removedNodes.attr( 'data-column' ) );
		console.log( 'new attribute: ' + placement.container.attr( 'data-column' ) );
		
	} );

} ) ( jQuery );
