import ImageBuddy from 'imagebuddy';

import ThemeWelcome from './components/testing/theme-welcome';
import BannerVideo from './components/banner-video';
import Modal from './components/modal';

import PostsListBlog from './components/posts-list/posts-list-blog';
import PostsListSearch from './components/posts-list/posts-list-search';

import { processExternalLinks } from './util/general-util';
import ScrollWatcher from './util/scroll-watcher';
import SiteEvents, { SiteEventNames } from './util/site-events';
import { createSingleUseObserver } from './util/intersection-observer';
import { initHelloBar } from './util/hello-bar';

class App {
	constructor() {
		this.instances = {
			components: {
				themeWelcome: null,
				bannerVideo: null,
				postsListBlog: [],
				postsListSearch: []
			},
			templates: {},
			blocks: {},
			scrollWatcher: null,
			imageBuddy: null
		};

		this.init();
		this.initComponents();
		this.initTemplates();
		this.initBlocks();
		this.initSocialShare();
	}

	init() {
		processExternalLinks({
			target: '_blank',
			rel: 'noopener'
		});

		Modal.setDefaults({
			closeDuration: 400,
			closeButtonContent: `
				<svg xmlns="http://www.w3.org/2000/svg" class="modal__close-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			`.trim()
		});

		this.scrollWatcher = new ScrollWatcher((params) => {
			ScrollWatcher.defaultCallback(params, 100);
		});

		// mobile menu button handler
		const btnMobileMenu = document.querySelector('.site-header__mobile-menu-button');

		if (btnMobileMenu) {
			btnMobileMenu.addEventListener('click', () => {
				document.documentElement.classList.toggle('mobile-menu-active');
			});
		}

		// initialize ImageBuddy and setup events
		this.instances.imageBuddy = new ImageBuddy({
			lazyLoad: true
			// debug: true
		});

		SiteEvents.subscribe(SiteEventNames.IMAGEBUDDY_TRIGGER_UPDATE, (opts) => {
			this.instances.imageBuddy.update(opts || {});
		});

		initHelloBar((hbEl) => {
			document.body.style.marginTop = `${hbEl.offsetHeight}px`;

			const siteHeaderEl = document.querySelector('.site-header');

			if (siteHeaderEl) {
				siteHeaderEl.style.marginTop = `${hbEl.offsetHeight}px`;
			}
		});
	}

	async initComponents() {
		// theme welcome
		// TODO: remove during development
		const themeWelcomeEl = document.querySelector('.theme-welcome');

		if (themeWelcomeEl) {
			this.instances.themeWelcome = new ThemeWelcome(themeWelcomeEl);
		}

		// banner cover video
		const bannerCoverVideoEl = document.querySelector('.banner__cover-video');

		if (bannerCoverVideoEl) {
			this.instances.components.bannerVideo = new BannerVideo(bannerCoverVideoEl);
		}

		// posts list - blog
		Array.from(document.querySelectorAll('.posts-list--blog')).forEach((postsListBlogEl) => {
			this.instances.components.postsListBlog.push(new PostsListBlog(postsListBlogEl));
		});

		// posts list - search
		Array.from(document.querySelectorAll('.posts-list--search')).forEach(
			(postsListSearchEl) => {
				this.instances.components.postsListSearch.push(
					new PostsListSearch(postsListSearchEl)
				);
			}
		);
	}

	initTemplates() {
		// TODO: initialize templates here
	}

	initBlocks() {
		// TODO: initialize blocks here

		// setup block animation watchers
		const animateBlocks = document.querySelectorAll('.block-animate');

		if (animateBlocks && animateBlocks.length) {
			animateBlocks.forEach((watchEl) =>
				createSingleUseObserver(watchEl, (entry, el) => {
					el.classList.remove('block-animate');
				})
			);
		}
	}

	initSocialShare() {
		const socialShareEls = document.querySelectorAll('[data-social-share]');

		Array.from(socialShareEls).forEach((el) => {
			el.addEventListener('click', (e) => {
				const site = el.getAttribute('data-social-share');
				const shareUrl = el.getAttribute('href');

				e.preventDefault();

				if (!shareUrl) {
					return;
				}

				window.open(shareUrl, `${site}Share`, 'width=626,height=436');
			});
		});
	}
}

export default App;
