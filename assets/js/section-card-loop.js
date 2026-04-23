/**
 * Card-loop carousels (.section-card-loop): paging, prev/next, responsive per-view.
 */
(function () {
	'use strict';

	function getTrackGapPx(trackEl) {
		if (!trackEl || typeof window.getComputedStyle !== 'function') {
			return 20;
		}
		var raw = window.getComputedStyle(trackEl).gap || '';
		var first = raw.split(/\s+/)[0] || '';
		var m = /^([\d.]+)px$/.exec(first);
		return m ? parseFloat(m[1], 10) : 20;
	}

	function getPerView(section) {
		var desktop = parseInt(section.getAttribute('data-per-view-desktop'), 10) || 3;
		var mobile = parseInt(section.getAttribute('data-per-view-mobile'), 10) || 1;
		if (window.matchMedia('(max-width: 1023px)').matches) {
			return Math.max(1, mobile);
		}
		return Math.max(1, desktop);
	}

	function padPage(n) {
		var s = String(n);
		return s.length < 2 ? '0' + s : s;
	}

	function initSection(section) {
		var viewport = section.querySelector('.section-card-loop__viewport');
		var track = section.querySelector('.section-card-loop__track');
		var prev = section.querySelector('.section-card-loop__arrow--prev');
		var next = section.querySelector('.section-card-loop__arrow--next');
		var curEl = section.querySelector('.section-card-loop__page-current');
		var totEl = section.querySelector('.section-card-loop__page-total');

		if (!viewport || !track || !prev || !next || !curEl || !totEl) {
			return;
		}

		var itemCount = track.querySelectorAll('.section-card-loop__card').length;
		if (itemCount === 0) {
			return;
		}

		var page = 0;

		function totalPages() {
			var pv = getPerView(section);
			return Math.max(1, Math.ceil(itemCount / pv));
		}

		function maxPage() {
			return totalPages() - 1;
		}

		function applySlotWidth() {
			var perView = getPerView(section);
			var w = viewport.clientWidth;
			var gapPx = getTrackGapPx(track);
			var slot = (w - gapPx * (perView - 1)) / perView;
			slot = Math.max(200, Math.floor(slot));
			section.style.setProperty('--card-loop-slot', slot + 'px');
		}

		function updateTransform() {
			applySlotWidth();
			var maxOffset = Math.max(0, track.scrollWidth - viewport.clientWidth);
			var ideal = page * viewport.clientWidth;
			var offset = Math.min(ideal, maxOffset);
			track.style.transform = 'translateX(-' + offset + 'px)';
		}

		function updateUI() {
			var tp = totalPages();
			totEl.textContent = padPage(tp);
			curEl.textContent = padPage(page + 1);
			prev.disabled = page <= 0;
			next.disabled = page >= maxPage();
			updateTransform();
		}

		prev.addEventListener('click', function () {
			if (page > 0) {
				page -= 1;
				updateUI();
			}
		});

		next.addEventListener('click', function () {
			if (page < maxPage()) {
				page += 1;
				updateUI();
			}
		});

		function onViewportChange() {
			page = Math.min(page, maxPage());
			updateUI();
		}

		if (typeof ResizeObserver !== 'undefined') {
			var ro = new ResizeObserver(onViewportChange);
			ro.observe(viewport);
		} else {
			window.addEventListener('resize', onViewportChange);
		}

		updateUI();
	}

	function boot() {
		document.querySelectorAll('.section-card-loop').forEach(initSection);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
