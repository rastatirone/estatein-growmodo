(function () {
	'use strict';

	var bar = document.getElementById('promo-announcement');
	if (!bar) {
		return;
	}

	var btn = bar.querySelector('.announcement-bar__close');
	if (!btn) {
		return;
	}

	btn.addEventListener('click', function () {
		try {
			localStorage.setItem('estatein_promo_banner_dismissed', '1');
		} catch (e) {
			// Private mode or blocked storage.
		}
		document.documentElement.classList.add('promo-banner-dismissed');
		bar.setAttribute('hidden', 'hidden');
		bar.setAttribute('aria-hidden', 'true');
	});
})();
