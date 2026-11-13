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

	// Portada: alterna las imágenes de fondo.
	var slides = document.querySelectorAll('.hero__slide');
	if (slides.length > 1 && !document.querySelector('.hero__video') && !(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
		var current = 0;
		window.setInterval(function () {
			slides[current].classList.remove('is-active');
			current = (current + 1) % slides.length;
			slides[current].classList.add('is-active');
		}, 7000);
	}

	// Barra de avance de lectura bajo la cabecera.
	if (header) {
		var bar = document.createElement('div');
		bar.className = 'progress';
		bar.setAttribute('aria-hidden', 'true');
		header.appendChild(bar);
		var setBar = function () {
			var max = document.documentElement.scrollHeight - window.innerHeight;
			bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(window.scrollY / max, 1) : 0) + ')';
		};
		window.addEventListener('scroll', setBar, { passive: true });
		window.addEventListener('resize', setBar);
		setBar();
	}

	// Proyectos: filtros combinados por estado y por línea de negocio.
	var filterBtns = Array.prototype.slice.call(document.querySelectorAll('.pfilter__btn'));
	var filterState = { status: 'todos', line: 'todos' };
	filterBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			var group = btn.getAttribute('data-group');
			filterState[group] = btn.getAttribute('data-filter');
			filterBtns.forEach(function (b) {
				if (b.getAttribute('data-group') !== group) { return; }
				var on = b === btn;
				b.classList.toggle('is-on', on);
				b.setAttribute('aria-pressed', on ? 'true' : 'false');
			});
			document.querySelectorAll('#proyectos .project').forEach(function (card) {
				var okStatus = filterState.status === 'todos' || card.getAttribute('data-status') === filterState.status;
				var okLine = filterState.line === 'todos' || card.getAttribute('data-line') === filterState.line;
				card.hidden = !(okStatus && okLine);
				card.classList.add('is-in');
			});
		});
	});

	// Portada: botón para pausar el vídeo de fondo.
	var heroVideo = document.querySelector('.hero__video');
	var pauseBtn = document.querySelector('.hero__pause');
	if (heroVideo && pauseBtn) {
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			heroVideo.removeAttribute('autoplay');
			heroVideo.pause();
			pauseBtn.textContent = 'Reproducir vídeo';
			pauseBtn.setAttribute('aria-pressed', 'true');
		}
		pauseBtn.addEventListener('click', function () {
			if (heroVideo.paused) {
				heroVideo.play();
				pauseBtn.textContent = 'Pausar vídeo';
				pauseBtn.setAttribute('aria-pressed', 'false');
			} else {
				heroVideo.pause();
				pauseBtn.textContent = 'Reproducir vídeo';
				pauseBtn.setAttribute('aria-pressed', 'true');
			}
		});
	}

	// Ficha de proyecto: las fotos del texto y de la galería también se amplían.
	document.querySelectorAll('.project-body img').forEach(function (img) {
		if (img.closest('a')) { return; }
		var full = img.getAttribute('data-full-url');
		if (!full && img.srcset) {
			var best = 0;
			img.srcset.split(',').forEach(function (part) {
				var bits = part.trim().split(/\s+/);
				var w = parseInt(bits[1], 10) || 0;
				if (w > best) { best = w; full = bits[0]; }
			});
		}
		var fig = img.closest('figure');
		var cap = fig && fig.querySelector('figcaption') ? fig.querySelector('figcaption').textContent : (img.alt || '');
		var a = document.createElement('a');
		a.className = 'zoom';
		a.href = full || img.src;
		a.setAttribute('data-caption', cap);
		a.setAttribute('aria-label', 'Ampliar imagen');
		img.parentNode.insertBefore(a, img);
		a.appendChild(img);
	});

	// Visor de imágenes a pantalla completa.
	var lb = null, lbImg, lbCap, lbCount, lbList = [], lbIndex = 0, lbOpener = null;
	function lbBuild() {
		lb = document.createElement('div');
		lb.className = 'lb';
		lb.hidden = true;
		lb.setAttribute('role', 'dialog');
		lb.setAttribute('aria-modal', 'true');
		lb.setAttribute('aria-label', 'Visor de imágenes');
		lb.innerHTML = '<p class="lb__count" aria-live="polite"></p>' +
			'<button type="button" class="lb__close" aria-label="Cerrar">×</button>' +
			'<button type="button" class="lb__nav lb__prev" aria-label="Imagen anterior">‹</button>' +
			'<figure class="lb__fig"><img alt=""><figcaption></figcaption></figure>' +
			'<button type="button" class="lb__nav lb__next" aria-label="Imagen siguiente">›</button>';
		document.body.appendChild(lb);
		lbImg = lb.querySelector('img');
		lbCap = lb.querySelector('figcaption');
		lbCount = lb.querySelector('.lb__count');
		lb.querySelector('.lb__close').addEventListener('click', lbClose);
		lb.querySelector('.lb__prev').addEventListener('click', function () { lbShow(lbIndex - 1); });
		lb.querySelector('.lb__next').addEventListener('click', function () { lbShow(lbIndex + 1); });
		lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('lb__fig')) { lbClose(); } });
		var startX = null;
		lb.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
		lb.addEventListener('touchend', function (e) {
			if (startX === null) { return; }
			var dx = e.changedTouches[0].clientX - startX;
			if (Math.abs(dx) > 50) { lbShow(lbIndex + (dx < 0 ? 1 : -1)); }
			startX = null;
		});
	}
	function lbShow(i) {
		lbIndex = (i + lbList.length) % lbList.length;
		var a = lbList[lbIndex];
		var cap = a.getAttribute('data-caption') || '';
		lbImg.src = a.getAttribute('href');
		lbImg.alt = cap;
		lbCap.textContent = cap;
		lbCount.textContent = (lbIndex + 1) + ' / ' + lbList.length;
	}
	function lbOpen(a) {
		if (!lb) { lbBuild(); }
		lbList = Array.prototype.slice.call(document.querySelectorAll('a.zoom')).filter(function (el) { return el.offsetParent !== null; });
		lbOpener = a;
		lb.classList.toggle('lb--single', lbList.length < 2);
		lb.hidden = false;
		document.body.classList.add('lb-open');
		lbShow(Math.max(lbList.indexOf(a), 0));
		lb.querySelector('.lb__close').focus();
	}
	function lbClose() {
		lb.hidden = true;
		lbImg.removeAttribute('src');
		document.body.classList.remove('lb-open');
		if (lbOpener) { lbOpener.focus(); }
	}
	document.addEventListener('click', function (e) {
		var a = e.target.closest ? e.target.closest('a.zoom') : null;
		if (a) { e.preventDefault(); lbOpen(a); }
	});
	document.addEventListener('keydown', function (e) {
		if (!lb || lb.hidden) { return; }
		if (e.key === 'Escape') { lbClose(); }
		if (e.key === 'ArrowRight') { lbShow(lbIndex + 1); }
		if (e.key === 'ArrowLeft') { lbShow(lbIndex - 1); }
		if (e.key === 'Tab') {
			var f = lb.querySelectorAll('button');
			var first = f[0], last = f[f.length - 1];
			if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
			else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
		}
	});

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
