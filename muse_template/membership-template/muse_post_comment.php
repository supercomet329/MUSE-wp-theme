<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css">
<div class="container pt-2 confirm-area">
    <div class="row mb-2">
        <div class="col-12">
            <a href="timeline.html">← 戻る</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 item-text mb-2">
            投稿画像（必須）
        </div>
        <div class="col-12 mb-4 confirm-image-area">
            <div class="my-2 slid-img swiper swipertum">
                <div class="swiper-wrapper d-flex align-items-center">
                    <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></a></div>
                    <div class="swiper-slide"><a href="post_img_comment.html"><img class="img-fluid mx-auto" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></a></div>
                </div>
            </div>
            <div class="swiper slid-list swiperlist">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" /></div>
                    <div class="swiper-slide"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_27669641_M.jpg" /></div>
                </div>
            </div>
        </div>
        <div class="logo-area">
            <img class="float-left" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/iine_on.png" alt="iine">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/social_tipping_on.png" alt="social_tipping_on">
        </div>
        <div class="col-12">
            <hr class="hr-line">
        </div>
        <div class="col-12 pt-2 item-text mb-2">
            メッセージ
        </div>
        <div class="col-12">
            <div class="row my-3">
                <div class="col-3 col-sm-2 col-lg-1 pr-0">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle" width="60" height="60">
                </div>
                <div class="col-8 col-sm-9 col-lg-10 bg-gray p-2 rounded">
                    <div class="row">
                        <div class="col-12 msg-detail">
                            <span class="mr-2 msg-name font-weight-bold">UserName</span>
                            <span class="msg-date">2022/04/11 16:30</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 msg">
                            <p class="mb-0">よろしくお願いします。よろしくお願いします。よろしくお願いします。よろしくお願いします。よろしくお願いします。よろしくお願いします。よろしくお願いします。よろしくお願いします。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-3 col-sm-2 col-lg-1 pr-0">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_64747350_M.jpg" class="rounded-circle" width="60" height="60">
                </div>
                <div class="col-8 col-sm-9 col-lg-10 bg-gray p-2 rounded">
                    <div class="row">
                        <div class="col-12 msg-detail">
                            <span class="mr-2 msg-name font-weight-bold">UserName</span>
                            <span class="msg-date">2022/04/11 16:30</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 msg">
                            <p class="mb-0">よろしくお願いします。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <form class="mx-1" action="POST">
                <textarea class="form-control" rows="6" placeholder="ここにメッセージを入力"></textarea>
                <div class="my-3 text-center">
                    <button type="submit" class="btn btn-primary text-white" id="msg-btn">メッセージ送信</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Swiper JS -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>
<?php
get_footer();
