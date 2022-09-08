<?php
global $dp_options, $tcd_membership_vars;

// get_header();
get_template_part( 'template-parts/header_non_pc_menu' );
?>
<main class="l-main has-bg--pc">
	<div class="l-inner">
		<div class="p-member-page p-login">
<?php
tcd_membership_login_form();
?>
		</div>
	</div>
</main>
<?php
// get_footer();
get_template_part( 'template-parts/footer_non_pc_menu' );
