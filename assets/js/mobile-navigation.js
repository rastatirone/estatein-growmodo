(function () {

	'use strict';



	var root = document.getElementById('mobile-navigation');

	var toggle = document.getElementById('mobile-menu-toggle');

	if (!root || !toggle) {

		return;

	}



	var backdrop = root.querySelector('.mobile-navigation__backdrop');

	var closeBtn = root.querySelector('.mobile-navigation__close');

	var panel = root.querySelector('.mobile-navigation__panel');

	var mq = window.matchMedia('(min-width: 1024px)');

	var closeFallbackTimer = null;

	var OPEN_CLASS = 'mobile-navigation--open';



	function clearCloseTimer() {

		if (closeFallbackTimer) {

			clearTimeout(closeFallbackTimer);

			closeFallbackTimer = null;

		}

	}



	function isOpen() {

		return root.classList.contains(OPEN_CLASS);

	}



	function finishClose() {

		document.body.classList.remove('mobile-nav-open');

		toggle.focus();

		clearCloseTimer();

		if (panel) {

			panel.removeEventListener('transitionend', onPanelTransitionEnd);

		}

	}



	function onPanelTransitionEnd(e) {

		if (!panel || e.target !== panel) {

			return;

		}

		if (e.propertyName !== 'transform' && e.propertyName !== '-webkit-transform') {

			return;

		}

		finishClose();

	}



	function openMenu() {

		root.removeAttribute('hidden');

		if (panel) {

			panel.removeEventListener('transitionend', onPanelTransitionEnd);

		}

		clearCloseTimer();

		root.classList.add(OPEN_CLASS);

		root.setAttribute('aria-hidden', 'false');

		toggle.setAttribute('aria-expanded', 'true');

		document.body.classList.add('mobile-nav-open');

		if (closeBtn) {

			closeBtn.focus();

		}

	}



	function closeMenu() {

		if (!root.classList.contains(OPEN_CLASS)) {

			return;

		}

		root.classList.remove(OPEN_CLASS);

		root.setAttribute('aria-hidden', 'true');

		toggle.setAttribute('aria-expanded', 'false');

		if (panel) {

			panel.removeEventListener('transitionend', onPanelTransitionEnd);

			panel.addEventListener('transitionend', onPanelTransitionEnd);

		}

		clearCloseTimer();

		closeFallbackTimer = setTimeout(finishClose, 450);

	}



	function onToggleClick(e) {

		e.preventDefault();

		if (isOpen()) {

			closeMenu();

		} else {

			openMenu();

		}

	}



	function onBackdropClick() {

		if (isOpen()) {

			closeMenu();

		}

	}



	function onKeydown(e) {

		if (e.key === 'Escape' && isOpen()) {

			closeMenu();

		}

	}



	function onMqChange() {

		if (mq.matches && isOpen()) {

			if (panel) {

				panel.removeEventListener('transitionend', onPanelTransitionEnd);

			}

			clearCloseTimer();

			root.classList.remove(OPEN_CLASS);

			root.setAttribute('aria-hidden', 'true');

			toggle.setAttribute('aria-expanded', 'false');

			document.body.classList.remove('mobile-nav-open');

		}

	}



	toggle.addEventListener('click', onToggleClick);

	if (backdrop) {

		backdrop.addEventListener('click', onBackdropClick);

	}

	if (closeBtn) {

		closeBtn.addEventListener('click', function (e) {

			e.preventDefault();

			closeMenu();

		});

	}

	document.addEventListener('keydown', onKeydown);

	if (typeof mq.addEventListener === 'function') {

		mq.addEventListener('change', onMqChange);

	} else {

		mq.addListener(onMqChange);

	}



	/* Close after activating a link inside the panel (in-page or navigate). */

	if (panel) {

		panel.addEventListener('click', function (e) {

			var a = e.target.closest ? e.target.closest('a[href]') : null;

			if (a) {

				closeMenu();

			}

		});

	}

})();

