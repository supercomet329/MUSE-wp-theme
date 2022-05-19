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

    <div class="container">
        <?php
        // TODO: いいね等のボタンの処理
        $list_photo = list_author_post($author->ID, 'photo');

        foreach ($list_photo as $one_photo) {
            $user_info = get_userdata($one_photo->post_author);
            $dataClass = new DateTime($one_photo->post_modified);
        ?>
            <div class="pt-1">
                <div class="card shadow-sm">
                    <div>
                        <div>
                            <img class="rounded-circle profile-icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/pixta_85053177_M.jpg" alt="" width="60px" height="60px">
                            <div class="user-name"><?php echo $user_info->display_name; ?> <?php echo $dataClass->format('H:i'); ?></div>
                            <div class="float-right pr-3 pt-4 see_more">・・・</div>
                        </div>
                        <div class="pb-1 pl-5 tweet-text"><?php echo $one_photo->post_title; ?></div>
                    </div>
                    <img class="px-1 tweet-image" src="<?php echo $one_photo->meta_value; ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <img class="js-toggle-like p-has-icon" data-post-id="<?php echo $one_photo->ID; ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/iine.jpg" alt="iine" width="60px">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/gem.jpg" alt="gem" width="60px">
                            </div>
                            <div class="add-more">>>and more</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        /** endforeach */
        ?>
    </div>
</main>