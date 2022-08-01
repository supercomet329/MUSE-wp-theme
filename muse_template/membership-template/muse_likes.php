<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<div class="text-center bg-white font-weight-bold pt-5 mb-3 pb-3 border-bottom position-fixed" style="width: 100%; z-index: 100;">「いいね」した投稿</div>
<div style="padding-top: 100px;">
    <?php foreach ($tcd_membership_vars['list_like'] as $list_like) { ?>
        <div class="content">
            <?php foreach ($list_like as $one_like) { ?>
                <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                    <img class="image-list" src="<?php echo $one_like->meta_value; ?>">
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php
get_footer();
