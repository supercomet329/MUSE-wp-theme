<?php

/**
 * テーマ変更後の最初の読み込みで実行されるアクションでテーブル作成
 */
add_action( 'after_switch_theme', 'tcd_membership_create_tables' );

/**
 * テーブル作成
 */
function tcd_membership_create_tables( $update_option_version = true ) {
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$charset_collate = $wpdb->get_charset_collate();

	// tcd_post_viewsテーブルが存在しなければテーブル作成
	$tablename = get_tcd_membership_tablename( 'views' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$sql = "CREATE TABLE `{$tablename}` (
			`id` bigint unsigned NOT NULL AUTO_INCREMENT,
			`post_id` bigint unsigned NOT NULL DEFAULT '0',
			`datetime_gmt` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `post_id` (`post_id`),
			KEY `datetime_gmt` (`datetime_gmt`)
		) {$charset_collate} ;";
		dbDelta( $sql );
	}

	// tcd_membership_actionsテーブルが存在しなければテーブル作成
	$tablename = get_tcd_membership_tablename( 'actions' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$sql = "CREATE TABLE `{$tablename}` (
			`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			`type` varchar(255) NOT NULL DEFAULT '',
			`user_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`target_user_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`target_user_ids` TEXT DEFAULT NULL,
			`post_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`created_gmt` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `type` (`type`),
			KEY `user_id` (`user_id`),
			KEY `target_user_id` (`target_user_id`),
			KEY `post_id` (`post_id`),
			KEY `created_gmt` (`created_gmt`)
		) {$charset_collate} ;";
		dbDelta( $sql );
	}

	// tcd_membership_action_metasテーブルが存在しなければテーブル作成
	$tablename = get_tcd_membership_tablename( 'action_metas' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$sql = "CREATE TABLE `{$tablename}` (
			`meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			`action_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`meta_key` varchar(255) NOT NULL DEFAULT '',
			`meta_value` longtext NOT NULL DEFAULT '',
			PRIMARY KEY (`meta_id`),
			KEY `action_id` (`action_id`),
			KEY `meta_key` (`meta_key`)
		) {$charset_collate} ;";
		dbDelta( $sql );
	}

	// tcd_membership_mail_magazine_logsテーブルが存在しなければテーブル作成
	$tablename = get_tcd_membership_tablename( 'mail_magazine_logs' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$sql = "CREATE TABLE `{$tablename}` (
			`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			`subject` text DEFAULT NULL,
			`body` longtext DEFAULT NULL,
			`sent_users` bigint UNSIGNED NOT NULL DEFAULT 0,
			`created_gmt` datetime DEFAULT NULL,
			`send_gmt` datetime DEFAULT NULL,
			PRIMARY KEY (`id`)
		) {$charset_collate} ;";
		dbDelta( $sql );
	}

	// tcd_membership_messagesテーブルが存在しなければテーブル作成
	$tablename = get_tcd_membership_tablename( 'messages' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$sql = "CREATE TABLE `{$tablename}` (
			`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			`sender_user_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`sender_display_name` varchar(255) NOT NULL DEFAULT '',
			`recipient_user_id` bigint UNSIGNED NOT NULL DEFAULT 0,
			`recipient_display_name` varchar(255) NOT NULL DEFAULT '',
			`message` TEXT NOT NULL DEFAULT '',
			`message_encrypted` int(1) UNSIGNED NOT NULL DEFAULT 0,
			`sender_deleted` int(1) UNSIGNED NOT NULL DEFAULT 0,
			`recipient_deleted` int(1) UNSIGNED NOT NULL DEFAULT 0,
			`recipient_read` int(1) UNSIGNED NOT NULL DEFAULT 0,
			`sent_gmt` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `user_messages` (`sender_user_id`, `recipient_user_id`, `sender_deleted`, `recipient_deleted`),
			KEY `find_recipient_unread` (`recipient_user_id`, `recipient_deleted`, `recipient_read`),
			KEY `find_recipient_unread_sent_gmt` (`recipient_user_id`, `recipient_deleted`, `recipient_read`, `sent_gmt`)
		) {$charset_collate} ;";
		dbDelta( $sql );
	}

	if ( $update_option_version && defined( 'TCD_MEMBERSHIP_DATABASE_VERSION' ) && TCD_MEMBERSHIP_DATABASE_VERSION ) {
		update_option( 'tcd_membership_database_version', TCD_MEMBERSHIP_DATABASE_VERSION );
	}
}

/**
 * テーブル名取得
 */
function get_tcd_membership_tablename( $table_type = null ) {
	global $wpdb;

	if ( ! defined( 'TCD_MEMBERSHIP_TABLE_PREFIX' ) ) {
		define( 'TCD_MEMBERSHIP_TABLE_PREFIX', 'tcd_membership_' );
	}
	
	// アクセス数テーブルは別テーマとの互換性を考慮してwp_tcd_post_views
	if ( in_array( $table_type, array( 'views', 'tcd_post_views' ) ) ) {
		// return $wpdb->prefix . 'tcd_post_views';
		return $wpdb->base_prefix . 'tcd_post_views';
	} else {
		// return $wpdb->prefix . TCD_MEMBERSHIP_TABLE_PREFIX . $table_type;
		return $wpdb->base_prefix . TCD_MEMBERSHIP_TABLE_PREFIX . $table_type;
	}
}

/**
 * tcd_membership_action レコード取得
 */
function get_tcd_membership_action( $action_type, $user_id = 0, $target_user_id = 0, $post_id = 0, $single = true ) {
	global $wpdb;

	if ( ! $action_type ) {
		return false;
	}

	$tablename = get_tcd_membership_tablename( 'actions' );
	$prepare = array( $action_type );
	$sql = "SELECT * FROM {$tablename} WHERE type = %s";

	if ( is_numeric( $user_id ) ) {
		$sql .= " AND user_id = %d";
		$prepare[] = $user_id;
	}

	if ( is_array( $target_user_id ) ) {
		$sql .= " AND target_user_id = %d";
	} elseif ( is_numeric( $target_user_id ) ) {
		$sql .= " AND target_user_id = %d";
		$prepare[] = $target_user_id;
	}

	if ( is_numeric( $post_id ) ) {
		$sql .= " AND post_id = %d";
		$prepare[] = $post_id;
	}

	if ( $single ) {
		return $wpdb->get_row( $wpdb->prepare( $sql, $prepare ) );
	} else {
		return $wpdb->get_results( $wpdb->prepare( $sql, $prepare ) );
	}
}

/**
 * tcd_membership_action id指定での単一レコード取得
 */
function get_tcd_membership_action_by_id( $action_id ) {
	global $wpdb;

	$action_id = (int) $action_id;
	if ( 0 >= $action_id ) {
		return false;
	}

	$tablename = get_tcd_membership_tablename( 'actions' );
	$sql = "SELECT * FROM {$tablename} WHERE id = %s";

	return $wpdb->get_row( $wpdb->prepare( $sql, $action_id ) );
}

/**
 * tcd_membership_actions レコード追加
 */
function insert_tcd_membership_action( $action_type, $user_id = 0, $target_user_id = 0, $post_id = 0, $created_gmt = null ) {
	global $wpdb;

	if ( ! $action_type ) {
		return false;
	}

	$data = array(
		'type' => $action_type,
		'user_id' => absint( $user_id ),
		'post_id' => absint( $post_id ),
		'created_gmt' => $created_gmt ? $created_gmt : current_time( 'mysql', true )
	);
	$data_format = array(
		'%s',
		'%d',
		'%d',
		'%s'
	);

	// $target_user_idが配列の場合はカンマ区切りでtarget_user_idsにセット
	if ( is_array( $target_user_id ) ) {
		$data['target_user_ids'] = implode( ',', $target_user_id );
		$data_format[] = '%s';

	// その他はtarget_user_idにセット
	} else {
		$data['target_user_id'] = absint( $target_user_id );
		$data_format[] = '%d';
	}

	$result = $wpdb->insert( get_tcd_membership_tablename( 'actions' ), $data, $data_format );

	if ( $result ) {
		return $wpdb->insert_id;
	} else {
		return false;
	}
}

/**
 * tcd_membership_actions レコード更新
 */
function update_tcd_membership_action( $args = array() ) {
	global $wpdb;

	if ( ! empty( $args['type'] ) ) {
		return false;
	}

	$action_id = 0;
	$action_type = $args['type'];
	$user_id = 0;
	$target_user_id = 0;
	$target_user_ids = null;
	$post_id = 0;
	$created_gmt = null;

	$data = array();
	$data_format = array();

	if ( isset( $args['id'] ) ) {
		$action_id = absint( $args['id'] );
	}if ( isset( $args['action_id'] ) ) {
		$action_id = absint( $args['action_id'] );
	}

	if ( isset( $args['user_id'] ) ) {
		$user_id = absint( $args['user_id'] );
		$data['user_id'] = $user_id;
		$data_format[] = '%d';
	}

	if ( isset( $args['target_user_id'] ) ) {
		$target_user_id = absint( $args['target_user_id'] );
		$data['target_user_id'] = $target_user_id;
		$data_format[] = '%d';
	}

	if ( isset( $args['target_user_ids'] ) ) {
		if ( ! is_array( $args['target_user_ids'] ) ) {
			$target_user_ids = explode( ',', $args['target_user_ids'] );
			$target_user_ids = array_map( 'intval', $target_user_ids );
			$target_user_ids = array_filter( $target_user_ids, 'strlen' );
			$target_user_ids = array_unique( $target_user_ids );
		}
		$data['target_user_ids'] = implode( ',', $target_user_ids );
		$data_format[] = '%s';

		if ( $target_user_id ) {
			if ( ! in_array( $target_user_id, $target_user_ids ) ) {
				$target_user_ids[] = $target_user_id;
			}
			$target_user_id = 0;
		}
	}

	if ( isset( $args['post_id'] ) ) {
		$post_id = absint( $args['post_id'] );
		$data['post_id'] = $post_id;
		$data_format[] = '%d';
	}

	if ( isset( $args['created_gmt'] ) ) {
		$data['created_gmt'] = $args['created_gmt'];
		$data_format[] = '%s';
	}

	// アクションidがある場合のみ更新
	if ( $action_id ) {
		$tablename = get_tcd_membership_tablename( 'actions' );
		$result = $wpdb->update(
			$tablename,
			$data,
			array(
				'id' => $action_id
			),
			$data_format,
			array(
				'%d',
			)
		);

		if ( $result ) {
			return $action_id;
		} else {
			return false;
		}

	} else {
		return insert_tcd_membership_action( $action_type, $user_id, $target_user_id, $post_id, $created_gmt );
	}
}

/**
 * tcd_membership_actions id指定でのレコード削除
 */
function delete_tcd_membership_action_by_id( $action_id ) {
	global $wpdb;

	if ( isset( $action_id->id ) ) {
		$action_id = $action_id->id;
	}

	$action_id = (int) $action_id;
	if ( 0 >= $action_id ) {
		return false;
	}

	$results = $wpdb->delete(
		get_tcd_membership_tablename( 'actions' ),
		array( 'id' => $action_id ),
		array( '%d' )
	);

	// delete metas
	if ( $results ) {
		delete_tcd_membership_action_meta( $action_id );
	}

	return $results;
}

/**
 * tcd_membership_actions レコード削除
 */
function delete_tcd_membership_action( $args = array() ) {
	global $wpdb;

	if ( ! $args ) {
		return false;
	}

	$action_ids = array();

	// id配列指定の場合 array action_ids
	if ( ! empty( $args['action_ids'] ) && is_array( $args['action_ids'] ) ) {
		foreach ( $args['action_ids'] as $action_id ) {
			$action_id = (int) $action_id;
			if ( 0 < $action_id ) {
				$action_ids[] = $action_id;
			}
		}
	// id配列指定の場合 array action_id
	} elseif ( ! empty( $args['action_id'] ) && is_array( $args['action_id'] ) ) {
		foreach ( $args['action_id'] as $action_id ) {
			$action_id = (int) $action_id;
			if ( 0 < $action_id ) {
				$action_ids[] = $action_id;
			}
		}
	// id指定の場合 int action_id
	} elseif ( isset( $args['action_id'] ) && is_numeric( $args['action_id'] ) ) {
		$action_ids[] = $args['action_id'];
	// id指定の場合 int $args
	} elseif ( $args && is_numeric( $args ) ) {
		$action_ids[] = $args;
	}

	if ( ! $action_ids ) {
		// id配列を取得する
		$tablename = get_tcd_membership_tablename( 'actions' );
		$sql = "SELECT id FROM {$tablename} WHERE ";

		$where = array();
		$prepare = array();

		if ( isset( $args['type'] ) ) {
			$where[] = 'type = %s';
			$prepare[] = $args['type'];
		}

		if ( isset( $args['user_id'] ) && is_numeric( $args['user_id'] ) ) {
			$where[] = 'user_id = %d';
			$prepare[] = $args['user_id'];
		}

		if ( isset( $args['target_user_id'] ) && is_numeric( $args['target_user_id'] ) ) {
			$where[] = 'target_user_id = %d';
			$prepare[] = $args['target_user_id'];
		}

		if ( isset( $args['post_id'] ) && is_numeric( $args['post_id'] ) ) {
			$where[] = 'post_id = %d';
			$prepare[] = $args['post_id'];
		}

		if ( ! $where ) {
			return false;
		}

		$action_ids = $wpdb->get_col( $wpdb->prepare( $sql . implode( ' AND ', $where ), $prepare ) );
	}

	if ( $action_ids ) {
		foreach ( $action_ids as $action_id ) {
			delete_tcd_membership_action_by_id( $action_id );
		}

		return count( $action_ids );
	}

	return false;
}

/**
 * tcd_membership_action_metas action_id及びmeta_keyからのメタデータ取得
 */
function get_tcd_membership_action_meta( $action_id, $meta_key, $single = true ) {
	global $wpdb;

	$action_id = (int) $action_id;
	if ( 0 < $action_id || ! $meta_key ) {
		$tablename = get_tcd_membership_tablename( 'action_metas' );
		$sql = "SELECT meta_value FROM {$tablename} WHERE action_id = %d AND meta_key = %s";
		$results = $wpdb->get_col( $wpdb->prepare( $sql, $action_id, $meta_key ) );
		if ( $results ) {
			if ( $single ) {
				return maybe_unserialize( $results[0] );
			} else {
				return array_map( 'maybe_unserialize', $results );
			}
		}
	}

	if ( $single ) {
		return '';
	} else {
		return array();
	}
}

/**
 * tcd_membership_action_metas meta_key及びmeta_valueからのレコード取得
 */
function get_tcd_membership_meta_by_meta( $meta_key, $meta_value = null, $single = true ) {
	global $wpdb;

	if ( $meta_key || $meta_value ) {
		$tablename = get_tcd_membership_tablename( 'action_metas' );
		$prepare = array();

		if ( $meta_key && $meta_value ) {
			$sql = "SELECT * FROM {$tablename} WHERE meta_key = %s AND meta_value = %s";
			$prepare = array( $meta_key, $meta_value );
		} elseif ( $meta_key ) {
			$sql = "SELECT * FROM {$tablename} WHERE meta_key = %s";
			$prepare = array( $meta_key );
		} elseif ( $meta_value ) {
			$sql = "SELECT * FROM {$tablename} WHERE meta_value = %s";
			$prepare = array( $meta_value );
		}

		if ( $prepare ) {
			if ( $single ) {
				return $wpdb->get_row( $wpdb->prepare( $sql, $prepare ) );
			} else {
				return $wpdb->get_results( $wpdb->prepare( $sql, $prepare ) );
			}
		}
	}

	if ( $single ) {
		return '';
	} else {
		return array();
	}
}

/**
 * tcd_membership_action_metas レコード保存
 */
function update_tcd_membership_action_meta( $action_id, $meta_key, $meta_value ) {
	global $wpdb;

	$action_id = (int) $action_id;
	if ( 0 >= $action_id || ! $meta_key ) {
		return false;
	}

	$tablename = get_tcd_membership_tablename( 'action_metas' );
	$sql = "SELECT meta_id FROM {$tablename} WHERE action_id = %d AND meta_key = %s";
	$meta_id = $wpdb->get_var( $wpdb->prepare( $sql, $action_id, $meta_key ) );

	if ( $meta_id ) {
		$result = $wpdb->update(
			$tablename,
			array(
				'meta_value' => maybe_serialize( $meta_value )
			),
			array(
				'meta_id' => $meta_id,
				'action_id' => $action_id,
				'meta_key' => $meta_key,
			),
			array(
				'%s'
			),
			array(
				'%d',
				'%d',
				'%s'
			)
		);

		if ( $result ) {
			return $meta_id;
		}

	} else {
		$result = $wpdb->insert(
			$tablename,
			array(
				'action_id' => $action_id,
				'meta_key' => $meta_key,
				'meta_value' => maybe_serialize( $meta_value )
			),
			array(
				'%d',
				'%s',
				'%s'
			)
		);

		if ( $result ) {
			return $wpdb->insert_id;
		}
	}

	return false;
}

/**
 * tcd_membership_action_metas レコード削除
 */
function delete_tcd_membership_action_meta( $action_id, $meta_key = null ) {
	global $wpdb;

	$action_id = (int) $action_id;
	if ( 0 >= $action_id ) {
		return false;
	}

	$where = array( 'action_id' => $action_id );
	$where_format = array( '%d' );

	if ( $meta_key ) {
		$where['meta_key'] = $meta_key;
		$where_format[] = '%s';
	}

	return $wpdb->delete(
		get_tcd_membership_tablename( 'action_metas' ),
		$where,
		$where_format
	);
}

/**
 * オプション保存されているデータベースバージョンが引数バージョン以上かチェック
 */
function tcd_membership_database_version_compare( $require_version = null, $operator = '>=' ) {
	static $results = array();

	if ( ! $require_version ) {
		return false;
	} elseif ( ! isset( $results[ $require_version ] ) ) {
		$results[ $require_version ] = version_compare( get_option( 'tcd_membership_database_version' ), $require_version, $operator );
	}

	return $results[ $require_version ];
}

/**
 * データベース構造更新実行
 */
function tcd_membership_database_update() {
	global $wpdb;

	// 新テーブル対策でテーブル作成実行
	tcd_membership_create_tables( false );

	// tcd_membership_actionsテーブルにがtarget_user_idsカラムが存在しなければカラム追加
	$tablename = get_tcd_membership_tablename( 'actions' );
	if ( ! $wpdb->get_results( "DESCRIBE {$tablename} target_user_ids" ) ) {
		$wpdb->query( "ALTER TABLE {$tablename} ADD target_user_ids TEXT DEFAULT NULL AFTER target_user_id" );
		if ( ! $wpdb->get_results( "DESCRIBE {$tablename} target_user_ids" ) ) {
			return false;
		}
	}

	// tcd_membership_messagesテーブルが存在しなければ失敗
	$tablename = get_tcd_membership_tablename( 'messages' );
	if ( ! $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		return false;
	}

	if ( defined( 'TCD_MEMBERSHIP_DATABASE_VERSION' ) && TCD_MEMBERSHIP_DATABASE_VERSION ) {
		update_option( 'tcd_membership_database_version', TCD_MEMBERSHIP_DATABASE_VERSION );
		return true;
	}
}

/**
 * 必要ならデータベース構造更新実行・ノーティス表示
 */
function tcd_membership_database_update_all_admin_notices() {
	// TCD_MEMBERSHIP_DATABASE_VERSION定数が未設定の場合は終了
	if ( ! defined( 'TCD_MEMBERSHIP_DATABASE_VERSION' ) || ! TCD_MEMBERSHIP_DATABASE_VERSION ) {
		return;
	}

	// クエリーストリングスにtcd_membership_database_update=forceがある場合は除外チェックしない
	if ( ! isset( $_GET['tcd_membership_database_update'] ) || 'force' !== $_GET['tcd_membership_database_update'] ) {
		// オプション保存されているデータベースバージョンが最新版なら終了
		if ( tcd_membership_database_version_compare( TCD_MEMBERSHIP_DATABASE_VERSION ) ) {
			return;
		}
	}

	// データベース構造更新実行
	if ( tcd_membership_database_update() ) {
		echo '<div class="notice notice-info"><p><strong>' . __( 'TCD Theme', 'tcd-w' ) . '</strong> ' . sprintf( __( 'Membership database updated (%s).', 'tcd-w' ), TCD_MEMBERSHIP_DATABASE_VERSION ) . '</p></div>';
	} else {
		echo '<div class="notice notice-error"><p><strong>' . __( 'TCD Theme', 'tcd-w' ) . '</strong> ' . sprintf( __( 'Faild to membership database update (%s).', 'tcd-w' ), TCD_MEMBERSHIP_DATABASE_VERSION ) . '</p></div>';
	}
}
add_action( 'all_admin_notices','tcd_membership_database_update_all_admin_notices' );
