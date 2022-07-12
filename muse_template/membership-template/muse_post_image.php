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
            <div class="col-12">
                <div class="error_message" id="errPostImage"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="saleType" class="label-text post-input-title mt-4">タイトル（必須）</label>
            </div>
            <div class="col-12">
                <input class="form-control post-input" type="text" name="postTitle" id="postTitle" placeholder="タイトルを入力">
            </div>
            <div class="col-12">
                <div class="error_message" id="errPostTitle"></div>
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

            <div id="saleForm" style="display: none;">
                <div class="col-12 mt-2">
                    <label for="selectAuction" class="label-text post-input-title mt-4">オークション開催（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2 text-nowrap">
                        <label><input type="radio" name="selectAuction" value="Auction" id="auction">あり</label>
                    </div>

                    <div class="col-5 post-radio ml-2 text-nowrap">
                        <label><input type="radio" name="selectAuction" value="notAuction" id="notAuction" checked>なし</label>
                    </div>
                </div>
            </div>

            <!-- NFT販売 -->
            <div id="nftSaleForm" style="display: none;">
                <div class="col-12">
                    <label for="imagePrice" class="label-text post-input-title mt-4">販売価格（必須）</label>
                </div>
                <div class="col-12">
                    <input class="form-control post-input image-price-input" type="number" name="imagePrice" id="imagePrice" placeholder="金額を入力">
                    <div class="image-price-jpy">
                        円
                    </div>
                </div>
                <div class="col-12">
                    <div class="error_message" id="errImagePrice"></div>
                </div>
                <div class="col-12">
                    <p class="commission-title">手数料差し引き残額</p>
                    <p class="commission-price">0円</p>
                </div>
            </div>

            <!-- オークション販売 -->
            <div id="auctionSaleForm" style="display: none;">
                <div class="col-12">
                    <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2 text-nowrap">
                        <label><input type="radio" name="auctionStartDate" value="notSpecified" id="notSpecified" checked>指定しない</label>
                    </div>
                    <div class="col-5 post-radio ml-2 text-nowrap">
                        <label><input type="radio" name="auctionStartDate" value="specify" id="specify">開始時間指定</label>
                    </div>
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
                    <div class="error_message" id="errBinPrice"></div>
                </div>

                <div id="auctionTimeForm">

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
                            <input type="hidden" value="2" id="setAuctionDateD" />
                        </div>
                    </div>
                    <div class="col-12 row mt-1">
                        <div class="col-4">
                            <select class="auction-input" placeholder="dd" name="auctionDateH" id="auctionDateH">
                            </select>
                            <p class="auction-date">時</p>
                            <input type="hidden" value="2" id="setAuctionDateH" />
                        </div>
                        <div class="col-4">
                            <select class="auction-input" placeholder="mm" name="auctionDateMin" id="auctionDateMin">
                            </select>
                            <p class="auction-date">分</p>
                            <input type="hidden" value="2" id="setAuctionDateMin" />
                        </div>
                        <div class="col-4">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="error_message" id="errAppDeadline"></div>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション終了日時</label>
                    </div>
                    <div class="col-12 row">
                        <div class="col-4">
                            <select class="auction-input" placeholder="yyyy" name="auctionEndDateY" id="auctionEndDateY">
                            </select>
                            <p class="auction-date">年</p>
                            <input type="hidden" value="2024" id="setAuctionEndDateY" />
                        </div>
                        <div class="col-4">
                            <select class="auction-input" placeholder="mm" name="auctionEndDateM" id="auctionEndDateM">
                            </select>
                            <p class="auction-date">月</p>
                            <input type="hidden" value="2" id="setAuctionEndDateM" />
                        </div>
                        <div class="col-4">
                            <select class="auction-input" placeholder="dd" name="auctionEndDateD" id="auctionEndDateD">
                            </select>
                            <p class="auction-date">日</p>
                            <input type="hidden" value="2" id="setAuctionEndDateD" />
                        </div>
                    </div>
                    <div class="col-12 row mt-1">
                        <div class="col-4">
                            <select class="auction-input" placeholder="dd" name="auctionEndDateH" id="auctionEndDateH">
                            </select>
                            <p class="auction-date">時</p>
                            <input type="hidden" value="2" id="setAuctionEndDateH" />
                        </div>
                        <div class="col-4">
                            <select class="auction-input" placeholder="mm" name="auctionEndDateMin" id="auctionEndDateMin">
                            </select>
                            <p class="auction-date">分</p>
                            <input type="hidden" value="2" id="setAuctionEndDateMin" />
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-12">
                            <div class="error_message" id="errAuctionEnd"></div>
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
            </div>

            <!-- 画像投稿ボタン -->
            <div class="col-12 text-center mt-3 mb-5">
                <button type="submit" class="btn btn-primary text-white submit-btn" id="postBtn" disabled>画像投稿</button>
            </div>
        </div>

        <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('tcd-membership-post_image')); ?>">
        <input type="hidden" id="file-data" name="file_data" value="0" />
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
