<?php
use ClientNamespace\Components;
use WPUtil\{ Component, Vendor };

get_header();

Component::render(Components\Banners\BannerDefault::class, [
	'title' => 'Gravitate WordPress Theme'
]);

?>
<main class="tmpl-front-page">
	<?php
	Component::render(Components\Testing\ThemeWelcome::class);

	if (have_posts())
	{
		while (have_posts())
		{
			the_post();

			Vendor\BlueprintBlocks::safe_display();
		}
	}
	?>
</main>
<?php

get_footer();
