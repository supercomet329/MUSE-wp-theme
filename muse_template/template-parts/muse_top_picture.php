<?php
global $dp_options, $post;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<?php if (count(partsRanking()) > 0) { ?>
    <ul class="horizontal-list">
        <li class="item ml-2 ranking-icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/ranking_01.png" class="ranking-icon" alt="ranking_icon"><br /></li>

        <?php
        foreach (partsRanking() as $rankingOne) {

            $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
            if (!is_null($rankingOne->profile_image)) {
                $profile_image = $rankingOne->profile_image;
            }
        ?>
            <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('profile')) ?>&user_id=<?php echo esc_attr($rankingOne->user_id); ?>">
                <li class="item">
                    <img src="<?php echo esc_url($profile_image); ?>" alt="profile" class="rounded-circle">
                </li>
            </a>
        <?php }
        /** endforeach */ ?>
        <a href="ranking.html">
            <li class="item"><img class="transform-x-reverse border border-dark rounded-circle" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow.png" alt="profile" class="rounded-circle"></li>
        </a>
    </ul>
<?php }
/** endif */ ?>

<main role="main" class="mb-2">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>
    <?php
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
                    <a href="<?php echo esc_html(get_tcd_membership_memberpage_url('profile')); ?>&user_id=<?php echo esc_html($one_photo->post_author); ?>"><img src="<?php echo $profile_image; ?>" alt="profile" class="rounded-circle profile"></a>
                    <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('post_comment')); ?>&post_id=<?php echo $one_photo->ID; ?>"><img class="image-list" src="<?php echo esc_html($one_photo->meta_value); ?>"></a>
                </div>
            <?php }
            /** endforeach */ ?>

        </div>
    <?php }
    /** endforeach */ ?>
</main>