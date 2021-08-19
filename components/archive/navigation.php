<?php
add_filter('next_posts_link_attributes', function ($atts) {
	return 'class="archive__navigation-link archive__navigation-link--prev button button--slim"';
});

add_filter('previous_posts_link_attributes', function ($atts) {
	return 'class="archive__navigation-link archive__navigation-link--next button button--slim"';
});

?>
<div class="archive__navigation contain">
	<div class="archive__navigation-link">
		&laquo; <?php next_posts_link(__('Older Entries', ClientNamespace\Constants\TextDomains::DEFAULT)); ?>
	</div>
	<div class="archive__navigation-link text-right">
		<?php previous_posts_link(__('Newer Entries', ClientNamespace\Constants\TextDomains::DEFAULT)); ?> &raquo;
	</div>
</div>
