<?php
global $dp_options, $tcd_membership_vars;

get_header();
?>
<div class="pt-sm-5 mt-sm-5">
    <div class="container pt-5">
        <form method="POST" enctype="multipart/form-data" action="<?php echo esc_url(get_tcd_membership_memberpage_url('post_image')); ?>">
            <div class="row">
                <div class="col-12">
                    <label for="saleType" class="label-text post-input-title">投稿画像（必須）</label>
                </div>
                <div class="col-12 post-file-input px-1">
                    <label class="post-file" id="post_file">
                        <img src="" class="cover-img d-none" id="cover_img">
                        <input type="file" name="postFile" id="postFile" accept="image/png, image/jpeg">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="post-file-img">
                    </label>
                </div>
            </div>
            <div class="col-12 mx-0 px-0 mt-3">
                <div class="selectPostFile" id="selectPostFile">
                    <?php if (isset($tcd_membership_vars['error']['postFile'])) { ?>
                        <p id="inputPostFileMsg" class="inputPostTitleMsg postErrMsg my-0"><?php echo $tcd_membership_vars['error']['postFile']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <!-- div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-2 px-1">
                                <label class="post-file-sub-img post-local-file">
                                    <input type="file" name="postFile2" id="postFile2">
                                </label>
                            </div>
                            <div class="col-2 px-1">
                                <label class="post-file-sub-img post-app-file">
                                    <input type="file" name="postFile3" id="postFile3">
                                </label>
                            </div>
                            <div class="col-2 px-1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_45010284_M.jpg" class="post-images">
                            </div>
                            <div class="col-2 px-1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58642077_M.jpg" class="post-images">
                            </div>
                            <div class="col-2 px-1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_58266021_M.jpg" class="post-images">
                            </div>
                            <div class="col-2 px-1">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_40272765_M.jpg" class="post-images">
                            </div>
                        </div>
                    </div>
                </div -->
            <div class="col-12 mx-0 px-0 mt-3">
                <div class="selectPostFile" id="selectPostFile">
                    <?php if (isset($tcd_membership_vars['error']['postTitle'])) { ?>
                        <p id="inputPostTitleMsg" class="inputPostTitleMsg postErrMsg my-0">タイトルを入力して下さい</p>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="saleType" class="label-text post-input-title mt-4">タイトル（必須）</label>
                </div>
                <div class="col-12">
                    <input class="form-control post-input" type="text" name="postTitle" id="postTitle" placeholder="タイトルを入力" value="<?php echo (isset($_REQUEST['postTitle'])) ? $_REQUEST['postTitle'] : ''; ?>">
                </div>
                <div class="col-12">
                    <div class="inputPostTitle" id="inputPostTitle"></div>
                </div>
                <div class="col-12">
                    <label for="saleType" class="label-text post-input-title mt-4">詳細（任意）</label>
                </div>
                <div class="col-12">
                    <textarea class="form-control post-detail" name="postDetail" id="postDetail" placeholder="詳細を入力"><?php echo (isset($_REQUEST['postDetail'])) ? $_REQUEST['postDetail'] : ''; ?></textarea>
                </div>
                <div class="col-12 mt-2">
                    <label for="saleType" class="label-text post-input-title mt-4">販売形式（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="sale" id="sale" <?php echo ($tcd_membership_vars['chk_sele_type'] === 'sale') ? 'checked' : ''; ?>>通常販売</label>
                    </div>
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="auction" id="auction" <?php echo ($tcd_membership_vars['chk_sele_type'] === 'auction') ? 'checked' : ''; ?>>オークション</label>
                    </div>
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="notForSale" id="notForSale" <?php echo ($tcd_membership_vars['chk_sele_type'] === 'notForSale') ? 'checked' : ''; ?>>販売しない</label>
                    </div>
                </div>

                <div class="col-12">
                    <label for="suitableAges" class="label-text post-input-title mt-4">対象（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="suitableAges" value="allAges" id="allAges" <?php echo ($tcd_membership_vars['chk_suitable_ages'] === 'allAges') ? 'checked' : ''; ?>>全年齢</label>
                    </div>
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="suitableAges" value="r18" id="restrictedAge" <?php echo ($tcd_membership_vars['chk_suitable_ages'] === 'r18') ? 'checked' : ''; ?>>R-18</label>
                    </div>
                </div>

                <!-- 販売形式フォーム-->
                <div class="saleSection saleTypeSection mb-4" <?php echo ($tcd_membership_vars['chk_sele_type'] !== 'sale') ? 'style="display: none;"' : ''; ?>>
                    <div class="col-12">
                        <label for="imagePrice" class="label-text post-input-title mt-4">販売価格（必須）</label>
                    </div>
                    <div class="col-11">
                        <input class="form-control post-input image-price-input" type="number" name="imagePrice" id="imagePrice" placeholder="金額を入力">
                        <div class="image-price-jpy">
                            円
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="inputImagePrice" id="inputImagePrice">
                            <?php if (isset($tcd_membership_vars['error']['imagePrice'])) { ?>
                                <p id="inputImagePriceMsg" class="inputImagePriceMsg postErrMsg my-0">販売価格を入力して下さい</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="commission-title">手数料差し引き残額</p>
                        <p class="commission-price">0円</p>
                    </div>
                    <div class="col-12">
                        <label for="binPrice" class="label-text post-input-title mt-4">即決価格（必須）</label>
                    </div>
                    <div class="col-11">
                        <input class="form-control post-input image-price-input" type="number" name="binPrice" id="binPrice" placeholder="金額を入力" <?php echo (isset($_REQUEST['binPrice'])) ? $_REQUEST['binPrice'] : ''; ?>>
                        <div class="image-price-jpy">
                            円
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="inputBinPrice" id="inputBinPrice">
                            <?php if (isset($tcd_membership_vars['error']['binPrice'])) { ?>
                                <p id="inputBinPriceMsg" class="inputBinPriceMsg postErrMsg my-0">即決価格を入力して下さい</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- オークション形式フォーム-->
                <div class="auctionSection saleTypeSection" <?php echo ($tcd_membership_vars['chk_sele_type'] !== 'auction') ? 'style="display: none;"' : 'style="display: block;"'; ?>>
                    <div class="col-12">
                        <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時（必須）</label>
                    </div>
                    <div class="col-12 row">
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="notSpecified" id="notSpecified" <?php echo ($tcd_membership_vars['auction_start_date'] === 'notSpecified') ? 'checked' : ''; ?>>指定しない</label>
                        </div>
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="specify" id="specify" <?php echo ($tcd_membership_vars['auction_start_date'] === 'specify') ? 'checked' : ''; ?>>開始時間指定</label>
                        </div>
                    </div>
                    <div id="auction_datetime" <?php echo ($tcd_membership_vars['auction_start_date'] === 'specify') ? '' : 'class="d-none"'; ?>>
                        <div class="col-12">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="yyyy" name="auctionDateY" id="auctionDateY" value="<?php echo (isset($_REQUEST['auctionDateY'])) ? $_REQUEST['auctionDateY'] : ''; ?>">
                                <p class="auction-date">年</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionDateM" id="auctionDateM" value="<?php echo (isset($_REQUEST['auctionDateM'])) ? $_REQUEST['auctionDateM'] : ''; ?>">
                                <p class="auction-date">月</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="dd" name="auctionDateD" id="auctionDateD" value="<?php echo (isset($_REQUEST['auctionDateD'])) ? $_REQUEST['auctionDateD'] : ''; ?>">
                                <p class="auction-date">日</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="hh" name="auctionDateH" id="auctionDateH" value="<?php echo (isset($_REQUEST['auctionDateH'])) ? $_REQUEST['auctionDateH'] : ''; ?>">
                                <p class="auction-date">時</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionDateMin" id="auctionDateMin" value="<?php echo (isset($_REQUEST['auctionDateMin'])) ? $_REQUEST['auctionDateMin'] : ''; ?>">
                                <p class="auction-date">分</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputAppDeadline" id="inputAppDeadline">
                                <?php if (isset($tcd_membership_vars['error']['appDeadlineMsg'])) { ?>
                                    <p id="inputAppDeadlineMsg" class="inputRequestErrMsg mt-1"><?php echo $tcd_membership_vars['error']['appDeadlineMsg']; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション終了日時</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="yyyy" name="auctionEndDateY" id="auctionEndDateY" value="<?php echo (isset($_REQUEST['auctionEndDateY'])) ? $_REQUEST['auctionEndDateY'] : ''; ?>">
                                <p class="auction-date">年</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionEndDateM" id="auctionEndDateM" value="<?php echo (isset($_REQUEST['auctionEndDateM'])) ? $_REQUEST['auctionEndDateM'] : ''; ?>">
                                <p class="auction-date">月</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="dd" name="auctionEndDateD" id="auctionEndDateD" value="<?php echo (isset($_REQUEST['auctionEndDateD'])) ? $_REQUEST['auctionEndDateD'] : ''; ?>">
                                <p class="auction-date">日</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="hh" name="auctionEndDateH" id="auctionEndDateH" value="<?php echo (isset($_REQUEST['auctionEndDateH'])) ? $_REQUEST['auctionEndDateH'] : ''; ?>">
                                <p class="auction-date">時</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionEndDateMin" id="auctionEndDateMin" value="<?php echo (isset($_REQUEST['auctionEndDateMin'])) ? $_REQUEST['auctionEndDateMin'] : ''; ?>">
                                <p class="auction-date">分</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputAuctionEnd" id="inputAuctionEnd"></div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション自動延長</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="extendAuction" value="enableAutoExtend" id="enableAutoExtend" <?php echo ($tcd_membership_vars['extend_auction'] === 'enableAutoExtend') ? 'checked' : ''; ?>>あり</label>
                            </div>
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="extendAuction" value="disableAutoExtend" id="disableAutoExtend" <?php echo ($tcd_membership_vars['extend_auction'] === 'disableAutoExtend') ? 'checked' : ''; ?>>なし</label>
                            </div>
                        </div>
                        <p class="auction-notes">※終了5分前に入札されると、5分延長されます。</p>
                    </div>
                </div>

                <!-- 販売しない形式フォーム-->
                <div class="col-12 notForSaleSection saleTypeSection" <?php echo ($tcd_membership_vars['chk_sele_type'] !== 'notForSale') ? 'style="display: none;"' : ''; ?>>
                </div>

                <div class="termsSection saleTypeSection">
                    <div class="col-12 text-center">
                        <input class="form-check-input" type="checkbox" value="1" id="postTermsCheck" name="postTermsCheck">
                        <label class="form-check-label post-terms-check pb-2" for="postTermsCheck">
                            <p class="agree">利用規約に同意する</p>
                        </label>
                    </div>
                </div>

                <div class="col-12 text-center mt-3 mb-5">
                    <button type="submit" class="btn btn-primary text-white submit-btn" id="postBtn" disabled>画像投稿確認</button>
                </div>

            </div>
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-post_image')); ?>">
        </form>
    </div>
</div>
<?php
get_footer();
