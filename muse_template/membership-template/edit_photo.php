<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post;

// プレビュー確認はsingle-photo.php
if (is_tcd_membership_preview_photo()) :
	get_template_part('single-photo');
	return;
endif;

get_header();
?>
<?php
// 完了画面
if (!empty($tcd_membership_vars['complete'])) :
?>
	<div class="l-inner">
		<div class="p-member-page p-edit-photo">
			<div class="p-membership-form__complete-static">
				<?php
				$headline = null;
				$desc = null;
				switch ($tcd_membership_vars['complete']):
					case 'publish':
						if ($dp_options['membership']['edit_photo_complete_publish_headline']) :
							$headline = $dp_options['membership']['edit_photo_complete_publish_headline'];
						else :
							$headline = sprintf(__('%s was published.', 'tcd-w'), $dp_options['photo_label']);
						endif;
						if ($dp_options['membership']['edit_photo_complete_publish_desc']) :
							$desc = $dp_options['membership']['edit_photo_complete_publish_desc'];
						endif;
						break;

					case 'private':
						if ($dp_options['membership']['edit_photo_complete_private_headline']) :
							$headline = $dp_options['membership']['edit_photo_complete_private_headline'];
						else :
							$headline = sprintf(__('%s saved as private.', 'tcd-w'), $dp_options['photo_label']);
						endif;
						if ($dp_options['membership']['edit_photo_complete_private_desc']) :
							$desc = $dp_options['membership']['edit_photo_complete_private_desc'];
						endif;
						break;

					case 'pending':
						if ($dp_options['membership']['edit_photo_complete_pending_headline']) :
							$headline = $dp_options['membership']['edit_photo_complete_pending_headline'];
						else :
							$headline = sprintf(__('%s saved as pending.', 'tcd-w'), $dp_options['photo_label']);
						endif;
						if ($dp_options['membership']['edit_photo_complete_pending_desc']) :
							$desc = $dp_options['membership']['edit_photo_complete_pending_desc'];
						endif;
						break;

					case 'draft':
						if ($dp_options['membership']['edit_photo_complete_draft_headline']) :
							$headline = $dp_options['membership']['edit_photo_complete_draft_headline'];
						else :
							$headline = sprintf(__('%s saved as draft.', 'tcd-w'), $dp_options['photo_label']);
						endif;
						if ($dp_options['membership']['edit_photo_complete_draft_desc']) :
							$desc = $dp_options['membership']['edit_photo_complete_draft_desc'];
						endif;
						break;

					case 'updated':
						if ($dp_options['membership']['edit_photo_complete_update_headline']) :
							$headline = $dp_options['membership']['edit_photo_complete_update_headline'];
						else :
							$headline = sprintf(__('%s updated.', 'tcd-w'), $dp_options['photo_label']);
						endif;
						if ($dp_options['membership']['edit_photo_complete_update_desc']) :
							$desc = $dp_options['membership']['edit_photo_complete_update_desc'];
						endif;
						break;

					default:
						$headline = sprintf(__('%s saved.', 'tcd-w'), $dp_options['photo_label']);
						break;
				endswitch;
				?>
				<h2 class="p-member-page-headline--color"><?php echo esc_html($headline); ?></h2>
				<?php
				if ($desc) :
					if (false !== strpos($desc, '[post_url]')) :
						$desc = str_replace('[post_url]', get_permalink($_REQUEST['post_id']), $desc);
					endif;
					if (false !== strpos($desc, '[author_url]')) :
						$desc = str_replace('[author_url]', get_author_posts_url(get_current_user_id()), $desc);
					endif;
				?>
					<div class="p-membership-form__body p-body p-membership-form__desc"><?php echo wpautop($desc); ?></div>
				<?php
				endif;
				?>
				<div class="p-membership-form__button">
					<a class="p-button p-rounded-button" href="<?php echo esc_attr(get_author_posts_url(get_current_user_id())); ?>"><?php _e('Profile page', 'tcd-w'); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php
// フォーム表示
else :
	// TODO: 画像のアップロード方法の調査 by H.Okabe
