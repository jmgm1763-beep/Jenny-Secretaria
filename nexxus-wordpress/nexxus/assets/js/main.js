/* NEXXUS · interacción mínima: menú móvil y aparición suave de bloques. */
(function () {
	'use strict';

	var toggle = document.querySelector('.nav-toggle');
	var nav = document.getElementById('menu-principal');

	function closeNav() {
		if (!toggle) { return; }
		toggle.setAttribute('aria-expanded', 'false');
		document.body.classList.remove('nav-open');
	}

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = toggle.getAttribute('aria-expanded') === 'true';
			toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
			document.body.classList.toggle('nav-open', !open);
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) { closeNav(); }
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { closeNav(); }
		});
	}

	var items = document.querySelectorAll('.reveal');
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (!('IntersectionObserver' in window) || reduce) {
		items.forEach(function (el) { el.classList.add('is-in'); });
		return;
	}

	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('is-in');
				io.unobserve(entry.target);
			}
		});
	}, { rootMargin: '0px 0px -8% 0px' });

	items.forEach(function (el) { io.observe(el); });
})();
