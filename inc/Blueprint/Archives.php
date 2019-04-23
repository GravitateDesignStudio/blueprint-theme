<?php
namespace Blueprint;

abstract class Archives
{
	public static function get_title($queried_object = null)
	{
		if (!$queried_object) {
			$queried_object = get_queried_object();
		}

		$title_prefix = '';
		$title = '';
	
		if (is_category()) {
			$title_prefix = __('Posts Categorized:');
			$title = single_cat_title('', false);
		} else if (is_tag()) {
			$title_prefix = __('Posts Tagged:');
			$title = single_tag_title('', false);
		} else if (is_author()) {
			$title_prefix = __('Posts By:');
			$title = get_the_author_meta('display_name');
		} else if (is_day()) {
			$title_prefix = __('Daily Archives:');
			$title = get_the_time('l, F j, Y');
		} else if (is_month()) {
			$title_prefix = __('Monthly Archives:');
			$title = get_the_time('F Y');
		} else if (is_year()) {
			$title_prefix = __('Yearly Archives:');
			$title = get_the_time('Y');
		} else {
			$title = $queried_object->label ?? '';
		}
	
		$formatted_title = $title;
	
		if ($title_prefix) {
			$formatted_title = '<span class="archive__title-prefix>'.$title_prefix.'</span> '.$title;
		}
	
		return $formatted_title;
	}
}