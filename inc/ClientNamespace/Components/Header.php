<?php
namespace ClientNamespace\Components;

use WPUtil\Interfaces\IComponent;
use WPUtil\Menus;
use ClientNamespace\Constants;

class Header implements IComponent
{
	public function __construct(array $params) {}

	public function render(): void
	{
		?>
		<header class="site-header">
			<div class="site-header__inner">
				<div class="site-header__logo-container">
					<a href="<?php echo esc_url(site_url()); ?>" title="<?php echo esc_attr(bloginfo('name')); ?>" aria-label="Home">
						<div class="site-header__logo">
							<img src="https://via.placeholder.com/200x80" alt="">
						</div>
					</a>
				</div>
				<div class="site-header__menu-container">
					<nav class="site-header__menu site-header__menu--primary">
						<?php Menus::display_for_location(Constants\Menus::DESKTOP_MENU, ['depth' => 1]); ?>
					</nav>
				</div>
			</div>
		</header>
		<button class="site-header__mobile-menu-button" type="button" aria-label="Menu">
			<span class="site-header__mobile-menu-button-box">
				<span class="site-header__mobile-menu-button-inner"></span>
			</span>
		</button>
		<div class="site-header__mobile-container">
			<nav class="site-header__mobile-menu site-header__mobile-menu--primary">
				<?php Menus::display_for_location(Constants\Menus::MOBILE_MENU, ['depth' => 1]); ?>
			</nav>
		</div>
		<?php
	}
}
