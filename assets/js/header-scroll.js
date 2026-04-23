(function () {
	'use strict';

	var html = document.documentElement;
	var SCROLLED_CLASS = 'site-header--scrolled';
	var TOP_TOLERANCE = 12;
	var SCROLL_DELTA = 10;
	var MIN_Y_TO_HIDE = 56;

	var lastY = window.scrollY || 0;
	var raf = 0;

	function apply() {
		var y = window.scrollY || 0;

		if (y <= TOP_TOLERANCE) {
			html.classList.remove(SCROLLED_CLASS);
		} else if (y > MIN_Y_TO_HIDE) {
			if (y > lastY + SCROLL_DELTA) {
				html.classList.add(SCROLLED_CLASS);
			} else if (y < lastY - SCROLL_DELTA) {
				html.classList.remove(SCROLLED_CLASS);
			}
		}

		lastY = y;
	}

	function onScroll() {
		if (raf) {
			return;
		}
		raf = requestAnimationFrame(function () {
			raf = 0;
			apply();
		});
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', function () {
		lastY = window.scrollY || 0;
		apply();
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			lastY = window.scrollY || 0;
			apply();
		});
	} else {
		lastY = window.scrollY || 0;
		apply();
	}
})();
