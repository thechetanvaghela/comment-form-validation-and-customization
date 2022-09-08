<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/thechetanvaghela/
 * @since      1.0.0
 *
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cv_Comment_Form_Validation
 * @subpackage Cv_Comment_Form_Validation/public
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Cv_Comment_Form_Validation_Public {

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

	/* 
	* Custom post id 
	*
	*  @since    1.0.0
	*/
	private $comment_post_id;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cv-comment-form-validation-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		$enable_validation = esc_attr(get_option('cfv-enable-comment-validation'));
		$enable_validation = !empty($enable_validation) ? $enable_validation : "no";
		if(!empty($enable_validation) && $enable_validation == "yes"){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cv-comment-form-validation-public.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * capture comment post id.
	 *
	 * @since    1.0.0
	 */
	public function cfv_capture_post_id( $comment ) {
        $this->comment_post_id = isset( $comment[ 'comment_post_ID' ] ) ? $comment[ 'comment_post_ID' ] : 0;
        return $comment;
    }

	/**
	 * comment handel redirect.
	 *
	 * @since    1.0.0
	 */
    public function cfv_handle_redirect() {
        if ( !empty( $this->comment_post_id ) ) {
            wp_safe_redirect( get_permalink( get_post( $this->comment_post_id ) ).'?cfv_duplicate_comment=yes#cfv-duplicate-msg' );
            die();
        }
    }

	/**
	 * duplicate comment message.
	 *
	 * @since    1.0.0
	 */
	public function cfv_comment_form_after_callback( $post_id ){
		if(isset($_GET['cfv_duplicate_comment']) && !empty($_GET['cfv_duplicate_comment']) )
		{
			if($_GET['cfv_duplicate_comment'] == 'yes')
			{
				echo '<div id="cfv-duplicate-msg" class="cfv-text-center cfv-mt-20">';
				echo '<span class="cfv-text-red">Duplicate comment detected; it looks as though you’ve already said that!</span>';
				echo '</div>';
			}
		}
	}

	/**
	 * change post comment submit button text.
	 *
	 * @since    1.0.0
	 */
	public function cfv_change_comment_form_submit_label($arg) {
		$label_value = esc_attr(get_option('cfv-comment-post-label'));
		if(!empty($label_value)){
			$arg['label_submit'] = $label_value;
		}
		return $arg;
	}

}
