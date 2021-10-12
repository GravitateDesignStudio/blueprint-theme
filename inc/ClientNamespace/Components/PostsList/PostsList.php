<?php
namespace ClientNamespace\Components\PostsList;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Component };
use ClientNamespace\Components;

class PostsList implements IComponent
{
	/**
	 * The WP_Query object
	 *
	 * @var WP_Query|null
	 */
	public $wp_query_obj = null;

	/**
	 * The card component. This can referencing either a component file or a the
	 * name of a class component that extends IComponent.
	 *
	 * @var string
	 */
	public string $card_component = '';

	/**
	 * Flag indicating that the posts list will be displayed in a block. Adds the
	 * "posts-list--block" class to the container element.
	 */
	public bool $block_display = false;

	/**
	 * Array of featured post ids
	 *
	 * @var array<int>
	 */
	public array $featured_ids = [];

	/**
	 * Array of class strings that will be added to the container element
	 *
	 * @var array<string>
	 */
	public array $add_container_classes = [];

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

	/**
	 * Callback function used to modify the featured post card parameters
	 *
	 * @var callable|null
	 */
	public $featured_render_params_callback = null;

	/**
	 * Callback function used to modify the post card parameters
	 *
	 * @var callable|null
	 */
	public $card_render_params_callback = null;

	/**
	 * Callback function that is run prior to the output of each card column
	 *
	 * @var callable|null
	 */
	public $pre_card_column_callback = null;

	/**
	 * Array of callable functions that are used to build the filter sections
	 *
	 * @var array<callable>
	 */
	public $filter_render_functions = [];


	public function __construct(array $params)
	{
		$this->wp_query_obj = isset($params['wp_query_obj']) && is_a($params['wp_query_obj'], 'WP_Query') ? $params['wp_query_obj'] : null;
		$this->card_component = Arrays::get_value_as_string($params, 'card_component');
		$this->block_display = Arrays::get_value_as_bool($params, 'block_display');
		$this->featured_ids = Arrays::get_value_as_array($params, 'featured_ids');
		$this->add_container_classes = Arrays::get_value_as_array($params, 'add_container_classes');
		$this->current_page = Arrays::get_value_as_int($params, 'current_page', 1);
		$this->no_results_message = Arrays::get_value_as_string($params, 'no_results_message');

		$this->featured_render_params_callback = isset($params['featured_render_params_callback']) && is_callable($params['featured_render_params_callback']) ?
			$params['featured_render_params_callback'] :
			null;

		$this->card_render_params_callback = isset($params['card_render_params_callback']) && is_callable($params['card_render_params_callback']) ?
			$params['card_render_params_callback'] :
			null;

		$this->pre_card_column_callback = isset($params['pre_card_column_callback']) && is_callable($params['pre_card_column_callback']) ?
			$params['pre_card_column_callback'] :
			null;

		$this->filter_render_functions = Arrays::get_value_as_array($params, 'filter_render_functions');
	}

	public function render(): void
	{
		if (!$this->wp_query_obj || !$this->card_component) {
			return;
		}

		$container_classes = array_merge(['posts-list', 'contain'], $this->add_container_classes);

		if ($this->block_display) {
			$container_classes[] = 'posts-list--block';
		}

		?>
		<div class="<?php echo esc_attr(implode(' ', $container_classes)); ?>">
			<?php
			if ($this->featured_ids)
			{
				?>
				<div class="posts-list__row-featured">
					<?php
					foreach ($this->featured_ids as $featured_id)
					{
						$params = [
							'post_id' => $featured_id,
							'is_large' => true
						];

						if (is_callable($this->featured_render_params_callback)) {
							$func = $this->featured_render_params_callback;
							$params = $func($params, $featured_id);
						}

						Component::render($this->card_component, $params);
					}
					?>
				</div>
				<?php
			}

			if ($this->filter_render_functions)
			{
				?>
				<div class="posts-list__row-filters">
					<?php
					foreach ($this->filter_render_functions as $filter_render_func)
					{
						?>
						<div class="posts-list__filter">
							<?php
							if (is_callable($filter_render_func))
							{
								$filter_render_func();
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}

			$total_pages = intval($this->wp_query_obj->max_num_pages ?? 1);
			$posts_per_page = intval($this->wp_query_obj->query_vars['posts_per_page'] ?? get_option('posts_per_page'));

			$no_results_classes = [
				'posts-list__no-results-container',
				'layout__padded-columns',
				'text-center'
			];

			if ($this->wp_query_obj->posts) {
				$no_results_classes[] = 'hide';
			}

			?>
			<div class="posts-list__cards-container"
				data-load-more-target
				data-current-page="<?php echo esc_attr($this->current_page); ?>"
				data-total-pages="<?php echo esc_attr($total_pages); ?>"
				data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
				>
				<?php
				foreach ($this->wp_query_obj->posts as $cur_index => $cur_post)
				{
					if (is_callable($this->pre_card_column_callback)) {
						$func = $this->pre_card_column_callback;
						$func($cur_index, $cur_post->ID);
					}

					$params = [
						'post_id' => $cur_post->ID
					];

					if (is_callable($this->card_render_params_callback)) {
						$func = $this->card_render_params_callback;
						$params = $func($params, $cur_post->ID);
					}

					Component::render($this->card_component, $params);
				}
				?>
			</div>
			<div class="<?php echo esc_attr(implode(' ', $no_results_classes)); ?>" data-no-results-container>
				<h4><?php echo esc_html($this->no_results_message); ?></h4>
			</div>
			<div class="posts-list__loader-container hide">
				<span class="posts-list__loader-spinner"></span>
			</div>
			<?php Component::render(Components\Archive\LoadMore::class); ?>
		</div>
		<?php
	}
}