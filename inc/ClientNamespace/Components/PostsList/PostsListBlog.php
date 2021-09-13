<?php
namespace ClientNamespace\Components\PostsList;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Component, Taxonomy };
use WPUtil\Vendor\ACF;
use ClientNamespace\{ Components, Constants, CPT };

class PostsListBlog implements IComponent
{
	/**
	 * The WP_Query object
	 *
	 * @var WP_Query|null
	 */
	public $wp_query_obj = null;

	/**
	 * Flag indicating that the posts list will be displayed in a block. Adds the
	 * "posts-list--block" class to the container element.
	 */
	public bool $block_display = false;

	/**
	 * The current results page number
	 *
	 * @var int
	 */
	public int $current_page = 1;

	/**
	 * The message shown when there are no results to display
	 *
	 * @var string
	 */
	public string $no_results_message = '';


	public function __construct(array $params)
	{
		$this->wp_query_obj = isset($params['wp_query_obj']) && is_a($params['wp_query_obj'], 'WP_Query') ? $params['wp_query_obj'] : null;
		$this->block_display = Arrays::get_value_as_bool($params, 'block_display');
		$this->current_page = Arrays::get_value_as_int($params, 'current_page', 1);
		$this->no_results_message = Arrays::get_value_as_string($params, 'no_results_message', function () {
			return ACF::get_field_string(
				Constants\ACF::BLOG_SETTINGS_BASE . '_no_results_message',
				'option',
				[
					'default' => Constants\DefaultValues::ARCHIVE_NO_RESULTS_MESSAGE
				]
			);
		});
	}

	public function render(): void
	{
		Component::render(Components\PostsList\PostsList::class, [
			'wp_query_obj' => $this->wp_query_obj,
			'card_component' => Components\Cards\CardBlog::class,
			'block_display' => $this->block_display,
			'featured_ids' => CPT\Blog::getFeaturedIds(),
			'add_container_classes' => ['posts-list--blog'],
			'current_page' => $this->current_page,
			'no_results_message' => $this->no_results_message,
			'featured_render_params_callback' => function ($params, $post_id) {
				$params['category'] = CPT\Blog::getPostCategoryText($post_id);
				$params['default_image'] = CPT\Blog::getDefaultCardImage();

				return $params;
			},
			'card_render_params_callback' => function ($params, $post_id) {
				$params['category'] = CPT\Blog::getPostCategoryText($post_id);
				$params['default_image'] = CPT\Blog::getDefaultCardImage();

				return $params;
			},
			'filter_render_functions' => [
				// search
				function () {
					$cur_search = $_GET[Constants\QueryParams::BLOG_ARCHIVE_FILTER_SEARCH] ?? '';

					?>
					<label for="filter_search"><?php echo __('Search', Constants\TextDomains::DEFAULT); ?></label>
					<?php
					Component::render(Components\UI\InputWithIcon::class, [
						'is_form' => true,
						'add_container_attrs' => [
							'id' => 'form_filter_search'
						],
						'add_container_classes' => [
							'posts-list__filter-search'
						],
						'add_input_attrs' => [
							'id' => 'filter_search',
							'name' => 'filter_search',
							'placeholder' => __('Enter Keyword', Constants\TextDomains::DEFAULT),
							'value' => $cur_search
						],
						'add_icon_container_attrs' => [
							'aria-label' => __('Search', Constants\TextDomains::DEFAULT)
						],
					]);
				},
				// category
				function () {
					$cur_category = $_GET[Constants\QueryParams::BLOG_ARCHIVE_FILTER_CATEGORY] ?? '';

					$options = Taxonomy::get_taxonomy_filter_options(
						Constants\Taxonomies::BLOG_CATEGORY
					);

					?>
					<label for="filter_category"><?php echo __('Category', Constants\TextDomains::DEFAULT); ?></label>
					<select class="posts-list__filter-select" name="filter_category" id="filter_category">
						<option value=""><?php echo __('All Categories', Constants\TextDomains::DEFAULT); ?></option>
						<?php
						foreach ($options as $option)
						{
							echo $option->render($cur_category);
						}
						?>
					</select>
					<?php
				},
				// tag
				function () {
					$cur_tag = $_GET[Constants\QueryParams::BLOG_ARCHIVE_FILTER_TAG] ?? '';

					$options = Taxonomy::get_taxonomy_filter_options(
						Constants\Taxonomies::BLOG_TAG
					);

					?>
					<label for="filter_tag"><?php echo __('Tag', Constants\TextDomains::DEFAULT); ?></label>
					<select class="posts-list__filter-select" name="filter_tag" id="filter_tag">
						<option value=""><?php echo __('All Tags', Constants\TextDomains::DEFAULT); ?></option>
						<?php
						foreach ($options as $option)
						{
							echo $option->render($cur_tag);
						}
						?>
					</select>
					<?php
				}
			]
		]);
	}
}
