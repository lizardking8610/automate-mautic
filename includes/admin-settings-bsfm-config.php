<div id="fl-bsfm-config-form" class="bsfm-settings-form bsfm-config-bsfm-settings-form">

	<h3 class="bsfm-settings-form-header"><?php _e( 'Mautic Configuration', 'bsfmautic' ); ?></h3>

	<form id="bsfm-config-form" action="<?php BSFMauticAdminSettings::render_form_action( 'bsfm-config' ); ?>" method="post">
		<div class="bsfm-settings-form-content">
			<?php
				$bsfm 	=	BSF_Mautic_Helper::get_bsfm_mautic();
				$bsfm_enabled_track = $bsfm_base_url = $bsfm_public_key = $bsfm_secret_key = $bsfm_callback_uri = $bsfm_enabled_track_img = '';
				if( is_array($bsfm) ) {
					$bsfm_enabled_track	= ( array_key_exists( 'bsfm-enabled-tracking', $bsfm ) && $bsfm['bsfm-enabled-tracking'] == 1 )  ? ' checked' : '';
					$bsfm_enabled_track_img	= ( array_key_exists( 'bsfm-enabled-tracking-img', $bsfm ) && $bsfm['bsfm-enabled-tracking-img'] == 1 )  ? ' checked' : '';				
					$bsfm_base_url = ( array_key_exists( 'bsfm-base-url', $bsfm ) ) ? $bsfm['bsfm-base-url'] : '';
					$bsfm_public_key = ( array_key_exists( 'bsfm-public-key', $bsfm ) ) ? $bsfm['bsfm-public-key'] : '';
					$bsfm_secret_key = ( array_key_exists( 'bsfm-secret-key', $bsfm ) ) ? $bsfm['bsfm-secret-key'] : '';
					$bsfm_callback_uri = ( array_key_exists( 'bsfm-callback-uri', $bsfm ) ) ? $bsfm['bsfm-callback-uri'] : '';
				}
			?>
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
				<input type="text" class="regular-text" name="bsfm-public-key" value="<?php echo $bsfm_public_key; ?>" class="bsfm-wp-text bsfm-google-map-api" />
			</div>
			
			<!-- Client Secret Key -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Secret Key', 'bsfmautic' ); ?></h4>	
				<input type="text" class="regular-text" name="bsfm-secret-key" value="<?php echo $bsfm_secret_key; ?>" class="bsfm-wp-text bsfm-google-map-api" />
				<p class="bsfm-admin-help">
					<?php _e('This setting is required to integrate Mautic in your website. Need help to get Mautic API public and secret key? Read ', 'bsfmautic'); ?><a target="_blank" href="http://docs.sharkz.in/how-to-get-mautic-api-credentials/"><?php _e('this article', 'bsfmautic'); ?></a>
				</p>
			</div>
			<p class="submit">
				<input type="submit" name="bsfm-save-authenticate" class="button-primary" value="<?php esc_attr_e( 'Save and Authenticate', 'bsfmautic' ); ?>" />
				<span class="bsf-mautic-status-disconnect"> <?php _e('Not Connected', 'bsfmautic'); ?> </span>
			</p>
			<?php } ?>
				<?php
				// If not authorized 
				if( isset( $credentials['access_token'] ) ) { ?>
				<p class="submit">
					<span class="bsf-mautic-status-connected"> Connected </span>
					<input type="submit" name="bsfm-disconnect-mautic" class="button" value="<?php esc_attr_e( 'Disconnect Mautic', 'bsfmautic' ); ?>" />
				</p>
				<?php } ?>
			<!-- Enable pixel tracking -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Enable Javascript (JS) Tracking', 'bsfmautic' ); ?></h4>
				<p class="bsfm-admin-help">
					<?php _e( 'This setting enable you to add Mautic tracking JS to your site. Mautic instance will be able to track information about your visitors that way. Need more information about JS tracking? Read <a href="https://mautic.org/docs/en/contacts/contact_monitoring.html">this article</a>', 'bsfmautic'); ?>
				</p>
				<label>
					<input type="checkbox" class="bsfm-enabled-panels" name="bsfm-enabled-tracking" value="" <?php echo $bsfm_enabled_track; ?> ><?php _e( 'Enable JS Tracking', 'bsfmautic' ); ?>
				</label>
			</div>

			<!-- Load Panels -->
			<!-- Enable image tracking -->
			<div class="bsfm-config-fields">
				<h4><?php _e( 'Enable Image Tracking', 'bsfmautic' ); ?></h4>
				<p class="bsfm-admin-help">
					<?php _e( 'This setting enable you to add Mautic tracking image to your site. Mautic instance will be able to track information about your visitors that way. Need more information about pixel tracking? Read <a href="https://mautic.org/docs/en/contacts/contact_monitoring.html">this article</a>', 'bsfmautic'); ?>
				</p>
				<label>
					<input type="checkbox" class="bsfm-enabled-panels" name="bsfm-enabled-tracking-img" value="" <?php echo $bsfm_enabled_track_img; ?> ><?php _e( 'Enable Image Tracking', 'bsfmautic' ); ?>
				</label>
			</div>
		</div>
		<p class="submit">
			<input type="submit" name="fl-save-bsfm" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'bsfmautic' ); ?>" />
		</p>
		<?php wp_nonce_field('bsfmautic', 'bsf-mautic-nonce'); ?>
	</form>
</div>