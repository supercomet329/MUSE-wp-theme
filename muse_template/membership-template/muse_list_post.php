<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<div class="container mt-4">
    <form class="search-post mb-2" method="POST" action="<?php echo esc_url(get_tcd_membership_memberpage_url('list_post')); ?>">
        <input class="search-box px-2 pb-0" id="front_search_box" name="txt_search" type="text" placeholder="検索" value="<?php echo $tcd_membership_vars['text_search']; ?>" />
        <input class="search-button btn rounded-pill btn-sm font-weight-bold my-auto ml-2" name="submit" type="submit" value="検索" />
        <img id="modal-open" class="modal-open float-right" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_option.png" alt="search_option" class="float-right search-option">
        <!-- モーダル本体 -->
        <div class="modal-container">
            <div class="modal-body">
                <!-- モーダル内のコンテンツ -->
                <div class="modal-content text-left p-3">
                    <p class="item-text mx-auto">検索オプション</p>
                    <form class="search-post" method="POST" action="<?php echo esc_url(get_tcd_membership_memberpage_url('list_post')); ?>">
                        <div class="mb-2 item-text">
                            キーワード
                        </div>
                        <div class="mb-4">
                            <input class="search-box px-2 pb-0" id="modal_search_box" name="txt_search" type="text" placeholder="検索" value="<?php echo $tcd_membership_vars['text_search']; ?>" />
                        </div>

                        <?php if ($tcd_membership_vars['view_r18']) { ?>

                            <div class="mb-2 item-text">
                                対象
                            </div>
                            <div class="select-wrap">
                                <select name="sel_r18" class="select-box">
                                    <option value="normal" <?php if (!$tcd_membership_vars['sel_r18']) {
                                                                echo "selected";
                                                            } ?>>全年齢</option>

                                    <option value="r-18" <?php if ($tcd_membership_vars['sel_r18']) {
                                                                echo "selected";
                                                            } ?>>R-18</option>
                                </select>
                            </div>
                        <?php }
                        /** endif */ ?>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary search-btn btn-sm btn-lg text-white">検索</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
    <div class="tab">
        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_post')); ?>&sort=desc" type="button" class="btn rounded-pill btn-sm font-weight-bold <?php if (!$tcd_membership_vars['orderDescButton']) { ?> " not-selected-tab"; <?php } else echo "selected-tab"; ?> desc" id="desc">新しい順</a>
        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('list_post')); ?>&sort=asc" type="button" class="btn rounded-pill btn-sm font-weight-bold <?php if (!$tcd_membership_vars['orderAscButton']) { ?>  " ml-4 not-selected-tab"; <?php } else echo "selected-tab"; ?> asc" id="asc">古い順</a>
    </div>
</div>
<div>
    <?php foreach ($tcd_membership_vars['listImage'] as $arrayImage) { ?>

        <div class="content mt-4">
            <?php foreach ($arrayImage as $oneImage) {
                $mainImage        = get_post_meta($oneImage->ID, 'main_image', true);
                $profileImageData = get_user_meta($oneImage->post_author, 'profile_image', true);
                $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                if (!empty($profileImageData)) {
                    $profile_image = $profileImageData;
                }
            ?>
                <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_post')); ?>&post_id=<?php echo $oneImage->ID; ?>">
                        <img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle profile">
                        <img class="image-list" src="<?php echo $mainImage; ?>">
                    </a>
                </div>
            <?php }
            /** endforeach */ ?>
        </div>
    <?php }
    /** endforeach */ ?>
</div>
<?php
get_footer();
