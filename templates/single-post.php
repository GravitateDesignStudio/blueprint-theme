<?php
use ClientNamespace\{ Components, Constants, Posts };
use Blueprint\Images;
use WPUtil\{ Component, Vendor };

get_header();

?>
<main class="tmpl-single-post">
	<?php
	if (have_posts())
	{
		while (have_posts())
		{
			the_post();

			$featured_image = Posts::getFeaturedImageACFObject(get_the_ID());

			?>
			<div class="contain tmpl-single-post__container">
				<div class="tmpl-single-post__content wysiwyg">
					<h1 class="tmpl-single-post__post-title"><?php the_title(); ?></h1>
					<?php
					if ($featured_image)
					{
						echo Images::safe_image_output($featured_image, ['class' => 'tmpl-single-post__featured-image']);
					}
					?>
					<span class="tmpl-single-post__post-author">by <?php the_author(); ?></span>
					<span class="tmpl-single-post__post-date"><?php the_time('M. jS, Y'); ?></span>
					<div class="tmpl-single-post__post-content">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="tmpl-single-post__share-icons">
					<div class="tmpl-single-post__share-icons-inner">
						<?php
						Component::render(Components\UI\ShareIcon::class, [
							'site' => 'Twitter'
						]);

						Component::render(Components\UI\ShareIcon::class, [
							'site' => 'Facebook'
						]);
						?>
					</div>
				</div>
			</div>
			<?php

			Vendor\BlueprintBlocks::safe_display();
		}

		Vendor\BlueprintBlocks::safe_display([
			'section' => Constants\ACF::BLOG_SETTINGS_BASE . '_blog_post_blocks_grav_blocks',
			'object' => 'option'
		]);
	}
	?>
</main>
<?php

get_footer();
