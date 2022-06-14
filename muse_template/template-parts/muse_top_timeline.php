<ul class="horizontal-list">
    <?php // 2022/05/23 TODO: 人気アーティストのルール by H.Okabe https://staeby.backlog.com/view/MUSE_NFT-100 
    ?>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40855053_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_45010284_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58642077_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/profile.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40855053_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_45010284_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_56091176_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
    <a href="profile.html">
        <li class="item"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58642077_M.jpg" alt="profile" class="rounded-circle"></li>
    </a>
</ul>

<?php
// 画像の一覧の取得
$list_photo = list_author_post($author->ID, 'photo');
foreach ($list_photo as $one_photo) {
    $user_info = get_userdata($one_photo->post_author);
    $profileImageData = get_user_meta($user_info->ID, 'profile_image', true);
    $dataClass = new DateTime($one_photo->post_modified);
?>
    <div class="col-12 pt-1">
        <ul class="tweet-area">
            <li class="d-flex align-items-start">
                <figure>
                    <?php
                    $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                    if (!empty($profileImageData)) {
                        $profile_image = $profileImageData;
                    }
                    ?>
                    <img src="<?php echo $profile_image; ?>" class="rounded-circle profile-icon">
                </figure>
                <div class="text-area">
                    <span><?php echo $user_info->display_name; ?></span><br>
                    <span class="post-time"><?php echo $dataClass->format('Y/m/d H:i'); ?></span>
                </div>
            </li>
        </ul>
    </div>

    <div class="timeline-image">
        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_post')); ?>&post_id=<?php echo $one_photo->post_id; ?>">
            <img src="<?php echo $one_photo->meta_value; ?>" alt="<?php echo $one_photo->post_title; ?>">
        </a>
    </div>

    <div class="logo-area">
        <?php
        $like_image = 'iine.png';
        if (is_liked($one_photo->post_id, false)) {
            $like_image = 'iine_on.png';
        }
        ?>
        <img class="js-toggle-like" data-post-id="<?php echo $one_photo->post_id; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/<?php echo $like_image; ?>" alt="iine">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on" style="height: 40px;width: 40px;">
    </div>
<?php }
/** endforeach */ ?>