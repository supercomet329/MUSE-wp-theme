<?php
// 画像投稿ページ
global $dp_options, $tcd_membership_vars;

get_header();
?>
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <label for="saleType" class="label-text post-input-title">投稿画像（必須）</label>
            </div>
            <div class="col-12 post-file-input px-1">
                <label class="post-file" id="post_file">
                    <img src="" class="cover-img d-none" id="cover_img1" class="mx-auto">
                    <input type="file" name="postFile" id="postFile" accept="image/png, image/jpeg">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="post-file-img">
                </label>
            </div>
            <div class="row col-12 mx-auto">
                <div class="col-4 post-file-input px-1">
                    <label class="post-file" id="image_file2">
                        <img src="" class="sub-cover-img d-none" id="cover_img2" class="mx-auto">
                        <input type="file" name="postFile2" id="postFile_2" accept="image/png, image/jpeg">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="post-file-img">
                    </label>
                </div>
                <div class="col-4 post-file-input px-1">
                    <label class="post-file" id="image_file3">
                        <img src="" class="sub-cover-img d-none" id="cover_img3" class="mx-auto">
                        <input type="file" name="postFile3" id="postFile_3" accept="image/png, image/jpeg">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="post-file-img">
                    </label>
                </div>
                <div class="col-4 post-file-input px-1">
                    <label class="post-file" id="image_file4">
                        <img src="" class="sub-cover-img d-none" id="cover_img4" class="mx-auto">
                        <input type="file" name="postFile4" id="postFile_4" accept="image/png, image/jpeg">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/camera_BGblue.png" class="post-file-img">
                    </label>
                </div>
            </div>
        </div>
        <!-- <div class="row">
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
            </div> -->
        <div class="col-12 mx-0 px-0 mt-3">
            <div class="selectPostFile" id="selectPostFile"></div>
        </div>

        <div class="row">
            <div class="col-12">
                <label for="saleType" class="label-text post-input-title mt-4">タイトル（必須）</label>
            </div>
            <div class="col-12">
                <input class="form-control post-input" type="text" name="postTitle" id="postTitle" placeholder="タイトルを入力">
            </div>
            <div class="col-12">
                <div class="inputPostTitle" id="inputPostTitle"></div>
            </div>
            <div class="col-12">
                <label for="saleType" class="label-text post-input-title mt-4">詳細（任意）</label>
            </div>
            <div class="col-12">
                <textarea class="form-control post-detail" name="postDetail" id="postDetail" placeholder="詳細を入力"></textarea>
            </div>
            <div class="col-12 mt-2">
                <label for="saleType" class="label-text post-input-title mt-4">販売形式（必須）</label>
            </div>
            <div class="col-12 row">
                <div class="col-5 post-radio ml-2">
                    <label><input type="radio" name="saleType" value="sale" id="sale">NFT販売</label>
                </div>
                <!-- <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="auction" id="auction">オークション</label>
                    </div> -->
                <div class="col-5 post-radio ml-2">
                    <label><input type="radio" name="saleType" value="notForSale" id="notForSale" checked>販売しない</label>
                </div>
            </div>
            <div class="col-12">
                <label for="suitableAges" class="label-text post-input-title mt-4">対象（必須）</label>
            </div>
            <div class="col-12 row">
                <div class="col-5 post-radio ml-2">
                    <label><input type="radio" name="suitableAges" value="allAges" id="allAges" checked>全年齢</label>
                </div>
                <div class="col-5 post-radio ml-2">
                    <label><input type="radio" name="suitableAges" value="r18" id="restrictedAge">R-18</label>
                </div>
            </div>

            <!-- 販売形式フォーム-->
            <div class="saleSection saleTypeSection mb-4">
                <div class="col-12 mt-2">
                    <label for="selectAuction" class="label-text post-input-title mt-4">オークション開催（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="selectAuction" value="Auction" id="auction" checked>あり</label>
                    </div>
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="selectAuction" value="notAuction" id="notAuction">なし</label>
                    </div>
                </div>
                <!-- オークションあり形式フォーム -->
                <div class="holdauctionSection selectAuctionsection">
                    <div class="col-12">
                        <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時（必須）</label>
                    </div>
                    <div class="col-12 row">
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="notSpecified" id="notSpecified" checked>指定しない</label>
                        </div>
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="specify" id="specify">開始時間指定</label>
                        </div>
                    </div>
                    <div id="auction_datetime" class="d-none">
                        <div class="col-12">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時</label>
                        </div>
                        <div class="col-12 row mt-1">
                            <div class="col-4">
                                <select class="auction-input" placeholder="yyyy" name="auctionDateY" id="auctionDateY">
                                </select>
                                <p class="auction-date">年</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionDateY']; ?>" id="setAuctionDateY" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="mm" name="auctionDateM" id="auctionDateM">
                                </select>
                                <p class="auction-date">月</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionDateM']; ?>" id="setAuctionDateM" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="dd" name="auctionDateD" id="auctionDateD">
                                </select>

                                <p class="auction-date">日</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionDateD']; ?>" id="setAuctionDateD" />
                            </div>

                        </div>
                        <div class="col-12 row mt-1">
                            <div class="col-4">
                                <select class="auction-input" placeholder="dd" name="auctionDateD" id="auctionDateH">
                                </select>
                                <p class="auction-date">時</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionDateH']; ?>" id="setAuctionDateH" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="mm" name="auctionDateMin" id="auctionDateMin">
                                </select>
                                <p class="auction-date">分</p>

                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionDateMin']; ?>" id="setAuctionDateMin" />

                            </div>
                            <div class="col-4">

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputAppDeadline" id="inputAppDeadline"></div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション終了日時</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-4">
                                <select class="auction-input" placeholder="yyyy" name="auctionEndDateY" id="auctionEndDateY">
                                </select>
                                <p class="auction-date">年</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionEndDateY']; ?>" id="setAuctionEndDateY" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="mm" name="auctionEndDateM" id="auctionEndDateM">
                                </select>
                                <p class="auction-date">月</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionEndDateM']; ?>" id="setAuctionEndDateM" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="dd" name="auctionEndDateD" id="auctionEndDateD">
                                </select>
                                <p class="auction-date">日</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionEndDateD']; ?>" id="setAuctionEndDateD" />
                            </div>
                        </div>
                        <div class="col-12 row mt-1">
                            <div class="col-4">
                                <select class="auction-input" placeholder="dd" name="auctionDateD" id="auctionEndDateH">
                                </select>
                                <p class="auction-date">時</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionEndDateH']; ?>" id="setAuctionEndDateH" />
                            </div>
                            <div class="col-4">
                                <select class="auction-input" placeholder="mm" name="auctionEndDateMin" id="auctionEndDateMin">
                                </select>
                                <p class="auction-date">分</p>
                                <input type="hidden" value="<?php echo $tcd_membership_vars['setDataParams']['setAuctionEndDateMin']; ?>" id="setAuctionEndDateMin" />
                            </div>
                            <div class="col-4">
                            </div>
                            <div class="col-12">
                                <div class="inputAuctionEnd" id="inputAuctionEnd"></div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション自動延長</label>
                            </div>
                            <div class="col-12 row">
                                <div class="col-5 post-radio ml-2">
                                    <label><input type="radio" name="extendAuction" value="enableAutoExtend" id="enableAutoExtend" checked>あり</label>
                                </div>
                                <div class="col-5 post-radio ml-2">
                                    <label><input type="radio" name="extendAuction" value="disableAutoExtend" id="disableAutoExtend">なし</label>
                                </div>
                            </div>
                            <p class="auction-notes">※終了5分前に入札されると、5分延長されます。</p>
                        </div>
                    </div>
                    <!-- オークションなし形式フォーム -->
                    <div class="notholdauctionSection selectAuctionsection">
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
                            <div class="inputImagePrice" id="inputImagePrice"></div>
                        </div>
                        <div class="col-12">
                            <p class="commission-title">手数料差し引き残額</p>
                            <p class="commission-price">0円</p>
                        </div>
                        <div class="col-12">
                            <label for="binPrice" class="label-text post-input-title mt-4">即決価格（必須）</label>
                        </div>
                        <div class="col-11">
                            <input class="form-control post-input image-price-input" type="number" name="binPrice" id="binPrice" placeholder="金額を入力">
                            <div class="image-price-jpy">
                                円
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputBinPrice" id="inputBinPrice"></div>
                        </div>
                    </div>
                </div>

                <!-- オークション形式フォーム-->
                <!-- <div class="auctionSection saleTypeSection">
                    <div class="col-12">
                        <label for="auctionStartDate"
                            class="label-text post-input-title mt-4">オークション開始日時（必須）</label>
                    </div>
                    <div class="col-12 row">
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="notSpecified"
                                    id="notSpecified" checked>指定しない</label>
                        </div>
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="auctionStartDate" value="specify"
                                    id="specify">開始時間指定</label>
                        </div>
                    </div>
                    <div id="auction_datetime" class="d-none">
                        <div class="col-12">
                            <label for="auctionStartDate"
                                class="label-text post-input-title mt-4">オークション開始日時</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="yyyy" name="auctionDateY"
                                    id="auctionDateY">
                                <p class="auction-date">年</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionDateM"
                                    id="auctionDateM">
                                <p class="auction-date">月</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="dd" name="auctionDateD"
                                    id="auctionDateD">
                                <p class="auction-date">日</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="hh" name="auctionDateH"
                                    id="auctionDateH">
                                <p class="auction-date">時</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionDateMin"
                                    id="auctionDateMin">
                                <p class="auction-date">分</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputAppDeadline" id="inputAppDeadline"></div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="auctionStartDate"
                                class="label-text post-input-title mt-4">オークション終了日時</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="yyyy" name="auctionEndDateY"
                                    id="auctionEndDateY">
                                <p class="auction-date">年</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionEndDateM"
                                    id="auctionEndDateM">
                                <p class="auction-date">月</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="dd" name="auctionEndDateD"
                                    id="auctionEndDateD">
                                <p class="auction-date">日</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="hh" name="auctionEndDateH"
                                    id="auctionEndDateH">
                                <p class="auction-date">時</p>
                            </div>
                            <div class="col-2">
                                <input type="number" class="auction-input" placeholder="mm" name="auctionEndDateMin"
                                    id="auctionEndDateMin">
                                <p class="auction-date">分</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="inputAuctionEnd" id="inputAuctionEnd"></div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="auctionStartDate"
                                class="label-text post-input-title mt-4">オークション自動延長</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="extendAuction" value="enableAutoExtend"
                                        id="enableAutoExtend" checked>あり</label>
                            </div>
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="extendAuction" value="disableAutoExtend"
                                        id="disableAutoExtend">なし</label>
                            </div>
                        </div>
                        <p class="auction-notes">※終了5分前に入札されると、5分延長されます。</p>
                    </div>
                </div> -->
                <!-- 販売しない形式フォーム-->
                <div class="col-12 notForSaleSection saleTypeSection">
                </div>

                <div class="termsSection saleTypeSection">
                    <div class="col-12 text-center">
                        <input class="form-check-input" type="checkbox" value="1" id="postTermsCheck" name="postTermsCheck">
                        <label class="form-check-label post-terms-check pb-2" for="postTermsCheck">
                            <p class="agree">利用規約に同意する</p>
                        </label>
                    </div>
                </div>
                <input type="hidden" id="upload-image-x" name="profileImageX" value="0" />
                <input type="hidden" id="upload-image-y" name="profileImageY" value="0" />
                <input type="hidden" id="upload-image-w" name="profileImageW" value="0" />
                <input type="hidden" id="upload-image-h" name="profileImageH" value="0" />

                <input type="hidden" id="file-data"      name="file_data"     value="0" />
            </div>
            <div class="col-12 text-center mt-3 mb-5">
                <button type="submit" class="btn btn-primary text-white submit-btn" id="postBtn" disabled>画像投稿</button>
            </div>
        </div>
        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-post_image')); ?>">
    </form>
</div>

<!-- モーダル -->
<div class="modal fade image-post-modal" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" id="preview" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <!-- NOTE:拡大バー一旦処理外す。 -->
                        <!-- <div class="mt-3 col-md-8">
                    <input type="range" value="0" id="zoom" min="0" max="3" step="0.1" class="w-100">
                </div> -->
                    </div>
                </div>
            </div>
            <div class="scrollbar"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-primary" id="crop">保存</button>
            </div>
        </div>
    </div>
</div>

<!-- cropper.js -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/cropper.min.js"></script>

<?php
get_footer();
