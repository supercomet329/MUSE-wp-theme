<?php
global $dp_options, $guest_permission_options;
?>
<?php // 写真設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Photo settings', 'tcd-w' ); ?></h3>
	<ul>
		<li><label><input name="dp_options[membership][use_front_edit_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_front_edit_photo'] ); ?>><?php _e( 'User can add/edit/delete photo in frontend', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][use_front_edit_photo_pending]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_front_edit_photo_pending'] ); ?>><?php _e( 'Requires review of Administrator or Editor for publish photo', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][use_like_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['use_like_photo'] ); ?>><?php _e( 'Use Like', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][disable_oembed_internal_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['disable_oembed_internal_photo'] ); ?>><?php _e( "Turn off the oEmbed feature of your site's URL", 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[membership][disable_oembed_external_photo]" type="checkbox" value="1" <?php checked( 1, $dp_options['membership']['disable_oembed_external_photo'] ); ?>><?php _e( "Turn off the oEmbed feature of other site's URL", 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e( 'Guest permission settings', 'tcd-w' ); ?></h3>
	<fieldset class="radios">
		<?php foreach ( $guest_permission_options as $option ) : ?>
		<label><input type="radio" name="dp_options[membership][guest_permission_photo]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['membership']['guest_permission_photo'] ); ?>><?php printf( $option['label'], __( 'Photo', 'tcd-w' ), __( 'Photo', 'tcd-w' ) ); ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 投稿編集設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Add / Edit photo settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Add photo note below "Preview Confirm" button', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][add_photo_note]"><?php echo esc_textarea( $dp_options['membership']['add_photo_note'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Edit photo note below "Preview Confirm" button', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_note]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_note'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Add / Edit photo complete message settings', 'tcd-w' ); ?></h4>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to published', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to published', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_photo_complete_publish_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_photo_complete_publish_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to published', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_complete_publish_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_complete_publish_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to private', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to private', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_photo_complete_private_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_photo_complete_private_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to private', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_complete_private_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_complete_private_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to pending', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to pending', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_photo_complete_pending_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_photo_complete_pending_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to pending', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_complete_pending_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_complete_pending_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to draft', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of complete to draft', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_photo_complete_draft_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_photo_complete_draft_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of complete to draft', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_complete_draft_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_complete_draft_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Complete to update (No status change)', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Headline of update', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[membership][edit_photo_complete_update_headline]" value="<?php echo esc_attr( $dp_options['membership']['edit_photo_complete_update_headline'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Description of update', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="4" name="dp_options[membership][edit_photo_complete_update_desc]"><?php echo esc_textarea( $dp_options['membership']['edit_photo_complete_update_desc'] ); ?></textarea>
				<p class="description"><?php _e( 'Available Variables', 'tcd-w' ); ?>: [post_url], [author_url]</p>
			</div>
		</div>
	</div>
	<input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
</div>
