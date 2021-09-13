<?php
namespace ClientNamespace\Components\Banners\Partials;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Util };
use WPUtil\Vendor\ACF;
use Blueprint\Images;

class BannerCoverImage implements IComponent
{
	/**
	 * ACF field prefix
	 *
	 * @var string
	 */
	public string $acf_prefix = 'banner';

	/**
	 * The banner background image
	 *
	 * @var null|string|integer|array<string, mixed>
	 */
	public $background_image = null;

	/**
	 * The background image opacity
	 *
	 * @var int
	 */
	public int $opacity = 0;

	/**
	 * The banner background image horizontal position (0 - 100)
	 *
	 * @var int
	 */
	public int $pos_horz = 50;

	/**
	 * The banner background image vertical position (0 - 100)
	 *
	 * @var int
	 */
	public int $pos_vert = 50;


	public function __construct(array $params)
	{
		$this->acf_prefix = Arrays::get_value_as_string($params, 'acf_prefix', 'banner');
		$this->background_image = $params['background_image'] ?? null;
		$this->opacity = Arrays::get_value_as_int($params, 'opacity');
		$this->pos_horz = Arrays::get_value_as_int($params, 'pos_horz', 50);
		$this->pos_vert = Arrays::get_value_as_int($params, 'pos_vert', 50);
	}

	public function render(): void
	{
		if (!$this->background_image) {
			return;
		}

		$container_attrs = [
			'class' => 'banner__cover-image-container'
		];

		if ($this->opacity) {
			$container_attrs['data-opacity'] = $this->opacity;
		}

		?>
		<div <?php echo Util::attributes_array_to_string($container_attrs); ?>>
			<?php
			Images::safe_image_output($this->background_image, [
				'class' => 'banner__cover-image ib__image--no-fx',
				'style' => "object-position: {$this->pos_horz}% {$this->pos_vert}%;"
			]);
			?>
		</div>
		<?php
	}
}
