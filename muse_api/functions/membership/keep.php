<?php

/**
 * ajaxでのキープ追加削除
 * 2022/06/06 Add
 */
function ajax_toggle_keep()
{
	global $dp_options;

	$json = array(
		'result' => false
	);

	if (!isset($_POST['post_id'])) {
		$json['message'] = __('Invalid request.', 'tcd-w');
	} elseif (!current_user_can('read')) {
		$json['message'] = __('Require login.', 'tcd-w');
	} else {
		$user_id = get_current_user_id();
		$post_id = (int) $_POST['post_id'];

		if (0 < $post_id) {
			$target_post = get_post($post_id);
		}
		if (empty($target_post->post_status)) {
			$json['message'] = __('Invalid request.', 'tcd-w');
		} elseif ('publish' !== $target_post->post_status) {
			$json['message'] = sprintf(__('Disable like in %s.', 'tcd-w'), __('Not publish article', 'tcd-w'));
		} elseif ('post' === $target_post->post_type && !$dp_options['membership']['use_like_blog']) {
			$json['message'] = sprintf(__('Disable like in %s.', 'tcd-w'), $dp_options['blog_label'] ? $dp_options['blog_label'] : __('Blog', 'tcd-w'));
		} elseif ($dp_options['photo_slug'] === $target_post->post_type && !$dp_options['membership']['use_like_photo']) {
			$json['message'] = sprintf(__('Disable like in %s.', 'tcd-w'), $dp_options['photo_label'] ? $dp_options['photo_label'] : __('Photo', 'tcd-w'));
		} elseif ($target_post->post_author == $user_id) {
			$json['message'] = __('You can not "LIKE" own post.', 'tcd-w');
		} else {

			// キープ済みの場合、キープ削除
			if (is_keep($post_id, $user_id)) {

				$result = remove_keep($post_id, $user_id);

				if ($result) {
					$json['result'] = 'removed';
					$keeps_number = get_keeps_number($post_id);
					$json['keeps_number'] = $keeps_number;
					update_post_meta($post_id, '_keeps', $keeps_number);
				} else {
					$json['message'] = 'Remove like error: ' . __('Failed to save the database.', 'tcd-w');
				}

				// キープしていない場合、キープ追加
			} else {
				$result = add_keep($post_id, $user_id);
				if ($result) {
					$json['result'] = 'added';
					$keeps_number = get_keeps_number($post_id);
					$json['keeps_number'] = $keeps_number;
					update_post_meta($post_id, '_keeps', $keeps_number);
				} else {
					$json['message'] = 'Add like error: ' . __('Failed to save the database.', 'tcd-w');
				}
			}
		}
	}

	// JSON出力
	wp_send_json($json);
	exit;
}
add_action('wp_ajax_toggle_keep', 'ajax_toggle_keep');
add_action('wp_ajax_nopriv_toggle_keep', 'ajax_toggle_keep');

/**
 * tcd_membership_actionsテーブルからキープ数取得
 */
function get_keeps_number($post_id = null)
{
	if (null === $post_id) {
		$post_id = get_the_ID();
	}

	$post_id = (int) $post_id;
	if (0 >= $post_id) {
		return null;
	}

	global $wpdb;

	$tablename = get_tcd_membership_tablename('actions');
	$sql = "SELECT COUNT(id) FROM {$tablename} WHERE type = 'keep' AND post_id = %d";
	return $wpdb->get_var($wpdb->prepare($sql, $post_id));
}

/**
 * キープ追加
 */
function add_keep($post_id, $user_id = 0)
{
	// キープ済みの場合
	if (is_keep($post_id, $user_id)) {
		return 0;
	}

	if (!$user_id) {
		$user_id = get_current_user_id();
	}

	$post_id = (int) $post_id;
	if (0 >= $post_id) {
		return null;
	}

	$target_post = get_post($post_id);
	if (empty($target_post->post_status) || 'publish' !== $target_post->post_status) {
		return null;
	}

	if (insert_tcd_membership_action('keep', $user_id, $target_post->post_author, $post_id)) {
		return true;
	} else {
		return false;
	}
}

/**
 * キープ削除
 */
function remove_keep($post_id, $user_id = 0)
{

	if (!$user_id) {
		$user_id = get_current_user_id();
	}
	if (!$user_id) {
		return null;
	}

	$post_id = (int) $post_id;
	if (0 >= $post_id) {
		return null;
	}

	/**
	$target_post = get_post($post_id);
	if (empty($target_post->post_status) || 'publish' !== $target_post->post_status) {
		return null;
	}
	 */

	// $target_post = get_post($post_id);
	$target_post = get_post_by_post_id($post_id);
	if (empty($target_post[0]->post_status) || 'publish' !== $target_post[0]->post_status) {
		return null;
	}

	// キープしていない場合
	if (false === is_keep($post_id, $user_id)) {
		return 0;
	}

	if (delete_tcd_membership_action(array(
		'type' => 'keep',
		'user_id' => $user_id,
		'post_id' => $post_id
	))) {
		return true;
	} else {
		return false;
	}
}

/**
 * キープ済みかを判別
 */
function is_keep($post_id = null, $user_id = 0)
{
	if (!$user_id) {
		$user_id = get_current_user_id();
	}
	if (!$user_id) {
		return null;
	}

	if (null === $post_id) {
		$post_id = get_the_ID();
	}
	$post_id = (int) $post_id;
	if (0 >= $post_id) {
		return null;
	}

	// $target_post = get_post($post_id);
	$target_post = get_post_by_post_id($post_id);
	if (empty($target_post[0]->post_status) || 'publish' !== $target_post[0]->post_status) {
		return null;
	}

	if (get_tcd_membership_action('keep', $user_id, $target_post->post_author, $post_id)) {
		return true;
	} else {
		return false;
	}
}
