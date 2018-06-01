/* global jQuery */

import Swiper from 'swiper';
import objectFitImages from 'object-fit-images';
import gravUtil from './util/grav-util';
import ThemeWelcome from './components/testing/theme-welcome';
import SiteHeader from './components/site-header';

const instances = {
	components: {
		themeWelcome: null,
		siteHeader: null
	}
};

jQuery(function ($) {
	/**
	 * Place items in here to have them run after the Dom is ready
	 */
	$(document).ready(function () {
		gravUtil.filterLinks();
		gravUtil.setHeightVars();
		gravUtil.setScrollVars();
		gravUtil.updateScrollClasses(100);

		/**
		 * Initialize components
		 */
		// theme welcome -- this can be removed during development
		const $themeWelcomeEls = $('.theme-welcome');

		if ($themeWelcomeEls.length) {
			instances.themeWelcome = new ThemeWelcome($themeWelcomeEls.first());
		}

		// site header
		const $siteHeaderEls = $('.site-header');

		if ($siteHeaderEls.length) {
			instances.components.siteHeader = new SiteHeader($siteHeaderEls.first());
		}

		$('.block-image-gallery .swiper-container').each(function(index){
			var block_index = $(this).closest('.block-container').attr('data-block-index');
			var prev = $(this).find('.swiper-button-prev');
			var next = $(this).find('.swiper-button-next');
			var pagination = $(this).find('.swiper-pagination');
			var swiperImageGallery = new Swiper($(this), {
				loop: true,
				autoHeight: true,
				slidesPerView: 1,
				observer: true,
				navigation: {
					nextEl: next,
					prevEl: prev,
				},
				pagination: {
					el: pagination,
					type: 'bullets',
					clickable: true,
				},
			});
		});

		$('.block-testimonials .swiper-container').each(function(index){
			var block_index = $(this).closest('.block-container').attr('data-block-index');
			var prev = $(this).find('.swiper-button-prev');
			var next = $(this).find('.swiper-button-next');
			var pagination = $(this).find('.swiper-pagination');
			var swiperTestimonials = new Swiper($(this), {
				loop: true,
				autoHeight: true,
				slidesPerView: 1,
				observer: true,
				navigation: {
					nextEl: next,
					prevEl: prev,
				},
				pagination: {
					el: pagination,
					type: 'bullets',
					clickable: true,
				},
			});
		});

		objectFitImages();
	});

	/**
	 * Place items in here to have them run the page is loaded
	 */
	$(window).load(function () {
	});

	/**
	 * Place items in here to have them run when the window is scrolled
	 */
	$(window).scroll(function () {
		gravUtil.setScrollVars();
		gravUtil.updateScrollClasses(100);
	});

	/**
	 * Place items in here to have them run when the window is resized
	 */
	$(window).resize(function () {
	});
});
