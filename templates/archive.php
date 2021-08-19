<?php
get_header();

WPUtil\Component::render('components/banners/banner-default', [
	'title' => Blueprint\Archives::get_title()
]);

?>
<main class="tmpl-archive">
	<?php
	if (have_posts())
	{
		?>
		<div class="contain tmpl-archive__cards-container">
			<?php
			while (have_posts())
			{
				the_post();

				WPUtil\Component::render('components/cards/card-search');
			}
			?>
		</div>
		<?php

		WPUtil\Component::render('components/archive/navigation');
	}
	else
	{
		?>
		<div class="contain layout__padded-single-col">
			<p>No posts were found</p>
		</div>
		<?php
	}
	?>
</main>
<?php

get_footer();
