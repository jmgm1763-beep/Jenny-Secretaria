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

	// Cabecera: línea inferior solo al desplazarse.
	var header = document.getElementById('cabecera');
	function onScroll() { if (header) { header.classList.toggle('is-scrolled', window.scrollY > 8); } }
	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	// Partners en pestañas.
	var tabs = Array.prototype.slice.call(document.querySelectorAll('.ptab'));
	function selectTab(tab, focus) {
		tabs.forEach(function (t) {
			var on = t === tab;
			t.setAttribute('aria-selected', on ? 'true' : 'false');
			t.tabIndex = on ? 0 : -1;
			var panel = document.getElementById(t.getAttribute('aria-controls'));
			if (panel) { panel.hidden = !on; }
		});
		if (focus) { tab.focus(); }
	}
	if (tabs.length) {
		var initial = tabs[0];
		if (location.hash) {
			tabs.forEach(function (t) { if ('#' + t.getAttribute('aria-controls') === location.hash) { initial = t; } });
		}
		selectTab(initial, false);
		tabs.forEach(function (t, i) {
			t.addEventListener('click', function () { selectTab(t, false); });
			t.addEventListener('keydown', function (e) {
				var next = null;
				if (e.key === 'ArrowRight') { next = tabs[(i + 1) % tabs.length]; }
				if (e.key === 'ArrowLeft') { next = tabs[(i - 1 + tabs.length) % tabs.length]; }
				if (next) { e.preventDefault(); selectTab(next, true); }
			});
		});
	}

	// Menú: marca la sección que se está viendo.
	var navLinks = Array.prototype.slice.call(document.querySelectorAll('.site-nav a[href*="#"]'));
	if ('IntersectionObserver' in window && navLinks.length) {
		var spy = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				navLinks.forEach(function (a) {
					a.classList.toggle('is-current', a.getAttribute('href').split('#')[1] === entry.target.id);
				});
			});
		}, { rootMargin: '-45% 0px -50% 0px' });
		document.querySelectorAll('main section[id]').forEach(function (sec) { spy.observe(sec); });
	}

	// Cifras: cuentan hasta su valor al entrar en pantalla.
	function formatNumber(n) { return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
	function countUp(el) {
		var target = parseInt(el.getAttribute('data-count'), 10);
		var pre = el.getAttribute('data-prefix') || '';
		var suf = el.getAttribute('data-suffix') || '';
		var start = null;
		function step(ts) {
			if (start === null) { start = ts; }
			var t = Math.min((ts - start) / 1400, 1);
			var eased = 1 - Math.pow(1 - t, 3);
			el.textContent = pre + formatNumber(Math.round(target * eased)) + suf;
			if (t < 1) { window.requestAnimationFrame(step); }
		}
		window.requestAnimationFrame(step);
	}
	var counters = document.querySelectorAll('.count');
	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if ('IntersectionObserver' in window && !reduceMotion && counters.length) {
		var cio = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) { countUp(entry.target); cio.unobserve(entry.target); }
			});
		}, { threshold: 0.6 });
		counters.forEach(function (el) { cio.observe(el); });
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
