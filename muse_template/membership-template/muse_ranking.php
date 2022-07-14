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
                        <tr class="rank-1">
                            <td class="font-gold">1位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-1 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-2">
                            <td class="font-silver">2位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-2 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-3">
                            <td class="font-bronze">3位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-3 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-4">
                            <td>4位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-4 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-5">
                            <td>5位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-5 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-6">
                            <td>6位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-6 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-7">
                            <td>7位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-7 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-8">
                            <td>8位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-8 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-9">
                            <td>9位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-9 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-10">
                            <td>10位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-10 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-11">
                            <td>11位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-11 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-12">
                            <td>12位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-12 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-13">
                            <td>13位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-13 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-14">
                            <td>14位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-14 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-15">
                            <td>15位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-15 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-16">
                            <td>16位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-16 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-17">
                            <td>17位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-17 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-18">
                            <td>18位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-18 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-19">
                            <td>19位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-19 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="rank-20">
                            <td>20位</td>
                            <td>
                                <a href="profile.html">
                                    <p class="mb-0 font-weight-bold text-dark">ユーザー名</p>
                                </a>
                                <p class="sp-btn mb-0 more">詳細</p>
                            </td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr>
                        <tr class="sp detail-rank-20 not-show">
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
                                    <p class="mb-0 font-weight-normal">100</div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                                <div class="col-4 float-left">
                                    <p class="mb-0 font-weight-normal">100</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
get_footer();
