<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>

<div class="container mt-3 request-list">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="text-center font-weight-bold title mt-4 mb-2">
        作品依頼検索
    </div>
    <div class="mb-2">
        <form class="search-post mb-2" method="POST" action="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>">
            <input class="search-box px-2 pb-0" id="search_box" value="<?php echo $tcd_membership_vars['search_txt']; ?>" name="search_txt" type="text" placeholder="検索" />
            <button class="search-button btn rounded-pill btn-sm font-weight-bold my-auto ml-2" type="submit">検索</button>
            <img class="modal-open float-right" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_option.png" alt="search_option" class="float-right search-option">
        </form>
        <div class="tab d-flex " id="sort_tab">
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>&sort=id_new" class="rounded-pill font-weight-bold <?php echo ($tcd_membership_vars['sort'] === 'id_new') ? 'selected-tab' : 'not-selected-tab'; ?> small text-center pt-2" id="desc">新しい順</a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>&sort=id_old" class="rounded-pill font-weight-bold <?php echo ($tcd_membership_vars['sort'] === 'id_old') ? 'selected-tab' : 'not-selected-tab'; ?> small text-center pt-2" id="asc">古い順</a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>&sort=budget_down" class="rounded-pill font-weight-bold <?php echo ($tcd_membership_vars['sort'] === 'budget_down') ? 'selected-tab' : 'not-selected-tab'; ?> small text-center pt-2" id="low">予算低い順</a>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>&sort=budget_up" class="rounded-pill font-weight-bold <?php echo ($tcd_membership_vars['sort'] === 'budget_up') ? 'selected-tab' : 'not-selected-tab'; ?> small text-center pt-2" id="high">予算高い順</a>
        </div>
    </div>
    <?php
    $i = 0;
    foreach ($tcd_membership_vars['list_order'] as $one_order) {

        $profileImageData = get_user_meta($one_order->post_author, 'profile_image', true);
        $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($profileImageData)) {
            $profile_image = $profileImageData;
        }
        $requestData['profile_image'] = $profile_image;

        $dateClass = new DateTime($one_order->appDeadlineDate);
        $appDeadlineDate = $dateClass->format('Y/m/d');
        if ($i <= 0) {
            echo '<div class="row">';
        } else {
            echo '<div class="row request-boundary">';
        }
    ?>
        <div class="col-12 request-area mt-3">
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_request')); ?>&request_id=<?php echo $one_order->post_id; ?>">
                <div class="request-title font-weight-bold mt-3 mb-2">
                    <?php echo esc_attr($one_order->post_title); ?>
                </div>
            </a>
            <div class="row">
                <div class="col-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="<?php echo esc_url($profile_image); ?>" alt="profile" class="rounded-circle request-user-icon">
                        </div>
                        <div class="col-12 text-center requester mt-1">
                            <p class="font-weight-bold"><?php echo esc_attr($one_order->display_name); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-8 pl-1">
                    <div class="row">
                        <div class="col-12 h-70px request-detail">
                            <?php echo nl2br($one_order->post_content); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 request-budget px-0 mt-1 ml-3 mr-1">
                            <p class="font-weight-bold mb-0"><?php echo esc_attr($one_order->budget); ?>円</p>
                        </div>
                        <div class="col-3 subtext request-deadline px-0 mx-1 mt-1">
                            <p class="font-weight-bold mb-0"><?php echo esc_attr($appDeadlineDate); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ((int)$one_order->post_author !== get_current_user_id()) { ?>
                            <div class="col-2 px-0 mt-1 ml-3 mr-1 request-keep">
                                <div class="border rounded-pill text-center mb-1 px-1 keep_off">
                                    <?php if (is_keep($one_order->post_id)) { ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/keep_on.png" alt="keep-off" class="js-toggle-keep keep-off" data-post-id="<?php echo $one_order->post_id; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/keep_off.png" alt="keep-off" class="js-toggle-keep keep-off" data-post-id="<?php echo $one_order->post_id; ?>">
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
        $i++;
    }
    /** endforeach */
?>

<!-- 検索モーダル -->
<form class="search-post mb-2" method="POST" action="<?php echo esc_url(get_tcd_membership_memberpage_url('order_search')); ?>">
    <div class="modal-container">
        <div class="modal-body">
            <div class="modal-content text-left p-3">
                <p class="item-text mx-auto">検索オプション</p>
                <form class="search-post" method="POST">
                    <div class="mb-2 item-text">
                        予算上限
                    </div>
                    <div class="select-wrap">
                        <select name="sel_up_budget" class="select-box mb-3">
                            <option value="">指定なし</option>
                            <option value="10000" <?php echo ((int)$tcd_membership_vars['sel_up_budget'] === 10000) ? 'selected' : ''; ?>>10000円</option>
                            <option value="50000" <?php echo ((int)$tcd_membership_vars['sel_up_budget'] === 50000) ? 'selected' : ''; ?>>50000円</option>
                            <option value="100000" <?php echo ((int)$tcd_membership_vars['sel_up_budget'] === 100000) ? 'selected' : ''; ?>>100000円</option>
                        </select>
                    </div>
                    <div class="mb-2 item-text">
                        予算下限
                    </div>
                    <div class="select-wrap">
                        <select name="sel_down_budget" class="select-box mb-3">
                            <option value="">指定なし</option>
                            <option value="10000" <?php echo ((int)$tcd_membership_vars['sel_down_budget'] === 10000) ? 'selected' : ''; ?>>10000円</option>
                            <option value="50000" <?php echo ((int)$tcd_membership_vars['sel_down_budget'] === 50000) ? 'selected' : ''; ?>>50000円</option>
                            <option value="100000" <?php echo ((int)$tcd_membership_vars['sel_down_budget'] === 100000) ? 'selected' : ''; ?>>100000円</option>
                        </select>
                    </div>
                    <div class="mb-2 item-text">
                        期日
                    </div>
                    <div class="select-wrap">
                        <select name="sel_limit" class="select-box mb-3">
                            <option value="">指定なし</option>
                            <option value="1week" <?php echo ($tcd_membership_vars['sel_limit'] === '1week') ? 'selected' : ''; ?>>1週間以内</option>
                            <option value="1month" <?php echo ($tcd_membership_vars['sel_limit'] === '1month') ? 'selected' : ''; ?>>1か月以内</option>
                            <option value="1year" <?php echo ($tcd_membership_vars['sel_limit'] === '1year') ? 'selected' : ''; ?>>1年以内</option>
                        </select>
                    </div>
                    <?php /** TODO: 依頼にR-18指定はないので検索対象から外しました。 */ ?>
                    <!-- div class="mb-2 item-text">
                        対象
                    </div>
                    <div class="select-wrap">
                        <select class="select-box mb-3">
                            <option value="">全年齢</option>
                            <option value="">R-18</option>
                        </select>
                    </div -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary search-btn btn-sm btn-lg text-white">検索</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>
<?php
get_footer();
