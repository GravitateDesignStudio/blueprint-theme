<?php
namespace ClientNamespace\Components\Banners;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Component, Vendor };
use WPUtil\Vendor\ACF;
use WPUtil\Models\BlueprintBlocksLink;
use ClientNamespace\Components;

class BannerDefault implements IComponent
{
	/**
	 * The post id used to source banner settings from
	 *
	 * @var integer
	 */
	public int $post_id = 0;

	/**
	 * ACF field prefix
	 *
	 * @var string
	 */
	public string $acf_prefix = 'banner';

	/**
	 * The banner title
	 *
	 * @var string
	 */
	public string $title = '';

	/**
	 * The link button used in the banner
	 *
	 * @var \WPUtil\Models\BlueprintBlocksLink
	 */
	public BlueprintBlocksLink $button;

	/**
	 * The banner background image
	 *
	 * @var null|string|integer|array<string, mixed>
	 */
	public $background_image = null;

	/**
	 * Options array used when rendering the background image
	 *
	 * @var array<string, mixed>
	 */
	public $background_image_opts = [];


	public function __construct(array $params)
	{
		$this->post_id = Arrays::get_value_as_int($params, 'post_id', fn () => get_the_ID());
		$this->acf_prefix = Arrays::get_value_as_string($params, 'acf_prefix', 'banner');
		$this->title = Arrays::get_value_as_string($params, 'title', function () {
			$title_override = ACF::get_field_string($this->acf_prefix . '_title_override', $this->post_id);

			return trim($title_override) ? trim($title_override) : get_the_title($this->post_id);
		});

		$this->button = isset($params['button']) && is_a($params['button'], 'WPUtil\Models\BlueprintBlocksLink') ?
			$params['button'] :
			Vendor\BlueprintBlocks::get_button_field_values($this->acf_prefix . '_button', $this->post_id);

		$this->background_image = $params['background_image'] ?? ACF::get_field_array($this->acf_prefix . '_background_image', $this->post_id);

		if (!$this->background_image) {
			$this->background_image = ACF::get_featured_image_acf_object($this->post_id);
		}

		$this->background_image_opts = ['post_id' => $this->post_id];

		if ($this->background_image) {
			$background_image_opts['background_image'] = $this->background_image;
		}
	}

	public function render(): void
	{
		?>
		<div class="banner banner-default bg-black">
			<?php Component::render(Components\Banners\Partials\BannerBackground::class, $this->background_image_opts); ?>
			<div class="banner-default__content contain">
				<h1 class="banner-default__title"><?php echo esc_html($this->title); ?></h1>
				<?php
				if ($this->button->link && $this->button->text)
				{
					?>
					<a href="<?php echo esc_url($this->button->link); ?>" class="button banner-default__button"><?php echo esc_html($this->button->text); ?></a>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
}