?>
	<div class="container pt-2">
		<form id="js-membership-edit-photo" class="p-membership-form js-membership-form--normal" action="" enctype="multipart/form-data" method="post">
			<input type="file" name="file" id="file-input" accept="image/png, image/jpeg">
			<div class="card py-2" id="preview_container">
				<div id="img_preview" class="img-preview d-flex align-items-center">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/add_image360-250.png" style="margin-left: auto; margin-right: auto; display:block;">
				</div>
			</div>
			<div class="row pt-4">
				<div class="col-12">
					<label for="title">タイトル</label>
				</div>
				<div class="col-12 pb-3">
					<input type="text" name="post_title" class="form-control" value="<?php echo esc_attr($tcd_membership_post->post_title); ?>" placeholder="タイトルを入力" required>
				</div>
				<div class="col-12">
					<label for="details">詳細</label>
				</div>
				<div class="col-12 pb-3">
					<input type="text" name="post_content" class="form-control" value="<?php echo esc_textarea($tcd_membership_post->post_content); ?>" placeholder="説明を入力" required>
				</div>
				<div class="col-12">
					販売形式
				</div>
				<div class="col-12 pb-3">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="normal_sales" name="sales_format" class="custom-control-input">
						<label class="custom-control-label" for="normal_sales">通常販売</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="auction" name="sales_format" class="custom-control-input" checked>
						<label class="custom-control-label" for="auction">オークション</label>
					</div>
				</div>
				<div class="col-12">
					<label for="selling_price">販売価格</label>
				</div>
				<div class="col-12 pb-3">
					<input type="number" name="selling_price" id="selling_price" class="form-control">
				</div>
				<div class="col-12">
					<label for="bin_price">即決価格</label>
				</div>
				<div class="col-12 pb-3">
					<input type="number" name="bin_price" id="bin_price" class="form-control">
				</div>
				<div class="col-12">
					オークション開始日時
				</div>
				<div class="col-12 pb-2">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="not_specified" name="auction_datetime" class="custom-control-input">
						<label class="custom-control-label" for="not_specified">指定しない</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="specify" name="auction_datetime" class="custom-control-input" checked>
						<label class="custom-control-label" for="specify">開始時間指定</label>
					</div>
				</div>
				<div class="col-12 pb-3">
					<input type="date" name="">
					<select class="time" name="hour">
						<option value="24">24</option>
					</select>
					時
					<select name="mimute">
						<option value="00">00</option>
						<option value="00">15</option>
						<option value="30">30</option>
						<option value="30">45</option>
					</select>
					分
				</div>
				<div class="col-12 pb-1">
					オークション終了日時
				</div>
				<div class="col-12 pb-3">
					<input type="date" name="">
					<select class="time" name="hour">
						<option value="24">24</option>
					</select>
					時
					<select name="minute">
						<option value="00">00</option>
						<option value="00">15</option>
						<option value="30">30</option>
						<option value="30">45</option>
					</select>
					分
				</div>
				<div class="col-12 pb-1">
					オークション自動延長
				</div>
				<div class="col-12 pb-1">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="auto_extension_true" name="auto_extension" class="custom-control-input">
						<label class="custom-control-label" for="auto_extension_true">あり</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="auto_extension_false" name="auto_extension" class="custom-control-input" checked>
						<label class="custom-control-label" for="auto_extension_false">なし</label>
					</div>
					<p>※終了5分前に入札されると、5分延長されます。</p>
				</div>
				<div class="col-12">
					<div class="form-check mb-1">
						<input class="form-check-input" type="checkbox" value="" id="" />
						<label class="form-check-label" for="">
							<a href="#!" class="text-body"><u class="text-muted">利用規約</u></a>に同意する。
						</label>
					</div>
				</div>
				<div class="col-12">
					<div class="d-flex justify-content-center pt-4 pb-2">
						<button type="button" class="btn btn-primary text-white btn-block gradient-custom-4 font-weight-bold">出品する
						</button>
					</div>
				</div>
			</div>
			<input type="hidden" name="post_id" value="<?php echo esc_attr($tcd_membership_post->ID); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-' . $tcd_membership_vars['memberpage_type'] . '-' . $tcd_membership_post->ID)); ?>">
		</form>
	</div>
	<script type="text/javascript">
		const sizeLimit = 1024 * 1024 * 100;
		const smartPhoneWidth = 600;
		let fileInput = document.getElementById('file-input');
		let preview = document.getElementById('img_preview');
		let container = document.getElementById('preview_container');

		fileInput.addEventListener('change', function() {
			let file = this.files[0]
			if (file.size > sizeLimit) {
				alert('ファイルのサイズは100MB以下にしてください')
				fileInput.value = '';
				return;
			}
			previewFile(file);
		});

		function previewFile(file) {
			let fr = new FileReader();
			fr.readAsDataURL(file);
			fr.onload = function() {
				let img = document.createElement('img');
				if (screen.width > smartPhoneWidth) {
					img.style.cssText = "max-height: 250px;" +
						"display: block;" +
						"margin-left: auto;" +
						"margin-right: auto;";
				} else {
					img.style.cssText = "max-height: 250px;" +
						"display: block;" +
						"margin-left: auto;" +
						"margin-right: auto;";
				}
				img.setAttribute('src', fr.result);
				container.style.display = "";
				preview.innerHTML = '';
				preview.appendChild(img);
			};
		}
	</script>
<?php
endif;
?>
<?php
get_footer();
