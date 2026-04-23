/**
 * Property detail: gallery mains + expanded grid, pricing toggles, FAQ read more.
 */
(function () {
	'use strict';

	function parseGalleryJson() {
		var el = document.getElementById('property-detail-gallery-json');
		if (!el || !el.textContent) {
			return [];
		}
		try {
			var data = JSON.parse(el.textContent);
			return Array.isArray(data) ? data : [];
		} catch (e) {
			return [];
		}
	}

	function initGallery() {
		var root = document.getElementById('property-detail-gallery');
		if (!root) {
			return;
		}
		var images = parseGalleryJson();
		if (images.length === 0) {
			return;
		}
		var main0 = document.getElementById('property-detail-main-0');
		var main1 = document.getElementById('property-detail-main-1');
		var thumbs = root.querySelectorAll('.property-detail__gallery-thumb');
		var expanded = document.getElementById('property-detail-gallery-expanded');
		var toggleBtn = document.getElementById('property-detail-view-all-photos');

		function setMains(index) {
			var i = Math.max(0, Math.min(index, images.length - 1));
			var j = i + 1 < images.length ? i + 1 : 0;
			if (main0 && images[i]) {
				main0.src = images[i].url;
				main0.alt = images[i].alt || '';
			}
			if (main1 && images[j]) {
				main1.src = images[j].url;
				main1.alt = images[j].alt || '';
			}
			thumbs.forEach(function (btn, idx) {
				var on = parseInt(btn.getAttribute('data-gallery-index'), 10) === i;
				btn.classList.toggle('is-active', on);
				btn.setAttribute('aria-selected', on ? 'true' : 'false');
			});
		}

		thumbs.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var idx = parseInt(btn.getAttribute('data-gallery-index'), 10);
				if (!isNaN(idx)) {
					setMains(idx);
				}
			});
		});

		if (toggleBtn && expanded) {
			toggleBtn.addEventListener('click', function () {
				var isOpen = !expanded.hasAttribute('hidden');
				if (isOpen) {
					expanded.setAttribute('hidden', 'hidden');
					toggleBtn.setAttribute('aria-expanded', 'false');
				} else {
					expanded.removeAttribute('hidden');
					toggleBtn.setAttribute('aria-expanded', 'true');
				}
			});
		}
	}

	function initPricingToggles() {
		document.querySelectorAll('.property-detail__pricing-toggle').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var id = btn.getAttribute('data-pricing-card');
				if (!id) {
					return;
				}
				var card = document.getElementById(id);
				if (!card) {
					return;
				}
				var extras = card.querySelectorAll('.property-detail__pricing-fee--extra');
				var expanded = btn.getAttribute('aria-expanded') === 'true';
				var next = !expanded;
				extras.forEach(function (row) {
					if (next) {
						row.removeAttribute('hidden');
					} else {
						row.setAttribute('hidden', 'hidden');
					}
				});
				btn.setAttribute('aria-expanded', next ? 'true' : 'false');
			});
		});
	}

	function initFaqMore() {
		document.querySelectorAll('.property-detail__faq-more').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var id = btn.getAttribute('data-faq-target');
				if (!id) {
					return;
				}
				var card = document.getElementById(id);
				if (!card) {
					return;
				}
				var ans = card.querySelector('.property-detail__faq-answer');
				var ex = card.querySelector('.property-detail__faq-excerpt');
				if (!ans) {
					return;
				}
				var open = btn.getAttribute('aria-expanded') === 'true';
				if (open) {
					ans.setAttribute('hidden', 'hidden');
					if (ex) {
						ex.removeAttribute('hidden');
					}
					btn.setAttribute('aria-expanded', 'false');
				} else {
					ans.removeAttribute('hidden');
					if (ex) {
						ex.setAttribute('hidden', 'hidden');
					}
					btn.setAttribute('aria-expanded', 'true');
				}
			});
		});
	}

	function boot() {
		initGallery();
		initPricingToggles();
		initFaqMore();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
