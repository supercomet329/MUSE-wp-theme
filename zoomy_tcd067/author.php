<?php
global $dp_options;
if (!$dp_options) $dp_options = get_design_plus_option();
$author = get_queried_object();
$list_totals = get_author_list_totals($author->ID);
get_header();
?>
<main role="main">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">タイムライン切り替え</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="cp_ipradio">
						<ul style="list-style: none;">
							<li class="list_item">
								<label>
									<input type="radio" class="option-input" name="a" checked>
									　通常モード
								</label>
							</li>
							<li class="list_item">
								<label>
									<input type="radio" class="option-input" name="a">
									　ピクチャーモード
								</label>
							</li>
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="cover-area">
		<img src="<?php echo esc_url($author->header_image); ?>" class="img-fluid">
	</div>
	<div class="container profile-area">
		<div class="icon">
			<img src="<?php echo esc_url($author->profile_image); ?>" class="rounded-circle" width="80">
		</div>
		<?php if(get_current_user_id() === (int)$author->ID) { ?>
		<div class="name d-flex justify-content-between">
			<a href="<?php echo esc_url(get_tcd_membership_memberpage_url('edit_profile')); ?>" class="btn-sm btn-primary" role="button" aria-pressed="true">プロフィール編集</a>
		</div>
		<?php } ?>
		<div class="username"><?php echo esc_html($author->display_name); ?></div>
		<div class="mt-3 self-introduction">
			<?php echo esc_html($author->description); ?>
		</div>
		<div class="d-flex justify-content-around">
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				<?php echo esc_html($author->area); ?>
			</div>
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				<?php echo esc_html($authorr->user_url); ?>
			</div>
		</div>
		<div class="d-flex justify-content-around">
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				投稿数: <?php echo $list_totals['photo']['total']; ?>
			</div>
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				フォロー: <?php echo $list_totals['following']['total']; ?>
			</div>
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				フォロワー: <?php echo $list_totals['follower']['total']; ?>
			</div>
			<div class="mt-3" style="border: 0.9px rgba(90, 90, 90, 0.473) solid; width: 40%; height:auto; margin-left: 2%;">
				<?php
				// TODO: 2022/05/09 いいね数の取得 
				?>
				いいね: 20000
			</div>
		</div>
	</div>
	<?php
	// TODO: 2022/05/09 画像投稿できるようになったら投稿を確認
	$list_photo = list_author_post($author->ID, 'photo');
	$list_slice_photo = array_chunk($list_photo, 3);
	$i = 0;
	?>
	<?php foreach ($list_slice_photo as $array_slice_photo) { ?>
		<?php if ($i <= 0) { ?>
			<div class="content pt-5 pb-1">
			<?php } else { ?>
				<div class="content">
				<?php } ?>
				<?php foreach ($array_slice_photo as $one_photo) { ?>
					<div class="content-item shadow d-flex align-items-center justify-content-center px-1">
						<img class="image-list" src="<?php echo $one_photo->meta_value; ?>">
					</div>
				<?php } ?>
				</div>
			<?php
			$i++;
		}
		/** endforeach */
			?>
			<?php
			get_footer();
