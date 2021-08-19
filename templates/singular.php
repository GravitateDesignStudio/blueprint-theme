<?php
get_header();

WPUtil\Component::render('components/banners/banner-default');

?>
<main class="tmpl-singular tmpl-singular--<?php echo esc_attr(get_post_type()); ?>">
	<?php
	if (have_posts())
	{
		while (have_posts())
		{
			the_post();

			if (get_the_content())
			{
				?>
				<section class="contain layout__padded-single-col">
					<div class="tmpl-singular__content wysiwyg">
						<?php the_content(); ?>
					</div>
				</section>
				<?php
			}

			WPUtil\Vendor\BlueprintBlocks::safe_display();
		}
	}
	?>
</main>
<?php

get_footer();
