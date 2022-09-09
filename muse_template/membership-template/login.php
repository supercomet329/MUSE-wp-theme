<?php
global $dp_options, $tcd_membership_vars;

// get_header();
get_template_part( 'template-parts/header_non_pc_menu' );
?>
    <div class="container pt-2">

<?php
tcd_membership_login_form();
?>
	</div>
<?php
// get_footer();
get_template_part( 'template-parts/footer_non_pc_menu' );
