<?php
global $dp_options, $post;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<?php /** TODO: 人気アーティストの表示 */ ?>
<ul class="horizontal-list py-0 my-2">
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
<?php /** TODO: 人気アーティストの表示 */ ?>

<main role="main" class="mb-2">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>
    <?php
    // TODO: 2022/05/09 画像投稿できるようになったら投稿を確認
    $list_photo = list_author_post($author->ID, 'photo');
    $list_slice_photo = array_chunk($list_photo, 3);
    $i = 0;

    foreach ($list_slice_photo as $array_slice_photo) {
    ?>
        <div class="content">
            <?php
            foreach ($array_slice_photo as $one_photo) {
                $profileImageData = get_user_meta($one_photo->post_author, 'profile_image', true);
                $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                if (!empty($profileImageData)) {
                    $profile_image = $profileImageData;
                }

            ?>
                <div class="content-item shadow-sm d-flex align-items-center justify-content-center px-1">
                    <a href="<?php echo esc_html( get_tcd_membership_memberpage_url( 'profile' ) ); ?>&user_id=<?php echo esc_html($one_photo->post_author); ?>"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle profile"></a>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_post')); ?>&post_id=<?php echo $one_photo->ID; ?>"><img class="image-list" src="<?php echo esc_html($one_photo->meta_value); ?>"></a>
                </div>
            <?php }
            /** endforeach */ ?>

        </div>
    <?php }
    /** endforeach */ ?>
</main>