<?php
use ClientNamespace\{ Components, Constants };
use WPUtil\{ Component, Vendor };

get_header();

$blog_page_id = get_option('page_for_posts');

Component::render(Components\Banners\BannerDefault::class, [
	'title' => get_the_title($blog_page_id),
	'post_id' => $blog_page_id
]);

?>
<main class="tmpl-archive tmpl-archive--blog">
	<?php
	global $wp_query;

	Component::render(Components\PostsList\PostsListBlog::class, [
		'wp_query_obj' => $wp_query
	]);
	?>
</main>
<?php

Vendor\BlueprintBlocks::safe_display([
	'section' => Constants\ACF::BLOG_SETTINGS_BASE . '_blog_archive_blocks_grav_blocks',
	'object' => 'option'
]);

get_footer();
