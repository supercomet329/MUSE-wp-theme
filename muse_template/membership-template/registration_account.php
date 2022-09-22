<?php
global $dp_options, $tcd_membership_vars;

get_template_part( 'template-parts/header_non_pc_menu' );
tcd_membership_registration_account_form();
get_template_part( 'template-parts/footer_non_pc_menu' );

// get_header();
?>
<?php /**
<main class="l-main has-bg--pc">
	<div class="l-inner">
		<div class="p-member-page p-registration-account">
<?php
tcd_membership_registration_account_form();
?>
		</div>
	</div>
</main>
 */ ?>
<?php
// get_footer();
