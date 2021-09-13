<?php
namespace ClientNamespace\Components\Banners\Partials;

use WPUtil\Interfaces\IComponent;
use WPUtil\Arrays;
use WPUtil\Vendor\ACF;

class BannerCoverVideo implements IComponent
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
	 * The ACF image object used as the video poster
	 *
	 * @var array<string, mixed>
	 */
	public array $video_poster_image = [];

	/**
	 * The video URL used on 'mobile' viewports
	 *
	 * @var string
	 */
	public string $video_url_mobile = '';

	/**
	 * The video URL used on 'tablet' viewports
	 *
	 * @var string
	 */
	public string $video_url_tablet = '';

	/**
	 * The video URL used on 'desktop' viewports
	 *
	 * @var string
	 */
	public string $video_url_desktop = '';

	/**
	 * Array of video and poster URLs for 'mobile', 'tablet', and 'desktop' viewports
	 *
	 * @var array<string, array<string, string>>
	 */
	public array $data_sizes = [];


	public function __construct(array $params)
	{
		$this->post_id = Arrays::get_value_as_int($params, 'post_id', fn () => get_the_ID());
		$this->acf_prefix = Arrays::get_value_as_string($params, 'acf_prefix', 'banner');

		$this->video_poster_image = Arrays::get_value_as_array(
			$params,
			'video_poster_image',
			fn () => ACF::get_field_array(
				$this->acf_prefix . '_background_video_poster',
				$this->post_id
			)
		);

		$this->video_url_mobile = Arrays::get_value_as_string(
			$params,
			'video_url_mobile',
			fn () => ACF::get_field_string(
				$this->acf_prefix . '_background_video_url_mobile',
				$this->post_id
			)
		);

		$this->video_url_tablet = Arrays::get_value_as_string(
			$params,
			'video_url_tablet',
			fn () => ACF::get_field_string(
				$this->acf_prefix . '_background_video_url_tablet',
				$this->post_id
			)
		);

		$this->video_url_desktop = Arrays::get_value_as_string(
			$params,
			'video_url_desktop',
			fn () => ACF::get_field_string(
				$this->acf_prefix . '_background_video_url_desktop',
				$this->post_id
			)
		);

		$this->data_sizes = [
			'mobile' => [
				'video_url' => $this->video_url_mobile,
				'poster_url' => $this->video_poster_image ? $this->video_poster_image['sizes']['medium'] : ''
			],
			'tablet' => [
				'video_url' => $this->video_url_tablet,
				'poster_url' => $this->video_poster_image ? $this->video_poster_image['sizes']['medium_large'] : ''
			],
			'desktop' => [
				'video_url' => $this->video_url_desktop,
				'poster_url' => $this->video_poster_image ? $this->video_poster_image['sizes']['large'] : ''
			],
		];
	}

	public function render(): void
	{
		?>
		<div class="banner__cover-video-container">
			<video class="banner__cover-video"
				data-video-mobile="<?php echo esc_attr($this->data_sizes['mobile']['video_url']); ?>"
				data-video-tablet="<?php echo esc_attr($this->data_sizes['tablet']['video_url']); ?>"
				data-video-desktop="<?php echo esc_attr($this->data_sizes['desktop']['video_url']); ?>"
				data-poster-mobile="<?php echo esc_attr($this->data_sizes['mobile']['poster_url']); ?>"
				data-poster-tablet="<?php echo esc_attr($this->data_sizes['tablet']['poster_url']); ?>"
				data-poster-desktop="<?php echo esc_attr($this->data_sizes['desktop']['poster_url']); ?>"
				autoplay muted loop playsinline preload="auto">
			</video>
		</div>
		<?php
	}
}
