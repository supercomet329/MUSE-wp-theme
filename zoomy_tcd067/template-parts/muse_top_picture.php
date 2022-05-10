<?php
global $dp_options, $post;
if (!$dp_options) $dp_options = get_design_plus_option();
?>
<main role="main">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">タイムライン切り替え</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="cp_ipradio">
                        <ul style="list-style: none;">
                            <li class="list_item">
                                <label>
                                    <input type="radio" class="option-input" name="a" checked>
                                    　通常モード
                                </label>
                            </li>
                            <li class="list_item">
                                <label>
                                    <input type="radio" class="option-input" name="a">
                                    　ピクチャーモード
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // TODO: 2022/05/09 画像投稿できるようになったら投稿を確認
    $list_photo = list_author_post($author->ID, 'photo');
    $list_slice_photo = array_chunk($list_photo, 3);
    $i = 0;

    foreach ($list_slice_photo as $array_slice_photo) {
    ?>
        <?php if ($i <= 0) { ?>
            <div class="content pt-5 pb-1">
            <?php } else { ?>
                <div class="content">
                <?php } ?>
                <?php foreach ($array_slice_photo as $one_photo) { ?>
                    <div class="content-item shadow d-flex align-items-center justify-content-center px-1">
                        <img class="image-list" src="<?php echo $one_photo->meta_value; ?>">
                    </div>
                <?php } ?>
                </div>
            <?php
            $i++;
        }
        /** endforeach */
            ?>
</main>