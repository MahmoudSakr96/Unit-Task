
(function() {

	// UTILITIES

	function addEventToList(list, type, fn) {
		for (var i = 0, len = list.length; i < len; i++) {
			addEvent(list[i], type, fn);
		}
	}

	function addEvent(elem, type, handler) {
		if (elem.addEventListener) {
			elem.addEventListener(type, handler, false);
		} else {
			elem.attachEvent("on" + type, handler);
		}
	}

	function map(arr, fn) {
		var results = [];
		for (var i = 0; i < arr.length; i++) {
			results.push(fn(arr[i], i));
		}
		return results;
	}

	function hasClass(el, className) {
		var output;
		if (el.classList) {
			output = el.classList.contains(className);
		} else {
			output = new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
		}
		return output;
	}

	function addClass(el, className) {
		if (el.classList) {
			el.classList.add(className);
		} else {
			if (!hasClass(el, className)) {
				el.className += ' ' + className;
			}
		}
	}

	function removeClass(el, className) {
		if (el.classList) {
			el.classList.remove(className);
		} else {
			el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
		}
	}

	function toggleClass(el, className) {
		var exists;

		if (el.classList) {
			el.classList.toggle(className);

			exists = el.classList.contains(className);
		} else {
			var classes = el.className.split(' ');
			var existingIndex = -1;

			for (var i = classes.length; i--; ) {
				if (classes[i] === className) {
					existingIndex = i;
				}
			}

			if (existingIndex >= 0) {
				exists = false;
				classes.splice(existingIndex, 1);
			} else {
				exists = true;
				classes.push(className);
			}

			el.className = classes.join(' ');
		}

		return exists;
	}

	// APP LOGIC

	function fillLists() {
		var columns = [0, 0];
		var lists = [document.createElement('ul'), document.createElement('ul')];

		lists[0].setAttribute("dir", "auto");
		lists[1].setAttribute("dir", "auto");

		var perm_container = document.querySelector(".permissions-container");

		var ul, itm, acc;
		for (var perm in access_list) {
			if (columns[0] <= columns[1]) {
				col = 0;
			} else {
				col = 1;
			}
			columns[col] += access_list[perm].length;
			columns[col]++;
			perm_itm = document.createElement('li');
			perm_itm.innerHTML = perm;
			ul = document.createElement('ul');

			ul.setAttribute("dir", "auto");

			for (acc in access_list[perm]) {
				itm = document.createElement('li');
				itm.innerHTML = access_list[perm][acc];
				ul.appendChild(itm);
			}
			perm_itm.appendChild(ul);
			lists[col].appendChild(perm_itm);
		}
		lists[0].className = lists[1].className = "permissions-list js-perms-list";
		perm_container.appendChild(lists[0]);
		perm_container.appendChild(lists[1]);
	}

	function toggleList() {
		var toggleBtn = document.querySelector('.js-toggle-list-btn');
		var items = document.querySelectorAll('.js-perms-list li > ul');
		if (hasClass(toggleBtn, 'toggle-bg')) {
			map(items, function(el) {
				removeClass(el, 'show');
			});
		} else {
			map(items, function(el) {
				addClass(el, 'show');
			});
		}
		toggleClass(toggleBtn, 'toggle-bg');
		window.scrollTo(0, document.querySelector(".permissions-container").offsetTop);
	}

	addEvent(window, 'load', function() {
		fillLists();
		var listItems = document.querySelectorAll('.js-perms-list > li');
		var toggleBtn = document.querySelectorAll('.js-toggle-list-btn');

		addEventToList(listItems, 'click', function() {
			var shown = toggleClass(this.querySelector('ul'), 'show');

			if (shown && toggleBtn[0]) {
				addClass(toggleBtn[0], 'toggle-bg');
			}
		});

		addEventToList(toggleBtn, 'click', toggleList);
	});

})();
