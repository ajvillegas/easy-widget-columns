=== Easy Widget Columns ===
Contributors: ajvillegas
Donate link:   
Tags: widget, admin, columns, layout, widget columns
Requires at least: 4.5
Tested up to: 4.8
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily display widgets in rows of columns.

== Description ==

Easy Widget Columns makes it really easy to arrange your widgets in rows of columns. It works by adding a new 'Column width' select option at the bottom of your widget’s form that allows you to set a width value for each widget.

You can define new rows and sub-rows of widget columns with the 'Widget Row' widget and the 'Sub-Row' widget respectively, allowing you to create complex layouts directly from within your widget area or sidebar.

> **Genesis Framework users**, be sure to check out the [Widgetized Page Template](https://wordpress.org/plugins/widgetized-page-template/) plugin, which helps you create full-page widget areas to use as a "blank canvas" with Easy Widget Columns.

**Works With Most Themes**

Easy Widget Columns is optimized for use with the Genesis Framework, but it is not required. It uses the [Genesis Framework Column Classes](https://gist.github.com/studiopress/5700003) to display your widgets in rows of columns. If your theme already incorporates the Genesis Framework Column Classes, or you want to manually add or edit the CSS, you can choose not to load the CSS under 'Settings' > 'Widget Columns' and rely on your theme’s stylesheet instead. This option is recommended for most Genesis users or those concerned with loading additional assets on their website.

**Translation and RTL Ready**

The plugin supports RTL layouts and is translation ready.

**Filters for Developers**

The following filters are available for you to take full control of the plugin on your themes.

* `ewc_include_widgets` - This whitelist filter is used to add the width control ONLY to the specified widgets.
* `ewc_exclude_widgets` - This blacklist filter is used to remove the width control from the specified widgets.
* `ewc_color_palette` - This filter allows you to add a custom color palette to the color picker control in the 'Widget Row' widget.
* `ewc_preset_classes` - This filter allows you assign preset CSS classes that display as a checkbox list in the 'Widget Row' widget.
* `ewc_advanced_options` - This filter allows you remove specific or all advanced options from the 'Widget Row' widget.

**ewc_include_widgets**   
**ewc_exclude_widgets**

Both filters accept the widget's ID base as parameters. Please note that you cannot use both filters at once. The `ewc_include_widgets` filter will always take precedence over the `ewc_exclude_widgets` filter and overwrite it.

The examples below demonstrate how you can implement these filters on your theme.

`add_filter( 'ewc_include_widgets', 'myprefix_add_ewc_control' );
/**
 * Filter to add the EWC control to specified widgets.
 *
 * @param	array	An empty array.
 * @return	array	An array containing the widget's ID base.
 */
function myprefix_add_ewc_control( $ewc_widgets ) {
	
    $ewc_widgets = array(
        'meta', // WP Meta widget
        'archives', // WP Archives widget
        'calendar', // WP Calendar widget
        'categories', // WP Categories widget
    );
	
    return $ewc_widgets;
	
}`

`add_filter( 'ewc_exclude_widgets', 'myprefix_remove_ewc_control' );
/**
 * Filter to remove the EWC control from specified widgets.
 *
 * @param	array	An empty array.
 * @return	array	An array containing the widget's ID base.
 */
function myprefix_remove_ewc_control( $ewc_widgets ) {
	
    $ewc_widgets = array(
        'recent-comments', // WP Recent Comments widget
        'recent-posts', // WP Recent Posts widget
        'rss', // WP RSS widget
        'tag_cloud', // WP Tag Cloud widget
    );
	
    return $ewc_widgets;
	
}`

**ewc_color_palette**

This filter allows you to add a custom color palette to the color picker control in the 'Widget Row' widget. It accepts an array of hex color values as parameters.

The example below demonstrates how you can implement this filter on your theme.

`add_filter( 'ewc_color_palette', 'myprefix_ewc_color_palette' );
/**
 * Filter to edit the color palette in the color picker control.
 *
 * @param	array	An empty array.
 * @return	array	An array containing hex color values.
 */
function myprefix_ewc_color_palette( $color_palette ) {
	
    $color_palette = array(
        '#252724',
        '#ce6b36',
        '#31284b',
        '#a03327',
        '#3b3e3e',
        '#67b183',
    );
	
    return $color_palette;
	
}`

**ewc_preset_classes**

This filter allows you assign preset CSS classes that display as a checkbox list in the 'Widget Row' widget.

The following example demonstrates how you can implement this filter on your theme.

`add_filter( 'ewc_preset_classes', 'myprefix_preset_classes' );
/**
 * Filter for predefining EWC Widget Row classes.
 *
 * @param	array	An empty array.
 * @return	array	An array containing new values.
 */
function myprefix_preset_classes( $classes ) {
	
    $classes = array(
        'hero',
        'parallax',
        'slider',
        'content',
    );
	
    return $classes;
	
}`

**ewc_advanced_options**

This filter allows you remove specific or all advanced options from the 'Widget Row' widget. This can be useful for limiting design functionality on a client website ([decisions, not options](https://wordpress.org/about/philosophy/#decisions)).

The following example demonstrates how to completely remove all advanced options.

`// Remove all advanced options from the Widget Row widget
add_filter( 'ewc_advanced_options', '__return_false' );`

The example below demonstrates how to disable or enable specific advanced options. The `display` parameter toggles the advanced option and the `active` parameter determines if the panel will display open (1) or closed (0) when the Widget Row widget is first added into a widget area. 

`add_filter( 'ewc_advanced_options', 'myprefix_display_advanced_options' );
/**
 * Filter to remove specific advanced options from the Widget Row widget.
 *
 * @param	array	An array containing default values.
 * @return	array	An array containing new values.
 */
function myprefix_display_advanced_options( $display ) {
	
    $display = array(
        'ewc_background' => array(
            'display' => true,
            'active' => 1,
        ),
        'ewc_margin' => array(
            'display' => false,
            'active' => 0,
        ),
        'ewc_padding' => array(
            'display' => false,
            'active' => 0,
        ),
        'ewc_class' => array(
            'display' => true,
            'active' => 0,
        ),
    );
	
    return $display;
	
}`

== Installation ==

### Using The WordPress Dashboard

1. Navigate to the 'Add New' Plugin Dashboard
2. Click on 'Upload Plugin' and select `easy-widget-columns.zip` from your computer
3. Click on 'Install Now'
4. Activate the plugin on the WordPress Plugins Dashboard

### Using FTP

1. Extract `easy-widget-columns.zip` to your computer
2. Upload the `easy-widget-columns` directory to your `wp-content/plugins` directory
3. Activate the plugin on the WordPress Plugins Dashboard

== Frequently Asked Questions ==

= Why isn't the plugin working? =

This plugin only works with registered sidebars that have an HTML element assigned to the `before_widget` and `after_widget` parameters. If these parameters are empty, the plugin will not work. In addition, the `before_widget` parameter must have a class attribute associated with it so the plugin can inject the column classes accordingly.

For more information, please refer to this page in the Codex: [Function Reference/register_sidebar](https://codex.wordpress.org/Function_Reference/register_sidebar).

= Does the plugin add any HTML markup in the front-end? =

Yes, in addition to the column classes assigned to each widget, the plugin adds the following HTML markup around each row which is useful for clearing floats and styling purposes:

`<div id="widget-row-{number}" class="widget-row">
    <div class="wrap">
        [my widgets...]
    </div>
</div>`

= What is the difference between 'None' and '1/1' options? =

The default value of 'None' has no effect on your widget's markup while the '1/1' option adds the `full-width` class and assigns the corresponding markup in the front-end. The '1/1' option can be useful when assigning only one widget per row, or multiple full-width widgets.

= How do you create new rows of widget columns? =

To define new rows, use the 'Widget Row' widget at the start of each new row. If the next widget after a row has a value of 'None', then you'll need to add a 'Widget Row' widget before it to close the row. The only time you don't have to use the 'Widget Row' widget is when the last widget in a row is also the last widget in your widget area or sidebar.

To define new sub-rows within a widget row use the 'Sub-Row' widget at the start of each new sub-row. The Sub-Row widget only works within a widget row and has no effect when used outside of a widget row.

**Note:** Please make sure that each widget inside each row has a 'Column width' value other than 'None' assigned to it, otherwise the HTML markup will break in the front-end.

== Screenshots ==

1. Column width control
2. 'Widget Row' widget with optional advanced options
3. A simple example of a sidebar admin view
4. A simple example of a sidebar front-end view
5. A complex example of a sidebar admin view used to create a custom homepage
6. A complex example of a sidebar front-end view displaying a custom homepage
7. Custom homepage with delineated widget rows for reference

== Changelog ==

= 1.2.0 =
* Enhanced UI for the Widget Row advanced options.
* Updated the `ewc_advanced_options` filter for removing specific advanced options.
* Added the `ewc_preset_classes` filter for adding your own predefined CSS classes to the 'Widget Row' widget.
* Added the 'Sub-Row' widget for creating sub-rows within a widget row allowing you to create more complex layouts.
* Fixed the image upload control to use unique IDs to avoid conflict with other Widget Row instances.

= 1.1.9 =
* Strings in the image upload modal are now translatable.
* Updated .pot file with the new translatable strings.

= 1.1.8 =
* Fixed a bug introduced in the last version with the 'Widget Row' widget that caused the wrong markup to be outputted in the front end.

= 1.1.7 =
* Fixed undefined index notice when adding a 'Widget Row' widget.
* Fixed 'Column width' control in the Customizer not displaying correctly.

= 1.1.6 =
* Fixed bug that prevented deleting plugin.

= 1.1.5 =
* Added selective refresh support for widgets in the Customizer (props to [Weston Ruter](http://profiles.wordpress.org/westonruter)).
* Renamed the 'Row Divider' widget to 'Widget Row' widget to make its function more clear.
* You can now assign custom classes and a background image to each widget row using the 'Widget Row' widget.
* Added the `ewc_advanced_options` filter to completely remove the advanced options from the 'Widget Row' widget.

= 1.1.0 =
* The 'Row Divider' widget now allows you to add basic styles to each widget row including background color, margin and padding.
* Added the `ewc_color_palette` filter to edit the default color palette in the color picker control.
* Widget rows are now assigned a unique ID so you can easily add your own CSS styles.
* Removed selective refresh support for widgets in the Customizer to prevent row markup from breaking upon refresh.

= 1.0.0 =
* Initial release.
