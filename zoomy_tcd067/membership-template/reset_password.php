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
	?>
		<section class="vh-100 bg-image">
			<div class="mask d-flex align-items-center h-100 gradient-custom-3">
				<div class="container">
					<div class="row d-flex justify-content-center align-items-center h-100">
						<div class="col-12 col-lg-9 col-xl-7">
							<div class="card" style="border-radius: 15px;">
								<div class="card-body shadow">
									<h5 class="text-center font-weight-bold my-3">パスワード再設定完了</h5>
									<h6 class="text-center my-4" style="color: grey;">
										新しいパスワードを設定いたしました。ログイン画面へ戻り、新しいパスワードでログインしてください。
									</h6>
									<div class="d-flex justify-content-center pt-4 pb-2">
										<button id="go_login" type="button" class="btn btn-primary text-white btn-block btn-lg gradient-custom-4 font-weight-bold f-size-4">ログイン画面へ</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<script>
			$('#go_login').on('click', function() {
				window.location.href = "<?php echo esc_html(get_tcd_membership_memberpage_title('login')); ?>";
			});
		</script>
	<?php
	// フォーム表示
	else :
	?>
		<form class="p-membership-form js-membership-form--normal" action="<?php echo esc_attr(get_tcd_membership_memberpage_url('reset_password')); ?>" method="post">
			<?php
			// 新しいパスワード入力フォーム表示
			if (!empty($tcd_membership_vars['reset_password']['token'])) :
			?>
				<section class="vh-100 bg-image">
					<div class="mask d-flex align-items-center h-100 gradient-custom-3">
						<div class="container">
							<div class="row d-flex justify-content-center align-items-center h-100">
								<div class="col-12 col-lg-9 col-xl-7">

									<div class="card" style="border-radius: 15px;">
										<div class="card-body shadow">
											<?php if (!empty($tcd_membership_vars['message'])) : ?>
												<div class="p-membership-form__message"><?php echo wpautop($tcd_membership_vars['message']); ?></div>
											<?php
											endif;
											if (!empty($tcd_membership_vars['error_message'])) :
											?>
												<div class="p-membership-form__error"><?php echo wpautop($tcd_membership_vars['error_message']); ?></div>
											<?php
											endif;
											?>
											<h5 class="text-center font-weight-bold my-3">安全性の高いパスワードを作成</h5>
											<h6 class="text-center my-4" style="color: grey;">
												パスワードは半角英数字を組み合わせて8文字以上にしてください。
											</h6>
											<form>
												<div class="row">
													<div class="col-12 pb-3">
														<input type="password" id="new_pass1" name="new_pass1" class="form-control form-control-lg" value="" minlength="8" placeholder="新しいパスワード" required>
													</div>
													<div class="col-12 pb-3">
														<input type="password" id="new_pass2" class="form-control form-control-lg" name="new_pass2" value="" minlength="8" placeholder="新しいパスワードを再入力" required>
													</div>
												</div>
												<div class="d-flex justify-content-center pt-4 pb-2">
													<button type="submit" class="btn btn-primary text-white btn-block btn-lg gradient-custom-4 font-weight-bold f-size-4">パスワードをリセット</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-reset_password')); ?>">
					<input type="hidden" name="token" value="<?php echo esc_attr($tcd_membership_vars['reset_password']['token']); ?>">
				</section>
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
		</form>
	<?php
	endif;
	?>
</main>
<?php
get_footer();
