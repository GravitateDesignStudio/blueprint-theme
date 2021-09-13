<?php
namespace ClientNamespace\Components\UI;

use WPUtil\Interfaces\IComponent;
use WPUtil\SVG;

class PlayVideoOverlay implements IComponent
{
	public function __construct(array $params) {}

	public function render(): void
	{
		?>
		<div class="play-video-overlay">
			<span class="play-video-overlay__play-circle">
				<?php SVG::the_svg('general/play', ['class' => 'play-video-overlay__play-icon']); ?>
			</span>
		</div>
		<?php
	}
}
