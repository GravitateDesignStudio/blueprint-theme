<?php
namespace ClientNamespace\Components;

use WPUtil\Interfaces\IComponent;
use WPUtil\{ Arrays, Menus, SVG };
use WPUtil\Vendor\ACF;
use ClientNamespace\Constants;

class Footer implements IComponent
{
	public string $copyright_text = '';
	public array $social_links = [];

	public function __construct(array $params)
	{
		$this->copyright_text = Arrays::get_value_as_string(
			$params,
			'copyright_text',
			fn () => ACF::get_field_string(Constants\ACF::THEME_OPTIONS_FOOTER_BASE . '_copyright_text', 'option')
		);

		$this->social_links = array_filter(
			ACF::get_field_array(Constants\ACF::THEME_OPTIONS_SOCIAL_BASE . '_site_links', 'option'),
			fn ($icon) => $icon['title'] && $icon['url'] && $icon['icon']
		);
	}

	public function render(): void
	{
		?>
		<footer class="site-footer bg-black">
			<div class="contain site-footer__inner">
				<nav class="site-footer__menu site-footer__menu--primary">
					<?php Menus::display_for_location(Constants\Menus::FOOTER_LINKS_MENU, ['depth' => 1]); ?>
				</nav>
				<div class="site-footer__social-links">
					<?php
					foreach ($this->social_links as $social_link) {
						?>
						<a href="<?php echo esc_attr($social_link['url']); ?>"
							class="site-footer__social-link"
							rel="external noopener nofollow"
							target="_blank"
							title="<?php echo esc_attr($social_link['title']); ?>">
							<span class="site-footer__social-icon">
								<?php SVG::the_svg($social_link['icon']); ?>
							</span>
						</a>
						<?php
					}
					?>
				</div>
				<div class="site-footer__legal">
					<p class="site-footer__copyright">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($this->copyright_text); ?></p>
					<nav class="site-footer__menu site-footer__menu--secondary">
						<?php Menus::display_for_location(Constants\Menus::FOOTER_LEGAL_MENU, ['depth' => 1]); ?>
					</nav>
				</div>
			</div>
		</footer>

		<?php
	}
}
