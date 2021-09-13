<?php
namespace ClientNamespace\Components\Cards;

use WPUtil\Interfaces\IComponent;
use WPUtil\Arrays;
use Blueprint\Images;

class CardBlog implements IComponent
{
	/**
	 * The post id
	 *
	 * @var integer
	 */
	public int $post_id = 0;

	/**
	 * The post category
	 *
	 * @var string
	 */
	public string $category = '';

	/**
	 * The post title
	 *
	 * @var string
	 */
	public string $title = '';

	/**
	 * The card content text
	 *
	 * @var string
	 */
	public string $content = '';

	/**
	 * The post permalink
	 *
	 * @var string
	 */
	public string $permalink = '';

	/**
	 * The post featured image
	 *
	 * @var null|string|integer|array<string, mixed>
	 */
	public $image = null;


	public function __construct(array $params)
	{
		$this->post_id = Arrays::get_value_as_int($params, 'post_id', fn () => get_the_ID());
		$this->category = Arrays::get_value_as_string($params, 'category');
		$this->title = Arrays::get_value_as_string($params, 'title', fn () => get_the_title($this->post_id));
		$this->content = Arrays::get_value_as_string($params, 'content');
		$this->permalink = Arrays::get_value_as_string($params, 'permalink', fn () => get_the_permalink($this->post_id));
		$this->image = $this->image ?? get_post_thumbnail_id($this->post_id);

		if (!$this->image) {
			$this->image = $params['default_image'] ?? null;
		}
	}

	public function render(): void
	{
		?>
		<a class="card-blog" href="<?php echo esc_url($this->permalink); ?>">
			<?php
			if ($this->image) {
				?>
				<div class="card-blog__image-container">
					<?php Images::safe_image_output($this->image, ['class' => 'card-blog__image']); ?>
				</div>
				<?php
			}
			?>
			<div class="card-blog__content-container">
				<h6 class="card-blog__category"><?php echo esc_html($this->category); ?></h6>
				<h3 class="card-blog__title"><?php echo esc_html($this->title); ?></h3>
				<div class="card-blog__content">
					<?php
					// phpcs:ignore
					echo $this->content;
					?>
				</div>
			</div>
		</a>
		<?php
	}
}
