<?php
// Add 2022/05/10 by H.Okabe
/**
 * 利用規約
 */
function tcd_membership_action_terms()
{
    global $tcd_membership_vars;
    $tcd_membership_vars['template'] = 'muse_terms';
}
add_action('tcd_membership_action-terms', 'tcd_membership_action_terms');