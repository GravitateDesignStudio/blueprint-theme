export function isMobileViewport() {
	return (
		window.innerWidth <
		parseInt(getComputedStyle(document.documentElement).getPropertyValue('--bp-medium'), 10)
	);
}

export function isTabletViewport() {
	return (
		window.innerWidth >=
			parseInt(
				getComputedStyle(document.documentElement).getPropertyValue('--bp-medium'),
				10
			) &&
		window.innerWidth <
			parseInt(getComputedStyle(document.documentElement).getPropertyValue('--bp-large'), 10)
	);
}

export function isDesktopViewport() {
	return (
		window.innerWidth >=
		parseInt(getComputedStyle(document.documentElement).getPropertyValue('--bp-large'), 10)
	);
}
