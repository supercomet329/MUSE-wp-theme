<?php
global $dp_options, $tcd_membership_vars, $tcd_membership_post;

// プレビュー確認はsingle-photo.php
if (is_tcd_membership_preview_photo()) :
    get_template_part('single-photo');
    return;
endif;

get_header();
?>
<div class="container pt-2">
    <form id="js-membership-edit-photo" class="p-membership-form js-membership-form--normal" action="" enctype="multipart/form-data" method="post">
        <input type="file" name="file" id="file-input" accept="image/png, image/jpeg">
        <div class="card py-2" id="preview_container">
            <div id="img_preview" class="img-preview d-flex align-items-center">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/add_image360-250.png" style="margin-left: auto; margin-right: auto; display:block;">
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-12">
                <label for="title">タイトル</label>
            </div>
            <div class="col-12 pb-3">
                <?php echo esc_attr($tcd_membership_vars['postData']['post_title']); ?>
            </div>
            <div class="col-12">
                <label for="details">詳細</label>
            </div>
            <div class="col-12 pb-3">
               <?php echo esc_attr($tcd_membership_vars['postData']['post_content']); ?>
            </div>
            <!-- TODO: オークションどうする? -->
            <div class="col-12">
                販売形式
            </div>
            <div class="col-12 pb-3">
                通常販売
                <!-- オークション -->
            </div>
            <div class="col-12">
                <label for="selling_price">販売価格</label>
            </div>
            <div class="col-12 pb-3">
                1,000円
            </div>
            <div class="col-12">
                <label for="bin_price">即決価格</label>
            </div>
            <div class="col-12 pb-3">
            1,000円
            </div>
            <div class="col-12">
                オークション開始日時
            </div>
            <div class="col-12 pb-2">
                指定しない
                <!--
                    開始時間指定: 2022/05/24 00:00:00
                -->
            </div>
            <div class="col-12 pb-1">
                オークション終了日時: 2022/06/01 17:00
            </div>
            <div class="col-12 pb-1">
                オークション自動延長: あり
            </div>
        </div>
    </form>
</div>
<?php
get_footer();
