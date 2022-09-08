<?php

/**
 * Fired during plugin activation
 *
 * @link       https://profiles.wordpress.org/thechetanvaghela/
 * @since      1.0.0
 *
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Cv_Comment_Form_Validation_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		# set default value
		update_option('cfv-enable-comment-validation', 'yes');
		update_option('cfv-prevenr-die', 'yes');
		update_option('cfv-comment-post-label','Leave Comment');

	}

}
