<?php
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin/partials
 */

?>
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php $url_text = esc_html__( 'Genesis Framework Column Classes', 'easy-widget-columns' ); ?>

	<p>
		<?php
		echo sprintf(
			/* translators: 1: Link tag, URL & anchor, 2: <head> tag, 3: <link> tag. */
			esc_html__( 'This plugin uses the %1$s to display your widgets in rows of columns. By default it loads the CSS in a %2$s in the %3$s of your website. If your theme already incorporates the Genesis Framework Column Classes or you want to add/edit the CSS manually, see the options below.', 'easy-widget-columns' ),
			'<a href="https://gist.github.com/studiopress/5700003">' . esc_html( $url_text ) . '</a>',
			'<code>&lt;link&gt;</code>',
			'<code>&lt;head&gt;</code>'
		);
		?>
	</p>

	<form method="post" name="css_options" action="options.php">
		<?php
		// Grab all options and assign default values.
		$defaults = array(
			'ewc_load_css' => 0,
		);
		$options  = wp_parse_args( get_option( $this->plugin_name, $defaults ), $defaults );

		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );
		?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php echo esc_html__( 'CSS Assets', 'easy-widget-columns' ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span><?php echo esc_html__( 'Options to load CSS assets', 'easy-widget-columns' ); ?></span></legend>

							<p>
								<label for="ewc-load-css">
									<input id ="ewc-load-css" name="<?php echo esc_attr( $this->plugin_name ); ?>[ewc_load_css]" type="radio" value="0" <?php checked( $options['ewc_load_css'], 0 ); ?> />
									<span>
										<?php
										echo sprintf(
											/* translators: 1: <link> tag, 2: <head> tag. */
											esc_html__( 'Load the CSS stylesheet in a %1$s in the %2$s', 'easy-widget-columns' ),
											'<code>&lt;link&gt;</code>',
											'<code>&lt;head&gt;</code>'
										);
										?>
									</span>
								</label>
							</p>

							<p>
								<label for="ewc-no-css">
									<input id="ewc-no-css" name="<?php echo esc_attr( $this->plugin_name ); ?>[ewc_load_css]" type="radio" value="1" <?php checked( $options['ewc_load_css'], 1 ); ?> />
									<span>
										<?php
										echo sprintf(
											/* translators: %s: <head> tag. */
											esc_html__( 'Do NOT load the CSS in the %s. My theme is already using the Genesis Framework Column Classes, or I want to add it manually.', 'easy-widget-columns' ),
											'<code>&lt;head&gt;</code>'
										);
										?>
									</span>
								</label>
							</p>
						</fieldset>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php echo esc_html__( 'Column Classes', 'easy-widget-columns' ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span><?php echo esc_html__( 'To add/edit the CSS manually, copy the code below into your stylesheet', 'easy-widget-columns' ); ?></span></legend>

							<p>
								<label for="<?php echo esc_attr( $this->plugin_name ); ?>-css-code"><?php echo esc_html__( 'To add/edit the CSS manually, copy the code below into your stylesheet:', 'easy-widget-columns' ); ?></label>
							</p>

							<?php
							if ( is_rtl() ) {
								$column_classes = file_get_contents( plugin_dir_path( dirname( __DIR__ ) ) . 'public/css/easy-widget-columns-public-rtl.css' );
							} else {
								$column_classes = file_get_contents( plugin_dir_path( dirname( __DIR__ ) ) . 'public/css/easy-widget-columns-public.css' );
							}
							?>

							<p>
								<textarea cols="80" rows="10" readonly="true" id="<?php echo esc_attr( $this->plugin_name ); ?>-column-classes" name="<?php echo esc_attr( $this->plugin_name ); ?>-column-classes" value=""><?php echo esc_textarea( $column_classes ); ?></textarea>
							</p>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button( esc_html__( 'Save Changes', 'easy-widget-columns' ), 'primary', 'submit', true ); ?>
	</form>
</div>
