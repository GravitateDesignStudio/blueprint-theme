<?php
use ClientNamespace\{ Components, Constants };
use WPUtil\{ Component, Vendor };

get_header();

Component::render(Components\Banners\BannerDefault::class, [
	'title' => 'Search Results'
]);

?>
<main class="tmpl-search">
	<?php
	global $wp_query;

	Component::render(Components\PostsList\PostsListSearch::class, [
		'wp_query_obj' => $wp_query
	]);
	?>
</main>
<?php

Vendor\BlueprintBlocks::safe_display([
	'section' => Constants\ACF::THEME_OPTIONS_SEARCH_BASE . '_search_archive_blocks_grav_blocks',
	'object' => 'option'
]);

get_footer();
