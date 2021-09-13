<?php
namespace ClientNamespace\Components\Banners\Partials;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Component };
use WPUtil\Vendor\ACF;
use ClientNamespace\Components;

class BannerBackground implements IComponent
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
	 * The banner type name
	 *
	 * @var string
	 */
	public string $background_type = 'image';

	/**
	 * The banner background image
	 *
	 * @var null|string|integer|array<string, mixed>
	 */
	public $background_image = null;

	/**
	 * The banner background image horizontal position (0 - 100)
	 *
	 * @var int
	 */
	public int $background_image_pos_horz = 50;

	/**
	 * The banner background image vertical position (0 - 100)
	 *
	 * @var int
	 */
	public int $background_image_pos_vert = 50;


	public function __construct(array $params)
	{
		$this->post_id = Arrays::get_value_as_int($params, 'post_id', fn () => get_the_ID());
		$this->acf_prefix = Arrays::get_value_as_string($params, 'acf_prefix', 'banner');
		$this->background_type = Arrays::get_value_as_string(
			$params,
			'background_type',
			fn () => ACF::get_field_string(
				$this->acf_prefix . '_background_type',
				$this->post_id,
				['default' => 'image']
			)
		);

		if ($this->background_type === 'image') {
			$this->background_image = $params['background_image'] ?? ACF::get_field_array($this->acf_prefix . '_background_image', $this->post_id);

			if (!$this->background_image) {
				$this->background_image = ACF::get_featured_image_acf_object($this->post_id);
			}

			$this->background_image_pos_horz = Arrays::get_value_as_int(
				$params,
				'background_image_pos_horz',
				fn () => ACF::get_field_int(
					$this->acf_prefix . '_background_image_pos_horz',
					$this->post_id,
					['default' => 50]
				)
			);

			$this->background_image_pos_vert = Arrays::get_value_as_int(
				$params,
				'background_image_pos_vert',
				fn () => ACF::get_field_int(
					$this->acf_prefix . '_background_image_pos_vert',
					$this->post_id,
					['default' => 50]
				)
			);
		}
	}

	public function render(): void
	{
		if ($this->background_type === 'video') {
			Component::render(Components\Banners\Partials\BannerCoverVideo::class, [
				'post_id' => $this->post_id,
				'acf_prefix' => $this->acf_prefix
			]);
		} else {
			Component::render(Components\Banners\Partials\BannerCoverImage::class, [
				'acf_prefix' => $this->acf_prefix,
				'background_image' => $this->background_image,
				'pos_horz' => $this->background_image_pos_horz,
				'pos_vert' => $this->background_image_pos_vert
			]);
		}
	}
}
