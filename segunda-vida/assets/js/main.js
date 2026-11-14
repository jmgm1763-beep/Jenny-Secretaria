/* Segunda Vida — interacción ligera, sin dependencias. */
(function () {
	'use strict';

	var data = window.svData || { i18n: {} };
	var KEY = 'sv_favoritos';

	/* ---- Menú móvil ---- */
	var toggle = document.querySelector('.sv-header__toggle');
	var nav = document.getElementById('sv-nav');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	/* ---- Filtros plegados en móvil ---- */
	var panel = document.querySelector('.sv-filters__panel');
	if (panel && window.matchMedia('(max-width: 900px)').matches) {
		panel.removeAttribute('open');
	}

	/* ---- Favoritos (se guardan en el navegador) ---- */
	function readFavs() {
		try {
			var list = JSON.parse(window.localStorage.getItem(KEY) || '[]');
			return Array.isArray(list) ? list.map(Number).filter(Boolean) : [];
		} catch (e) {
			return [];
		}
	}
	function writeFavs(list) {
		try {
			window.localStorage.setItem(KEY, JSON.stringify(list));
		} catch (e) { /* almacenamiento no disponible */ }
	}
	function paint() {
		var favs = readFavs();
		document.querySelectorAll('[data-sv-fav]').forEach(function (btn) {
			var on = favs.indexOf(Number(btn.getAttribute('data-sv-fav'))) !== -1;
			btn.setAttribute('aria-pressed', on ? 'true' : 'false');
			btn.setAttribute('aria-label', on ? data.i18n.remove : data.i18n.add);
		});
		document.querySelectorAll('.sv-fav-count').forEach(function (el) {
			el.textContent = favs.length;
			el.hidden = favs.length === 0;
		});
	}
	document.addEventListener('click', function (event) {
		var btn = event.target.closest('[data-sv-fav]');
		if (!btn) { return; }
		event.preventDefault();
		var id = Number(btn.getAttribute('data-sv-fav'));
		var favs = readFavs();
		var at = favs.indexOf(id);
		if (at === -1) { favs.push(id); } else { favs.splice(at, 1); }
		writeFavs(favs);
		paint();
		var page = btn.closest('[data-sv-favorites]');
		if (page && at !== -1) {
			btn.closest('li').remove();
			if (!favs.length) { showEmpty(); }
		}
	});
	paint();

	/* ---- Página de favoritos ---- */
	var grid = document.querySelector('[data-sv-favorites]');
	function showEmpty() {
		var empty = document.querySelector('.sv-favorites__empty');
		if (empty) { empty.textContent = data.i18n.empty; empty.hidden = false; }
	}
	function decode(html) {
		var el = document.createElement('textarea');
		el.innerHTML = html;
		return el.value;
	}
	function el(tag, cls, text) {
		var node = document.createElement(tag);
		if (cls) { node.className = cls; }
		if (text) { node.textContent = text; }
		return node;
	}
	function card(item) {
		var li = el('li', 'sv-card product');
		var media = el('div', 'sv-card__media');
		var link = el('a');
		link.href = item.permalink;
		if (item.images && item.images[0]) {
			var img = el('img');
			img.src = item.images[0].thumbnail || item.images[0].src;
			img.alt = '';
			img.loading = 'lazy';
			link.appendChild(img);
		}
		media.appendChild(link);
		if (!item.is_in_stock) { media.appendChild(el('span', 'sv-badge sv-badge--sold', data.i18n.sold)); }
		var fav = el('button', 'sv-fav');
		fav.type = 'button';
		fav.setAttribute('data-sv-fav', item.id);
		fav.innerHTML = '<svg class="sv-icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path d="M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2Z"/></svg>';
		media.appendChild(fav);
		li.appendChild(media);

		var body = el('div', 'sv-card__body');
		var title = el('h3', 'sv-card__title');
		var tlink = el('a', '', decode(item.name));
		tlink.href = item.permalink;
		title.appendChild(tlink);
		body.appendChild(title);
		var p = item.prices || {};
		if (p.price) {
			var amount = (Number(p.price) / Math.pow(10, p.currency_minor_unit || 0)).toLocaleString(document.documentElement.lang || 'es-ES', {
				style: 'currency',
				currency: p.currency_code || 'EUR'
			});
			body.appendChild(el('p', 'sv-card__price price', amount));
		}
		li.appendChild(body);
		return li;
	}
	if (grid) {
		var favs = readFavs();
		if (!favs.length || !data.storeApi) {
			showEmpty();
		} else {
			var sep = data.storeApi.indexOf('?') === -1 ? '?' : '&';
			fetch(data.storeApi + sep + 'per_page=100&include=' + favs.join(','))
				.then(function (r) { return r.ok ? r.json() : []; })
				.then(function (items) {
					if (!items.length) { showEmpty(); return; }
					items.forEach(function (item) { grid.appendChild(card(item)); });
					paint();
				})
				.catch(showEmpty);
		}
	}
})();
