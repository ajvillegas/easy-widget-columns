<?php

/**
 * Easy Widget Columns Sub-Row Divider widget.
 *
 * Use this widget to start a new sub-row of widget columns
 * within a widget row.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.2.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Sub-Row Divider widget
 */
 
class EWC_Sub_Row_Divider extends WP_Widget {
	
    /**
     * Constructor
     *
     * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes any necessary stylesheets and JavaScript.
     **/
	public function __construct() {
		
		$widget_ops = array(
			'classname' => 'ewc-subrow-divider',
			'description' => __( 'Use this widget to start a new sub-row of widget columns.', 'easy-widget-columns' ),
			'customize_selective_refresh' => false,
		);
		
		$control_ops = array(
			'id_base' => 'ewc-subrow-divider',
		);
		
		parent::__construct( 'ewc-subrow-divider', '&minus;&minus; ' . __( 'sub-row', 'easy-widget-columns' ) . ' &minus;&minus;', $widget_ops, $control_ops );
		
	}
	
    /**
     * Outputs the HTML for this widget.
     *
     * @param array args The array of form elements
	 * @param array instance The current instance of the widget
     **/
	public function widget( $args, $instance ) {
		
		extract( $args, EXTR_SKIP );
		
	}

    /**
     * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
     **/
	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		return $instance;
		
	}

    /**
     * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
     **/
	public function form( $instance ) {
		
		echo '<p>' . __( 'Use this widget to start a new sub-row of widget columns.', 'easy-widget-columns' ) . '</p>';
		
	}
	
}
