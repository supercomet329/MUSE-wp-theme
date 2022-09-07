<?php
// 画像投稿ページ
global $dp_options, $tcd_membership_vars;

get_header();
?>

<div class="pc-center">
    <form action="POST">
        <div class="container pt-2 confirm-area">


            <div class="row">
                <div class="col-12">
                    <label for="saleType" class="label-text post-input-title mt-4">タイトル（必須）</label>
                </div>
                <div class="col-12">
                    <input class="form-control post-input" type="text" name="postTitle" id="postTitle" value="<?php echo $tcd_membership_vars['setDataParams']['postTitle']; ?>" id="postTitle" placeholder="タイトルを入力">
                </div>
                <div class="col-12">
                    <div class="inputPostTitle" id="inputPostTitle"></div>
                </div>
                <div class="col-12">
                    <label for="saleType" class="label-text post-input-title mt-4">投稿内容（任意）</label>
                </div>


                <div class="col-12">
                    <div class="form-imgarea-area1">

                        <div class="FlexTextarea">
                            <div class="FlexTextarea__dummy" aria-hidden="true"></div>
                            <textarea class="FlexTextarea__textarea" name="postDetail" id="postDetail" placeholder="詳細を入力"><?php echo $tcd_membership_vars['setDataParams']['postDetail']; ?></textarea>
                        </div>


                        <span id="image_html"></span>

                        <!--追加ボタン-->
                        <div class="clear">&nbsp;</div>
                        <div id="add_image" class="img-plus clearfix">
                            <!-- a href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post-plus.png" />
                            </a -->
                            <span id="btn_upload_file" title="ファイルを選択">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/post-plus.png" />
                            </span>
                            <input type="hidden" id="image_0" name="image_0" value=''>
                            <input type="hidden" id="image_1" name="image_1" value=''>
                            <input type="hidden" id="image_2" name="image_2" value=''>
                            <input type="hidden" id="image_3" name="image_3" value=''>
                            <input type="hidden" id="image_4" name="image_4" value=''>
                            <input type="file" id="files" />
                        </div>
                    </div>
                </div>

                <script>
                    function flexTextarea(el) {
                        const dummy = el.querySelector('.FlexTextarea__dummy')
                        el.querySelector('.FlexTextarea__textarea').addEventListener('input', e => {
                            dummy.textContent = e.target.value + '\u200b'
                        })
                    }
                    document.querySelectorAll('.FlexTextarea').forEach(flexTextarea)
                </script>


                <div class="col-12 mt-2">
                    <label for="saleType" class="label-text post-input-title mt-4">販売形式（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="sale" id="sale" <?php echo ($tcd_membership_vars['setDataParams']['saleType'] === 'sale') ? 'checked' : ''; ?>>NFT販売</label>
                    </div>
                    <!-- <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="auction" id="auction">オークション</label>
                    </div> -->
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="saleType" value="notForSale" id="notForSale" <?php echo ($tcd_membership_vars['setDataParams']['saleType'] !== 'sale') ? 'checked' : ''; ?>>販売しない</label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="suitableAges" class="label-text post-input-title mt-4">対象（必須）</label>
                </div>
                <div class="col-12 row">
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="suitableAges" value="allAges" id="allAges" <?php echo ($tcd_membership_vars['setDataParams']['suitableAges'] === 'allAges') ? 'checked' : ''; ?>>全年齢</label>
                    </div>
                    <div class="col-5 post-radio ml-2">
                        <label><input type="radio" name="suitableAges" value="r18" id="restrictedAge" <?php echo ($tcd_membership_vars['setDataParams']['suitableAges'] !== 'allAges') ? 'checked' : ''; ?>>R-18</label>
                    </div>
                </div>

                <!-- 販売形式フォーム-->
                <div class="saleSection saleTypeSection mb-4">
                    <div class="col-12 mt-2">
                        <label for="selectAuction" class="label-text post-input-title mt-4">オークション開催（必須）</label>
                    </div>
                    <div class="col-12 row">
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="selectAuction" value="Auction" id="auction" <?php echo ($tcd_membership_vars['setDataParams']['selectAuction'] === 'Auction') ? 'checked' : ''; ?>>あり</label>
                        </div>
                        <div class="col-5 post-radio ml-2">
                            <label><input type="radio" name="selectAuction" value="notAuction" id="notAuction" <?php echo ($tcd_membership_vars['setDataParams']['selectAuction'] !== 'Auction') ? 'checked' : ''; ?>>なし</label>
                        </div>
                    </div>
                    <!-- オークションあり形式フォーム -->
                    <div class="holdauctionSection selectAuctionsection">
                        <div class="col-12">
                            <label for="auctionStartDate" class="label-text post-input-title mt-4">オークション開始日時（必須）</label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="auctionStartDate" value="notSpecified" id="notSpecified" <?php echo ($tcd_membership_vars['setDataParams']['auctionStartDate'] === 'notSpecified') ? 'checked' : ''; ?>>指定しない</label>
                            </div>
                            <div class="col-5 post-radio ml-2">
                                <label><input type="radio" name="auctionStartDate" value="specify" id="specify" <?php echo ($tcd_membership_vars['setDataParams']['auctionStartDate'] !== 'notSpecified') ? 'checked' : ''; ?>>開始時間指定</label>
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
                            <div class="col-12 row">
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
                                        <label><input type="radio" name="extendAuction" value="enableAutoExtend" id="enableAutoExtend" <?php echo ($tcd_membership_vars['setDataParams']['extendAuction'] !== 'disableAutoExtend') ? 'checked' : ''; ?>>あり</label>
                                    </div>
                                    <div class="col-5 post-radio ml-2">
                                        <label><input type="radio" name="extendAuction" value="disableAutoExtend" id="disableAutoExtend" <?php echo ($tcd_membership_vars['setDataParams']['extendAuction'] === 'disableAutoExtend') ? 'checked' : ''; ?>>なし</label>
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
                                <input class="form-control post-input image-price-input" type="number" name="imagePrice" id="imagePrice" value="<?php echo $tcd_membership_vars['setDataParams']['imagePrice']; ?>" placeholder="金額を入力">
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
                                <input class="form-control post-input image-price-input" type="number" name="binPrice" id="binPrice" value="<?php echo $tcd_membership_vars['setDataParams']['binPrice']; ?>" placeholder="金額を入力">
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
                    <div class="col-12 text-center mt-3 mb-5">
                        <button type="submit" class="btn btn-primary text-white submit-btn" id="postBtn" disabled>画像投稿確認</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
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

    <?php
    get_footer();
