<?php
global $dp_options, $tcd_membership_vars;
$tcd_membership_vars['list_like'];
get_header();
?>
<div class="text-center font-weight-bold title">
    通知一覧
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="list-area">
                <?php foreach ($tcd_membership_vars['arrayNotice'] as $key => $arrayNotice) { ?>
                    <?php foreach ($arrayNotice as $type => $value) { ?>
                        <?php if ($type === 'like') { ?>
                            <?php
                            foreach ($value as $valueOne) {
                                $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                                $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                                if (!empty($profileImageData)) {
                                    $profile_image = $profileImageData;
                                }
                                $user = get_userdata($valueOne['user_id']);
                                $post = get_post($valueOne['post_id']);
                            ?>

                                <li class="pt-2">
                                    <img src="<?php echo $profile_image; ?>" class="rounded-circle">
                                    <div class="font-weight-bold">
                                        <?php echo $user->display_name; ?>さんが「いいね」しました。
                                    </div>
                                    <div>
                                        <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('confirm_post')); ?>&post_id=<?php echo $post->ID; ?>">
                                            <?php echo $post->post_title; ?>
                                        </a>
                                    </div>
                                </li>
                            <?php }
                            /** endforeach */ ?>

                        <?php } elseif ($type === 'follow') { ?>

                            <?php
                            $images = [];
                            $names  = [];
                            $others = '';
                            if (count($value) >= 3) {
                                $others = '他';
                            }

                            foreach ($value as $valueOne) {

                                if (count($images) >= 2) {
                                    break;
                                }

                                $profileImageData = get_user_meta($valueOne['user_id'], 'profile_image', true);
                                $profile_image = get_template_directory_uri() . '/assets/img/icon/non_profile_image.png';
                                if (!empty($profileImageData)) {
                                    $profile_image = $profileImageData;
                                }
                                $images[] = $profile_image;

                                $user = get_userdata($valueOne['user_id']);
                                $names[]  = $user->display_name . 'さん';
                            }
                            /** endif */ ?>
                            <li class="pt-2">
                                <?php foreach ($images as $imageOne) { ?>
                                    <img src="<?php echo $imageOne; ?>" class="rounded-circle">
                                <?php } ?>

                                <div class="font-weight-bold">
                                    <?php echo implode('と', $names) . $others; ?>にフォローされました。
                                </div>
                            </li>
                        <?php }
                        /** endif */ 
                        /** TODO 受注の情報を取得*/ 
                    ?>

                    <?php }
                    /** endforeach */ ?>

                <?php }
                /** endforeach */ ?>
            </ul>
        </div>
    </div>
</div>
<?php
get_footer();
