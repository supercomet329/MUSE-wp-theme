<?php
global $dp_options, $tcd_membership_vars;

$email = '';
$messageComplete = false;
if (isset($tcd_membership_vars['reset_password'])) {
	$email = $tcd_membership_vars['reset_password']['email'];
	$messageComplete = '下記のメールアドレスにメールを送信致しました。';
}
get_header();
?>
<main class="l-main has-bg--pc">
	<?php
	if (current_user_can('read')) :
	?>
		<div class="p-member-page-header">
			<div class="l-inner">
				<h1 class="p-member-page-header__title"><?php echo esc_html(get_tcd_membership_memberpage_title('account')); ?></h1>
			</div>
		</div>
	<?php
	endif;

	// 完了画面
	if (!empty($tcd_membership_vars['complete']) && !empty($tcd_membership_vars['message'])) :
		// パスワードの変更が完了した場合 => ログインページに遷移させる
		wp_safe_redirect(get_tcd_membership_memberpage_url('login') . '&reset_password=complete');
		exit();
	// フォーム表示
	else :
	?>
		<?php
		// 新しいパスワード入力フォーム表示
		if (!empty($tcd_membership_vars['reset_password']['token'])) :
		?>
			<div class="pt-sm-5 mt-sm-5">
				<div class="container pt-5">
					<form action="<?php echo esc_attr(get_tcd_membership_memberpage_url('reset_password')); ?>" method="POST">
						<div class="row">
							<div class="col-12">
								<h1 class="text-center mb-4 contents-title font-weight-bold">パスワードリセット</h1>
							</div>
							<div class="col-12">
								<label for="newPw" class="label-text">新しいパスワード</label>
							</div>
							<div class="col-12 pt-2 pb-2">
								<input class="form-control resetpw-email" type="password" name="new_pass1" id="newPw" placeholder="Musepass2" required>
							</div>
							<div class="col-12">
								<div class="inputPwMsg" id="inputPwMsg"></div>
							</div>
							<div class="col-12 mt-4">
								<label for="newPwConfirm" class="label-text">新しいパスワードを再入力</label>
							</div>
							<div class="col-12 pt-2 pb-2">
								<input class="form-control resetpw-email" type="password" name="new_pass2" id="newPwConfirm" placeholder="Musepass2" required>
							</div>
							<div class="col-12">
								<div class="inputPwConfirmMsg" id="inputPwConfirmMsg"></div>
							</div>

							<div class="col-12 text-center mt-4">
								<button type="submit" class="btn btn-primary text-white submit-btn" id="setpw-btn" disabled>新しいパスワード設定</button>
							</div>
						</div>
						<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-reset_password')); ?>">
						<input type="hidden" name="token" value="<?php echo esc_attr($tcd_membership_vars['reset_password']['token']); ?>">
					</form>
				</div>
			</div>

		<?php
		// メールアドレス入力フォーム表示
		else :
		?>
			<div class="pt-sm-5 mt-sm-5">
				<div class="container pt-5">
					<form method="POST" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('reset_password')); ?>">
						<div class="row">
							<div class="col-12">
								<h1 class="text-center mb-4 contents-title font-weight-bold">パスワード再発行</h1>
								<div class="emailSentMsg" id="emailSentMsg">
									<?php if ($messageComplete) { ?>
										<p>下記のメールアドレスに仮登録メールを送信いたしました。</p>
									<?php } ?>
								</div>

							</div>
							<div class="col-12">
								<label for="email" class="label-text">メールアドレス</label>
							</div>
							<div class="col-12 pt-2 pb-2">
								<input class="form-control resetpw-email" type="email" name="email" id="pwResetEmail" placeholder="aaaa@muse.co.jp" value="<?php echo esc_attr($email); ?>" required>
							</div>
							<div class="col-12">
								<div class="inputEmailMsg" id="inputEmailMsg"></div>
							</div>
							<div class="col-12">
								<p class="resetpw-notes" style="margin: 40px auto 0 auto;">入力されたメールアドレスにパスワード再発行のメールをお送りします。</p>
							</div>

							<div class="col-12 text-center pt-3">
								<button type="submit" class="btn btn-primary text-white submit-btn" id="resetpw-btn" disabled>パスワード再発行</button>
							</div>
						</div>
						<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-reset_password')); ?>">
					</form>
				</div>
			</div>
		<?php
		endif;
		?>

	<?php
	endif;
	?>
</main>
<?php
get_footer();
