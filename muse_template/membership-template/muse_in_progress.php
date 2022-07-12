<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="container pt-2 request-list">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="text-center font-weight-bold title mb-3">
        進行中依頼一覧
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-8 tab-area text-center pt-1 pb-1 ml-1 mr-2">
            <ul class="nav nav-pills nav-fill custom-nav">
                <li class="nav-item each-tab mx-2">
                    <a class="nav-link btn text-white not-selected-tab" href="<?php echo esc_attr(get_tcd_membership_memberpage_url('list_order')); ?>">
                        <div class="mx-auto">募集リクエスト</div>
                    </a>
                </li>
                <li class="nav-item each-tab mx-2">
                    <a class="nav-link btn text-white not-selected-tab" href="<?php echo esc_attr(get_tcd_membership_memberpage_url('list_received')); ?>">
                        <div class="mx-auto">リクエスト</div>
                    </a>
                </li>
                <li class="nav-item each-tab mx-2">
                    <a class="nav-link active btn text-white selected-tab" href="<?php echo esc_url(get_tcd_membership_memberpage_url('in_progress')); ?>">
                        <div class="mx-auto">進行中</div>
                    </a>
                </li>
            </ul>
        </div>
        <span class="ml-auto mr-auto">
            <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('order_search')); ?>"><img class="mr-2 search" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_blue.png" alt="search"></a>
            <img class="modal-open search-option" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/search_option.png" alt="search_option">
        </span>
    </div>

    <?php
    $loop = 0;
    foreach ($tcd_membership_vars['listOrder'] as $one_order) {

        $class = 'request-boundary';
        if ($loop === 0) {
            $class = '';
        }

        $user_id = $one_order->post_author;
        $profileImageData = get_user_meta($user_id, 'profile_image', true);
        $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
        if (!empty($profileImageData)) {
            $profile_image = $profileImageData;
        }

        $dateTimeClass = new DateTime($one_order->appDeadlineDate);
    ?>
        <div class="row <?php echo $class; ?>">
            <div class="col-12 request-area mt-3">
                <a href="<?php echo esc_attr(get_tcd_membership_memberpage_url('modify_request')); ?>&request_id=<?php echo $one_order->post_id; ?>">
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
                                <p class="font-weight-bold mb-0"><?php echo $dateTimeClass->format('Y/m/d'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $loop++;
    }
    ?>


    <!-- 検索モーダル -->
    <form class="search-post mb-2"  method="POST" action="<?php echo esc_url(get_tcd_membership_memberpage_url('in_progress')); ?>">
        <div class="modal-container">
            <div class="modal-body">
                <div class="modal-content text-left p-3">
                    <p class="item-text mx-auto">検索オプション</p>
                    <form class="search-post">
                        <div class="mb-2 item-text">
                            予算上限
                        </div>
                        <div class="select-wrap">
                            <select name="up_budget" class="select-box mb-3">
                                <option value="">指定なし</option>
                                <option value="10000" <?php echo (isset($tcd_membership_vars['post_data']['up_budget']) && (int)$tcd_membership_vars['post_data']['up_budget'] === 10000) ? 'selected' : ''; ?>>10000円</option>
                                <option value="50000" <?php echo (isset($tcd_membership_vars['post_data']['up_budget']) && (int)$tcd_membership_vars['post_data']['up_budget'] === 50000) ? 'selected' : ''; ?>>50000円</option>
                                <option value="100000" <?php echo (isset($tcd_membership_vars['post_data']['up_budget']) && (int)$tcd_membership_vars['post_data']['up_budget'] === 100000) ? 'selected' : ''; ?>>100000円</option>
                            </select>
                        </div>
                        <div class="mb-2 item-text">
                            予算下限
                        </div>
                        <div class="select-wrap">
                            <select name="down_budget" class="select-box mb-3">
                                <option value="">指定なし</option>
                                <option value="10000" <?php echo (isset($tcd_membership_vars['post_data']['down_budget']) && (int)$tcd_membership_vars['post_data']['down_budget'] === 10000) ? 'selected' : ''; ?>>10000円</option>
                                <option value="50000" <?php echo (isset($tcd_membership_vars['post_data']['down_budget']) && (int)$tcd_membership_vars['post_data']['down_budget'] === 50000) ? 'selected' : ''; ?>>50000円</option>
                                <option value="100000" <?php echo (isset($tcd_membership_vars['post_data']['down_budget']) && (int)$tcd_membership_vars['post_data']['down_budget'] === 100000) ? 'selected' : ''; ?>>100000円</option>
                            </select>
                        </div>
                        <div class="mb-2 item-text">
                            期日
                        </div>
                        <div class="select-wrap">
                            <select name="deadline" class="select-box mb-3">
                                <option value="">指定なし</option>
                                <!-- option value="1hour" <?php echo (isset($tcd_membership_vars['post_data']['deadline']) && $tcd_membership_vars['post_data']['deadline'] === '1hour') ? 'selected' : ''; ?>>1時間以内</option>
                                <option value="24hour" <?php echo (isset($tcd_membership_vars['post_data']['deadline']) && $tcd_membership_vars['post_data']['deadline'] === '24hour') ? 'selected' : ''; ?>>24時間以内</option -->
                                <option value="1week" <?php echo (isset($tcd_membership_vars['post_data']['deadline']) && $tcd_membership_vars['post_data']['deadline'] === '1week') ? 'selected' : ''; ?>>1週間以内</option>
                                <option value="1month" <?php echo (isset($tcd_membership_vars['post_data']['deadline']) && $tcd_membership_vars['post_data']['deadline'] === '1month') ? 'selected' : ''; ?>>1か月以内</option>
                                <option value="1year" <?php echo (isset($tcd_membership_vars['post_data']['deadline']) && $tcd_membership_vars['post_data']['deadline'] === '1year') ? 'selected' : ''; ?>>1年以内</option>
                            </select>
                        </div>
                        <!-- div class="mb-2 item-text">
                            対象
                            </div>
                            <div class="select-wrap">
                            <select class="select-box mb-3">
                                <option value="">全年齢</option>
                                <option value="">R-18</option>
                            </select>
                            </div-->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary search-btn btn-sm btn-lg text-white">検索</button>
                        </div>
                        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd_membership_action_order_search')); ?>">
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
get_footer();
