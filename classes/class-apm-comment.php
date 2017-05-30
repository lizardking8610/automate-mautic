<?php
/**
 * Mautic for WordPress initiate
 *
 * @package automateplus-mautic
 * @since 1.0.0
 */

if ( ! class_exists( 'APMautic_Comment' ) ) :

	/**
	 * Create class APMautic_Comment
	 * Handles register post type, trigger actions
	 */
	class APMautic_Comment {

		/**
		 * Declare a static variable instance.
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 * Initiate class
		 *
		 * @since 1.0.0
		 * @return object
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new APMautic_Comment();
				self::$instance->hooks();
			}
			return self::$instance;
		}

		/**
		 * Call comment post hook
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function hooks() {
			add_action( 'comment_post', array( $this, 'add_comment_author' ), 10, 3 );
		}

		/**
		 * Add comments author to Mautic contacts
		 *
		 * @since 1.0.0
		 * @param int    $id comment author ID.
		 * @param string $approved Comment status.
		 * @param array  $commentdata Comment author data.
		 * @return void
		 */
		public function add_comment_author( $id, $approved, $commentdata ) {

			$all_tags = '';
			// get comment post condition rules.
			$status = APMautic_RulePanel::get_comment_condition( $commentdata );

			// return if the $status is not as expected.
			if ( ! is_array( $status ) || sizeof( $status ) == 0 ) {
				return;
			}

			$set_actions = APMautic_RulePanel::get_all_actions( $status );

			$email = $commentdata['comment_author_email'];

			$body = array(
				'firstname'	=> $commentdata['comment_author'],
				'email'		=> $commentdata['comment_author_email'],
				'website'	=> $commentdata['comment_author_url'],
			);

			$api_data = APMautic_API::get_api_method_url( $email );
			$url = $api_data['url'];
			$method = $api_data['method'];

				// add tags set in actions.
			if ( isset( $set_actions['add_tag'] ) ) {

				foreach ( $set_actions['add_tag'] as $tags ) {
					$all_tags .= $tags . ',';
				}

				$all_tags = rtrim( $all_tags ,',' );
				$body['tags'] = $all_tags;
			}

			APMautic_API::ampw_mautic_api_call( $url, $method, $body, $set_actions );
		}
	}
	APMautic_Comment::instance();
endif;
