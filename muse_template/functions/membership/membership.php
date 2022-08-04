<?php

// 定数
define( 'TCD_MEMBERSHIP_VERSION', '1.1' );
define( 'TCD_MEMBERSHIP_DATABASE_VERSION', '1.1' );

// TCD Membership database
get_template_part( 'functions/membership/database' );

// TCD Membership options
get_template_part( 'functions/membership/options' );

// TCD Membership backend
get_template_part( 'functions/membership/backend' );

// TCD Membership member news
get_template_part( 'functions/membership/member_news' );

// TCD Membership mail magazine
get_template_part( 'functions/membership/mail_magazine' );

// TCD Membership frontend
get_template_part( 'functions/membership/frontend' );

// TCD Membership memberpage
get_template_part( 'functions/membership/memberpage' );

// TCD Membership user
get_template_part( 'functions/membership/user' );

// TCD Membership user form
get_template_part( 'functions/membership/user_form' );

// TCD Membership user profile
get_template_part( 'functions/membership/user_profile' );

// TCD Membership add/edit/delete blog
get_template_part( 'functions/membership/blog' );

// TCD Membership add/edit/delete photo
get_template_part( 'functions/membership/photo' );

// TCD Membership comment
get_template_part( 'functions/membership/comment' );

// TCD Membership follow
get_template_part( 'functions/membership/follow' );

// TCD Membership like
get_template_part( 'functions/membership/like' );

// TCD Membership news
get_template_part( 'functions/membership/news' );

// TCD Membership main image
get_template_part( 'functions/membership/main_image' );

// TCD Membership notify
get_template_part( 'functions/membership/notify' );

// TCD Membership report
get_template_part( 'functions/membership/report' );

// TCD Membership messages
get_template_part( 'functions/membership/messages' );

// ADD 2022/05/10 H.Okabe
get_template_part( 'functions/membership/follows' );
get_template_part( 'functions/membership/followers' );
// get_template_part( 'functions/membership/likes' );
get_template_part( 'functions/membership/request' );
get_template_part( 'functions/membership/confirm_request' );
get_template_part( 'functions/membership/order_search' );
get_template_part( 'functions/membership/list_received' );
// get_template_part( 'functions/membership/confirm_received' );
// get_template_part( 'functions/membership/list_all_order' );
get_template_part( 'functions/membership/list_order' );
// get_template_part( 'functions/membership/list_post' );
get_template_part( 'functions/membership/confirm_post' );
get_template_part( 'functions/membership/terms' );
get_template_part( 'functions/membership/agreement' );
get_template_part( 'functions/membership/muse_profile' );
get_template_part( 'functions/membership/information' );
get_template_part( 'functions/membership/list_message' );
get_template_part( 'functions/membership/detail_message' );
get_template_part( 'functions/membership/keep' );
get_template_part( 'functions/membership/muse_notification' );
get_template_part( 'functions/membership/post_image' );
get_template_part( 'functions/membership/page_report' );
get_template_part( 'functions/membership/post_search' );
get_template_part( 'functions/membership/in_progress' );
get_template_part( 'functions/membership/post_comment' );
get_template_part( 'functions/membership/muse_ranking' );
get_template_part( 'functions/membership/muse_oauth' );
get_template_part( 'functions/membership/muse_favorite' );

// load options
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
