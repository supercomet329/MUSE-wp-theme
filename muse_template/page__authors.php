<?php

/**
 * Template Name: Author list
 */

$active_sidebar = get_active_sidebar();
get_header();
?>
<main class="l-main has-bg--pc">
<?php
get_template_part( 'template-parts/page-header' );
if ( 'show' === $post->display_breadcrumb ) :
	get_template_part( 'template-parts/breadcrumb' );
endif;

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		if ( $active_sidebar ) :
?>
	<div class="l-inner l-2columns">
<?php
		endif;
?>
		<article class="p-entry p-entry-page <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
<?php
		if ( has_post_thumbnail() || get_the_content() || post_password_required() ) :
?>
			<div class="p-entry-page__inner">
<?php
			if ( has_post_thumbnail() ) :
				echo "\t\t\t\t<div class=\"p-entry__thumbnail\">";
				the_post_thumbnail();
				echo "</div>\n";
			endif;
?>
				<div class="p-entry__body p-entry-page__body p-body">
<?php
			the_content();

			if ( ! post_password_required() ) :
				$link_pages = wp_link_pages( array(
					'before' => '<div class="p-page-links">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
					'echo' => 0
				) );
				if ( get_query_var( 'paged' ) > 1 ) :
					if ( preg_match_all( '/ href="(.+?)"/', $link_pages, $matches ) ) :
						foreach ( $matches[1] as $key => $value ) :
							if ( get_option( 'permalink_structure' ) ) :
								$paged_url = user_trailingslashit( untrailingslashit( $value ) . '/page/' . get_query_var( 'paged' ) );
							else :
								$paged_url = add_query_arg( 'paged', get_query_var( 'paged' ), html_entity_decode( $value ) );
								$paged_url = str_replace( '&', '&#038;', $paged_url );
							endif;
							$paged_href = str_replace( $value, $paged_url, $matches[0][$key] );
							$link_pages = str_replace( $matches[0][$key], $paged_href, $link_pages );
						endforeach;
					endif;
				endif;
				echo $link_pages . "\n";
			endif;
?>
				</div>
			</div>
<?php
		endif;
	endwhile;

	if ( ! post_password_required() ) :
		$authors_args = array(
			'orderby' => 'display_name',
			'order' => 'ASC',
			'who' => 'authors'
		);

		if ( $post->authors_exclude ) :
			$authors_args['exclude'] = trim( $post->authors_exclude, ' ,' );
		endif;

		if ( $post->show_search_form && 'type2' === $post->search_form_type ) :
			// 検索先カラム プロフィール表示項目の一部を検索先に選択可能
			$search_columns = array(
				'username' => array(
					'label' => $dp_options['membership']['field_label_display_name']
				)
			);

			if ( $dp_options['membership']['show_profile_fullname'] ) :
				$search_columns['fullname'] = array(
					'label' => $dp_options['membership']['field_label_fullname'],
					'meta_key' => array( 'last_name', 'first_name' )
				);
			endif;

			if ( $dp_options['membership']['show_profile_area'] ) :
				$search_columns['area'] = array(
					'label' => $dp_options['membership']['field_label_area'],
					'meta_key' => array( 'area' )
				);
			endif;

			if ( $dp_options['membership']['show_profile_company'] ) :
				$search_columns['company'] = array(
					'label' => $dp_options['membership']['field_label_company'],
					'meta_key' => array( 'company' )
				);
			endif;

			if ( $dp_options['membership']['show_profile_job'] ) :
				$search_columns['job'] = array(
					'label' => $dp_options['membership']['field_label_job'],
					'meta_key' => array( 'job' )
				);
			endif;

			if ( $dp_options['membership']['show_profile_desc'] ) :
				$search_columns['description'] = array(
					'label' => $dp_options['membership']['field_label_desc'],
					'meta_key' => array( 'description' )
				);
			endif;

			if ( ! empty( $_GET['search_authors'] ) ) :
				// ユーザーメタクエリー
				if ( ! empty( $_GET['search_column'] ) && ! empty( $search_columns[ $_GET['search_column'] ]['meta_key'] ) ) :
					$authors_args['meta_query']['relation'] = 'OR';
					foreach ( $search_columns[ $_GET['search_column'] ]['meta_key'] as $meta_key ) :
						$authors_args['meta_query'][] = array(
							'key' => $meta_key,
							'value' => trim( wp_unslash( $_GET['search_authors'] ), ' *' ),
							'compare' => 'LIKE'
						);
					endforeach;
				else :
					$_GET['search_column'] = 'username';
					$authors_args['search'] = '*' . trim( wp_unslash( $_GET['search_authors'] ), ' *' ) . '*';
					$authors_args['search_columns'] = array( 'display_name' );
				endif;
			endif;

		elseif ( $post->show_search_form && 'type2' !== $post->search_form_type && ! empty( $_GET['search_authors'] ) ) :
				$authors_args['search'] = '*' . trim( wp_unslash( $_GET['search_authors'] ), ' *' ) . '*';
				$authors_args['search_columns'] = array( 'display_name' );
			endif;
		endif;

		// ページングに総投稿者数が必要なためここで全投稿者取得
		$all_authors = get_users( $authors_args );
