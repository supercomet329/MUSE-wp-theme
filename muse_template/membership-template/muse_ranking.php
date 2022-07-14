<?php
global $dp_options, $tcd_membership_vars;
get_header();
?>
<div class="container pt-2">
    <div class="row mb-2">
        <div class="col-12">
            <a href="javascript:history.back();">← 戻る</a>
        </div>
    </div>
    <div class="text-center font-weight-bold title">
        ランキング
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table my-3 text-black ranking-table table-light rounded table-hover ">
                <thead class="text-white text-center">
                    <tr>
                        <th>順位</th>
                        <th>ユーザー名</th>
                        <th>取引数</th>
                        <th>平均価格</th>
                        <th>所有者数</th>
                        <th>作品数</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tcd_membership_vars['ranking'] as $rankingOne) {

                        switch ($rankingOne->ranking) {
                            case 1:
                                $class = 'font-gold';
                                break;

                            case 2:
                                $class = 'font-silver';
                                break;

                            case 3:
                                $class = 'font-bronze';
                                break;

                            default:
                                $class = '';
                                break;
                        }

                    ?>
                        <tr class="rank-<?php echo esc_attr($rankingOne->ranking); ?>">
                            <td class="<?php echo esc_attr($class); ?>"><?php echo esc_attr($rankingOne->ranking); ?>位</td>
                            <td>
                                <a href="<?php echo esc_url(get_tcd_membership_memberpage_url('profile')) ?>&user_id=<?php echo esc_attr($rankingOne->user_id); ?>">
                                    <p class="mb-0 font-weight-bold text-dark"><?php echo esc_attr($rankingOne->display_name); ?></p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td><?php echo esc_attr($rankingOne->count_transaction); ?></td>
                            <td><?php echo esc_attr($rankingOne->average_price); ?></td>
                            <td><?php echo esc_attr($rankingOne->count_owned); ?></td>
                            <td><?php echo esc_attr($rankingOne->count_work); ?></td>
                        </tr>
                        <tr class="sp detail-rank-<?php echo esc_attr($rankingOne->ranking); ?> not-show">
                            <td colspan="3" class="pt-0">
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-bold text-white">平均価格</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-bold text-white">所有者数</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-bold text-white">作品数</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal"><?php echo esc_attr($rankingOne->average_price); ?></p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal"><?php echo esc_attr($rankingOne->count_owned); ?></p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal"><?php echo esc_attr($rankingOne->count_work); ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php }
                    /** endforeach */ ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
get_footer();
