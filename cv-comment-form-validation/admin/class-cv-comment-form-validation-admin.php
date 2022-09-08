<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/thechetanvaghela/
 * @since      1.0.0
 *
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/admin
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Cv_Comment_Form_Validation_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cv_Comment_Form_Validation_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cv_Comment_Form_Validation_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cv-comment-form-validation-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cv_Comment_Form_Validation_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cv_Comment_Form_Validation_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cv-comment-form-validation-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function cfv_setting_admin_menu() {

		add_menu_page('Comment Form Customize','Comment Form Customize','manage_options','cfv_settings_page',array($this, 'cfv_settings_page_callback' ),'dashicons-welcome-comments');
	}

	public function cfv_settings_page_callback() {
			# define empty variables
			$form_msg = $label_value = $enable_value = $enable_validation = $prevent_value = $prevent_die ="";
			
			# if user can manage options
			if ( current_user_can('manage_options') ) {
				# submit form acrion
				if (isset($_POST['cvf-form-settings'])) {
					# verifing nonce
					if ( ! isset( $_POST['cfv_setting_field_nonce'] ) || ! wp_verify_nonce( $_POST['cfv_setting_field_nonce'], 'cfv_setting_action_nonce' ) ) {
						# form data not saved message
						$form_msg = '<b style="color:red;">Sorry, your nonce did not verify.</b>';
					} else {
						# Enable comment validation option
						if (isset($_POST['cfv-enable-comment-validation'])) {
							$enable_value = sanitize_text_field($_POST['cfv-enable-comment-validation']);
							$enable_value = !empty($enable_value) ? $enable_value : "no";
							# update Enable comment value option value
							update_option('cfv-enable-comment-validation', $enable_value);
						}

						# Prevent Die
						if (isset($_POST['cfv-prevenr-die'])) {
							$prevent_value = sanitize_text_field($_POST['cfv-prevenr-die']);
							$prevent_value = !empty($prevent_value) ? $prevent_value : "no";
							# update prevent option value
							update_option('cfv-prevenr-die', $prevent_value);
						}

						# update label
						if (isset($_POST['cfv-comment-post-label'])) {
							$label_value = sanitize_text_field($_POST['cfv-comment-post-label']);
							$label_value = !empty($label_value) ? $label_value : "";
							# update lable value
							update_option('cfv-comment-post-label', $label_value);				           
						}
						# form data saved message
						$form_msg = '<b style="color:green;">Settings Saved.</b><br/>';
					}
				}
			}
			# get value of enable validation
			$enable_validation = esc_attr(get_option('cfv-enable-comment-validation'));
			# get value of prevent die
			$prevent_die = esc_attr(get_option('cfv-prevenr-die'));
			# get value of post label
			$label_value = esc_attr(get_option('cfv-comment-post-label'));
			?>
			<!-- cfv Settings -->
			<div class="wrap">
				<h2><?php esc_html_e('Comment Form Customization','comment-form-validation-and-customization'); ?></h2>
				<div id="cfv-setting-container">
					<div id="cfv-body">
						<div id="cfv-body-content">
							<div class="">
								<br/><?php _e($form_msg,'comment-form-validation-and-customization'); ?><hr/><br/>
								<form method="post">

									<!-- Enable comment validation Section -->
									<table>
										<tr valign="top">
											<th scope="row">
												<label for="cfv-enable-comment-validation"><?php _e('Enable Validation? &nbsp;&nbsp;&nbsp;','comment-form-validation-and-customization'); ?></label></th>
											<td>	
												<?php $yes_checked = ($enable_validation == "yes") ? 'checked="checked"' : "";?>
												<?php $no_checked = ($enable_validation == "no") ? 'checked="checked"' : "";?>
												<input type="radio" name="cfv-enable-comment-validation" id="enable-yes" value="yes" <?php echo $yes_checked; ?> ><label for="enable-yes"><?php _e('Yes','comment-form-validation-and-customization'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="cfv-enable-comment-validation" id="enable-no" value="no" <?php echo $no_checked; ?>><label for="enable-no"><?php _e('No','comment-form-validation-and-customization'); ?></label>
											</td>
										</tr>
									</table>
									<span>Enable validation on required field of comment form.</span>
									<br/><hr><br/>
									<!-- Enable comment validation Section end -->

									<!-- duplicate comment Section -->
									<table>
										<tr valign="top">
											<th scope="row">
												<label for="cfv-prevenr-die"><?php _e('Prevent die on duplicate comment&nbsp;&nbsp;&nbsp;','comment-form-validation-and-customization'); ?></label></th>
											<td>	
												<?php $yes_checked = ($prevent_die == "yes") ? 'checked="checked"' : "";?>
												<?php $no_checked = ($prevent_die == "no") ? 'checked="checked"' : "";?>
												<input type="radio" name="cfv-prevenr-die" id="prevent-yes" value="yes" <?php echo $yes_checked; ?> ><label for="prevent-yes"><?php _e('Yes','comment-form-validation-and-customization'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="cfv-prevenr-die" id="prevent-no" value="no" <?php echo $no_checked; ?>><label for="prevent-no"><?php _e('No','comment-form-validation-and-customization'); ?></label>
											</td>
										</tr>
									</table>
									<span>Prevent to die on duplicate comment and override default behaviour and display duplicate comment message.</span>
									<br/><hr><br/>
									<!-- duplicate comment Section end -->

									<!-- post Comment button label -->
									<table>
											<tr valign="top">
											<th scope="row"><label for="cfv-comment-post-label"><?php _e('Post Comment submit Text &nbsp;&nbsp;&nbsp; ','comment-form-validation-and-customization'); ?></label></th>
											<td>
												<input type="text" name="cfv-comment-post-label" id="cfv-comment-post-label" value="<?php echo esc_html($label_value); ?>" />
												</td>
											</tr>
									</table>
									<span>Change a Text of comment form submit button.</span>
									<!-- post Comment button label end -->
									<br/><hr><br/>

									<?php wp_nonce_field( 'cfv_setting_action_nonce', 'cfv_setting_field_nonce' ); ?>
									<?php  submit_button( 'Save Settings', 'primary', 'cvf-form-settings'  ); ?>
								</form>
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
			</div>
		<?php

	}

}