?>
			<div class="p-user-list__container">
<?php
		if ( $post->show_search_form ) :
			if ( 'type2' === $post->search_form_type ) :
?>
				<form action="?" class="p-user-list__search p-user-list__search-type2" method="get">
					<input class="p-user-list__search-input" name="search_authors" type="text" value="<?php if ( ! empty( $_GET['search_authors'] ) ) echo esc_attr( $_GET['search_authors'] ); ?>">
					<select class="p-user-list__search-select" name="search_column">
<?php
			foreach ( $search_columns as $k => $v ) :
				echo '<option value="' . esc_attr( $k ) . '" ' . selected( $k, ! empty( $_GET['search_column'] ) ? $_GET['search_column'] : null ) . '>' . esc_html( $v['label'] ) . '</option>';
			endforeach;
?>
					</select>
					<input class="p-user-list__search-submit" type="submit" value="&#xe915;">
<?php
			foreach ( $_GET as $k => $v ) :
				if ( in_array( $k, array( 'search_authors', 'search_column', 'paged' ) ) ) continue;
				echo '<input name="' . esc_attr( $k ) . '" type="hidden" value="' . esc_attr( $v ) . '">';
			endforeach;
?>
				</form>
<?php
			else :
?>
				<form action="?" class="p-user-list__search" method="get">
					<input class="p-user-list__search-input" name="search_authors" type="text" value="<?php if ( ! empty( $_GET['search_authors'] ) ) echo esc_attr( $_GET['search_authors'] ); ?>">
					<input class="p-user-list__search-submit" type="submit" value="&#xe915;">
<?php
			foreach ( $_GET as $k => $v ) :
				if ( in_array( $k, array( 'search_authors', 'paged' ) ) ) continue;
				echo '<input name="' . esc_attr( $k ) . '" type="hidden" value="' . esc_attr( $v ) . '">';
			endforeach;
?>
				</form>
<?php
			endif;
		endif;

		if ( $all_authors ) :
			if ( is_mobile() ) :
				$authors_num = is_numeric( $post->authors_num_mobile ) ? absint( $post->authors_num_mobile ) : 4;
			else :
				$authors_num = is_numeric( $post->authors_num ) ? absint( $post->authors_num ) : 8;
			endif;
			$authors_current_page = max( 1, get_query_var( 'paged' ) );
			$authors_max_page = ceil( count( $all_authors ) / $authors_num );
			if ( $authors_current_page > $authors_max_page ) :
				$authors_current_page = $authors_max_page;
			endif;
			$authors = array_slice( $all_authors, ( $authors_current_page - 1 ) * $authors_num, $authors_num );
?>
				<div class="p-user-list">
<?php
			foreach ( $authors as $author ) :
?>
					<div class="p-user-list__item">
						<div class="p-user-list__item__inner">
							<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); the_tcd_membership_guest_require_login_class( 'author', 'single', ' ' ); ?>" href="<?php echo esc_attr( get_author_posts_url( $author->ID ) ); ?>">
								<div class="p-author__thumbnail js-object-fit-cover">
									<div class="p-author__thumbnail__inner p-hover-effect__image"><?php echo get_avatar( $author->ID, 300 ); ?></div>
								</div>
								<div class="p-author__name"><?php echo esc_html( $author->display_name ); ?></div>
							</a>
<?php
				if ( $dp_options['membership']['use_follow'] ) :
?>
							<div class="p-author__follow">
<?php
					if ( is_following( $author->ID ) ) :
?>
								<a class="p-button-following js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Following', 'tcd-w' ); ?></a>
<?php
					else :
?>
								<a class="p-button-follow js-toggle-follow" href="#" data-user-id="<?php echo esc_attr( $author->ID ); ?>"><?php _e( 'Follow', 'tcd-w' ); ?></a>
<?php
					endif;
?>
							</div>
<?php
				endif;
?>
						</div>
					</div>
<?php
			endforeach;
?>
				</div>
<?php
			$paginate_links = paginate_links( array(
				'current' => $authors_current_page,
				'next_text' => '&#xe910;',
				'prev_text' => '&#xe90f;',
				'total' => $authors_max_page,
				'type' => 'array',
			) );
			if ( $paginate_links ) :
?>
				<ul class="p-pager">
<?php
				foreach ( $paginate_links as $paginate_link ) :
?>
					<li class="p-pager__item"><?php echo $paginate_link; ?></li>
<?php
				endforeach;
?>
				</ul>
<?php
			endif;
		else :
?>
				<p class="no_authors"><?php _e( 'author was not found.', 'tcd-w' ); ?></p>
<?php
		endif;
?>
			</div>
		</article>
<?php
	if ( $active_sidebar ) :
		get_sidebar();
?>
	</div>
<?php
	endif;
endif;
?>
</main>
<?php
get_footer();
