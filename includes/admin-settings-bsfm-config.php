<div id="fl-bsfm-config-form" class="bsfm-settings-form bsfm-config-bsfm-settings-form">

	<?php 
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'all_rules';
		if( isset( $_GET['action'] ) ) {
			$current_action = $_GET[ 'action' ];
			$active_tab = '';
		}
		else {
			$current_action = '';
		}
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=bsf-mautic&tab=all_rules" class="nav-tab <?php echo $active_tab == 'all_rules' ? 'nav-tab-active' : ''; ?>"> <?php _e('All Rules', 'bsfmautic'); ?> </a>
		<?php if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) { ?>
			<a href="?page=bsf-mautic&tab=edd_mautic" class="nav-tab <?php echo $active_tab == 'edd_mautic' ? 'nav-tab-active' : ''; ?>"> <?php _e('EDD', 'bsfmautic'); ?> </a>
		<?php } ?>
		<a href="?page=bsf-mautic&tab=auth_mautic" class="nav-tab <?php echo $active_tab == 'auth_mautic' ? 'nav-tab-active' : ''; ?>"> <?php _e('Authenticate', 'bsfmautic'); ?> </a>
		<a href="?page=bsf-mautic&tab=enable_tracking" class="nav-tab <?php echo $active_tab == 'enable_tracking' ? 'nav-tab-active' : ''; ?>"> <?php _e('Tracking', 'bsfmautic'); ?> </a>
	</h2>
	<?php
	if( $active_tab == 'all_rules' ) {
			BSFMauticAdminSettings::bsfm_rules_list();
	}
	if( $active_tab == 'add_new_rule' || $current_action == 'edit' ) { ?>
		<?php
			Bsfm_Postmeta::bsf_mautic_metabox_view();
		?>
	<?php }
	?>
	<form id="bsfm-config-form" action="<?php BSFMauticAdminSettings::render_form_action( 'bsfm-config' ); ?>" method="post">
		<div class="bsfm-settings-form-content">
			<?php
				$bsfm 	=	BSF_Mautic_Helper::get_bsfm_mautic();
				$bsfm_enabled_track = $bsfm_base_url = $bsfm_public_key = $bsfm_secret_key = $bsfm_callback_uri = $bsfm_enabled_track_img = $bsfm_enabled_track_show = $bsfm_proactive_tracking = '';
				if( is_array($bsfm) ) {
					$bsfm_enabled_track	= ( array_key_exists( 'bsfm-enabled-tracking', $bsfm ) && $bsfm['bsfm-enabled-tracking'] == 1 )  ? ' checked' : '';
					$bsfm_enabled_track_show = ( array_key_exists( 'bsfm-enabled-tracking', $bsfm ) && $bsfm['bsfm-enabled-tracking'] == 1 )  ? 'style="display: block;"' : 'style="display: none;"';
					$bsfm_base_url = ( array_key_exists( 'bsfm-base-url', $bsfm ) ) ? $bsfm['bsfm-base-url'] : '';
					$bsfm_public_key = ( array_key_exists( 'bsfm-public-key', $bsfm ) ) ? $bsfm['bsfm-public-key'] : '';
					$bsfm_secret_key = ( array_key_exists( 'bsfm-secret-key', $bsfm ) ) ? $bsfm['bsfm-secret-key'] : '';
					$bsfm_callback_uri = ( array_key_exists( 'bsfm-callback-uri', $bsfm ) ) ? $bsfm['bsfm-callback-uri'] : '';

					$bsfm_edd_prod_slug	= ( array_key_exists( 'bsfm_edd_prod_slug', $bsfm ) && $bsfm['bsfm_edd_prod_slug'] == 1 )  ? ' checked' : '';
					$bsfm_edd_prod_cat = ( array_key_exists( 'bsfm_edd_prod_cat', $bsfm ) && $bsfm['bsfm_edd_prod_cat'] == 1 )  ? ' checked' : '';
					$bsfm_edd_prod_tag	= ( array_key_exists( 'bsfm_edd_prod_tag', $bsfm ) && $bsfm['bsfm_edd_prod_tag'] == 1 )  ? ' checked' : '';
					$bsfm_proactive_tracking = ( array_key_exists( 'bsfm_proactive_tracking', $bsfm ) && $bsfm['bsfm_proactive_tracking'] == 1 )  ? ' checked' : '';
					$ss_seg_action = ( array_key_exists( 'config_edd_segment', $bsfm ) ) ? $bsfm['config_edd_segment'] : '';
					$ss_seg_action_ab = ( array_key_exists( 'config_edd_segment_ab', $bsfm ) ) ? $bsfm['config_edd_segment_ab'] : '';
				}

			if( $active_tab == 'auth_mautic' ) { ?>
			<!-- Base Url -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Base URL', 'bsfmautic' ); ?></h4>
				<p class="bsfm-admin-help">
					<?php _e('This setting is required for Mautic Integration.', 'bsfmautic'); ?>
				</p>
				<input type="text" class="regular-text" name="bsfm-base-url" value="<?php echo $bsfm_base_url; ?>" class="bsfm-wp-text bsfm-google-map-api" />
			</div>

			<?php 
			$credentials = get_option( 'bsfm_mautic_credentials' );
			if( ! isset( $credentials['access_token'] ) ) { ?>
			<!-- Client Public Key -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Public Key', 'bsfmautic' ); ?></h4>
				<input type="text" class="regular-text" name="bsfm-public-key" class="bsfm-wp-text bsfm-google-map-api" />
			</div>
			
			<!-- Client Secret Key -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Secret Key', 'bsfmautic' ); ?></h4>	
				<input type="text" class="regular-text" name="bsfm-secret-key" class="bsfm-wp-text bsfm-google-map-api" />
				<p class="bsfm-admin-help">
					<?php _e('This setting is required to integrate Mautic in your website.<br>Need help to get Mautic API public and secret key? Read ', 'bsfmautic'); ?><a target='_blank' href="https://docs.brainstormforce.com/how-to-get-mautic-api-credentials/"><?php _e('this article.', 'bsfmautic'); ?></a>
				</p>
			</div>
			<p class="submit">
				<input type="submit" name="bsfm-save-authenticate" class="button-primary" value="<?php esc_attr_e( 'Save and Authenticate', 'bsfmautic' ); ?>" />
			</p>

			<?php wp_nonce_field('bsfmautic', 'bsf-mautic-nonce'); ?>
			<?php } ?>
				<?php
				// If not authorized 
				if( isset( $credentials['access_token'] ) ) { ?>
				<p class="submit">
					<input type="button" name="bsfm-disconnect-mautic" class="button-primary" value="<?php _e( 'Connected', 'bsfmautic' ); ?>" />
					<!-- input type="submit" name="bsfm-disconnect-mautic" class="button" value="<?php esc_attr_e( 'Disconnect Mautic', 'bsfmautic' ); ?>" / -->
					<a class="bsfm-disconnect-mautic"> <?php _e( 'Disconnect Mautic', 'bsfmautic' ); ?> </a> 
				</p>
				<?php } ?>
			<!-- Enable pixel tracking -->
			<?php 
			}

			//EDD tab
			if( $active_tab == 'edd_mautic' ) { ?>
				<div class="bsfm-config-fields">
					<h4><?php _e( 'EDD Default Segments', 'bsfmautic' ); ?></h4>
					<p>
						<label><?php _e( 'Add all customers to this segment', 'bsfmautic' ); ?></label>
						<div class="second-action" style="display:inline;">
							<?php Bsfm_Postmeta::select_all_segments( $ss_seg_action ); ?>
						</div>
					</p>
					<p>
						<label><?php _e( 'Add abandoned customers to this segment', 'bsfmautic' ); ?></label>
						<div class="second-action" style="display:inline;">
							<?php Bsfm_Postmeta::select_all_segments( $ss_seg_action_ab ); ?>
						</div>
					</p>

					<h4><?php _e( 'EDD Default Tags', 'bsfmautic' ); ?></h4>	
					<p>
						<label>
							<input type="checkbox" class="bsfm-enabled-panels" name="bsfm_edd_prod_slug" value="" <?php echo $bsfm_edd_prod_slug; ?> ><?php _e( 'Automatically add EDD product slug as a tag in Mautic', 'bsfmautic' ); ?>
						</label><br>
						<label>
							<input type="checkbox" class="bsfm-enabled-panels" name="bsfm_edd_prod_cat" value="" <?php echo $bsfm_edd_prod_cat; ?> ><?php _e( 'Automatically add EDD product category as a tag in Mautic
', 'bsfmautic' ); ?>
						</label><br>
						<label>
							<input type="checkbox" class="bsfm-enabled-panels" name="bsfm_edd_prod_tag" value="" <?php echo $bsfm_edd_prod_tag; ?> ><?php _e( 'Automatically add EDD tags in Mautic', 'bsfmautic' ); ?>
						</label><br>
					</p>	

					<h4><?php _e( 'Proactive Abandonment Tracking', 'bsfmautic' ); ?></h4>	
					<p>
						<label>
							<input type="checkbox" class="bsfm-enabled-panels" name="bsfm_proactive_tracking" value="" <?php echo $bsfm_proactive_tracking; ?> ><?php _e( 'Enable Proactive Abandonment Tracking', 'bsfmautic' ); ?>
						</label><br>
					</p>	

					<p class="submit">
						<input type="submit" name="save-bsfm" class="button-primary button button-large" value="<?php esc_attr_e( 'Save Settings', 'bsfmautic' ); ?>" />
					</p>
					<?php wp_nonce_field('bsfmauticedd', 'bsf-mautic-nonce-edd'); ?>
				</div>
			<?php
			}

			if( $active_tab == 'enable_tracking' ) { ?>
 			<div class="bsfm-config-fields">
				<h4><?php _e( 'Enable Mautic Tracking', 'bsfmautic' ); ?></h4>
				<p class="bsfm-admin-help">
					<?php _e( 'This setting enables you to add Mautic tracking code in your site.<br>Need more information about tracking? Read <a target="_blank" href="https://mautic.org/docs/en/contacts/contact_monitoring.html">this article</a>.', 'bsfmautic'); ?>
				</p>
				<label>
					<input type="checkbox" class="bsfm-enabled-panels" name="bsfm-enabled-tracking" value="" <?php echo $bsfm_enabled_track; ?> ><?php _e( 'Enable Tracking', 'bsfmautic' ); ?>
				</label><br>
			</div>
			<p class="submit">
				<input type="submit" name="save-bsfm" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'bsfmautic' ); ?>" />
			</p>
			<?php wp_nonce_field('bsfmautictrack', 'bsf-mautic-nonce-tracking'); ?>
		<?php } ?>
		</div>
	</form>
</div>