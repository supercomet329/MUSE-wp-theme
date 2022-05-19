<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">「いいね」した投稿</div>
<div style="padding-top: 100px;">
    <?php foreach ($tcd_membership_vars['list_post'] as $array_post) { ?>
        <a href="<?php echo esc_attr( get_tcd_membership_memberpage_url( 'confirm_post' ) ); ?>&post_id=<?php echo esc_attr($array_post[0]->post_id); ?>">
            <div class="content">
                <?php foreach ($array_post as $onePost) { ?>
                    <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                        <img class="image-list" src="<?php echo $onePost->main_image; ?>">
                    </div>
                <?php } ?>
            </div>
        </a>
    <?php } ?>
</div>
<?php
get_footer();
