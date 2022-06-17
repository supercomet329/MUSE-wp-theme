<?php
// Add 2022/05/10 by H.Okabe
/**
 * 会員規約
 */
function tcd_membership_action_agreement()
{
    var_dump('こんにちは');
    var_dump(__LINE__);exit;
}
add_action('tcd_membership_action-agreement', 'tcd_membership_action_agreement');