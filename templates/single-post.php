<?php
get_header();

// WPUtil\Component::render('components/banners/banner-default');

?>
<main class="tmpl-single-post">
	<?php
	if (have_posts())
	{
		while (have_posts())
		{
			the_post();

			$featured_image = ClientNamespace\Posts::getFeaturedImageACFObject(get_the_ID());

			?>
			<div class="contain tmpl-single-post__container">
				<div class="tmpl-single-post__content wysiwyg">
					<h1 class="tmpl-single-post__post-title"><?php the_title(); ?></h1>
					<?php
					if ($featured_image)
					{
						echo Blueprint\Images::safe_image_output($featured_image, ['class' => 'tmpl-single-post__featured-image']);
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
						WPUtil\Component::render('components/ui/share-icon', [
							'site' => 'twitter',
							'twitter_username' => 'test_username'
						]);

						WPUtil\Component::render('components/ui/share-icon', [
							'site' => 'facebook'
						]);
						?>
					</div>
				</div>
			</div>
			<?php

			WPUtil\Vendor\BlueprintBlocks::safe_display();
		}

		WPUtil\Vendor\BlueprintBlocks::safe_display([
			'section' => ClientNamespace\Constants\ACF::BLOG_SETTINGS_BASE . '_blog_post_blocks_grav_blocks',
			'object' => 'option'
		]);
	}
	?>
</main>
<?php

get_footer();
