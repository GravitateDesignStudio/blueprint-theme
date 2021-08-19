<?php
use ClientNamespace\Constants;

get_header();

$title = get_field(Constants\ACF::THEME_OPTIONS_404_BASE . '_title', 'option');
$content = get_field(Constants\ACF::THEME_OPTIONS_404_BASE . '_content', 'option');

if (!$title) {
	$title = '404 - Not Found';
}

WPUtil\Component::render('components/banners/banner-default', [
	'title' => $title
]);

?>
<main class="tmpl-404">
	<?php
	if ($content)
	{
		?>
		<section class="block-container">
			<div class="block-inner contain layout__padded-single-col wysiwyg">
				<div class="tmpl-404__content">
					<?php
					// phpcs:ignore
					echo $content;
					?>
				</div>
			</div>
		</section>
		<?php
	}

	WPUtil\Vendor\BlueprintBlocks::safe_display([
		'section' => Constants\ACF::THEME_OPTIONS_404_BASE . '_404_blocks_grav_blocks',
		'object' => 'option'
	]);
	?>
</main>
<?php

get_footer();
