; (function($, undefined) {
	var storage = localStorage,
			storageKey = 'aaplus_locations',
			getCurrentLocation = function() {
				return document.location.pathname;
			},
			getLocations = function() {
				var locations = {};
				var value = storage.getItem(storageKey);
				if (value) {
					try {
						locations = JSON.parse(value);
					} catch (ex) {}
				}
				if (!$.isPlainObject(locations)) {
					locations = {};
				}
				return locations;
			},
			getLocation = function(location) {
				if (!location) {
					location = getCurrentLocation();
				}
				var locations = getLocations();
				return locations[location];
			},
			setLocation = function(id, location) {
				if (!location) {
					location = getCurrentLocation();
					document.location.hash = '#' + id;
				}
				var locations = getLocations();
				locations[location] = id;
				storage.setItem(storageKey, JSON.stringify(locations));
				;;; console.debug('setLocation', location, id, getLocations());
			},
			/**
			 * Scroll an element into view.
			 */
			scrollIntoView = function(el) {
				// @see http://stackoverflow.com/a/2906009
				var container = $('html');
				var header = $('.navbar-fixed-top');
				;;; console.debug(container, container.scrollTop());
				// container.scrollTop($('a[href="#' + id + '"]').offset().top - container.offset().top + container.scrollTop() + $('.navbar-fixed-top').height());
				container.scrollTop($(el).offset().top - container.offset().top + container.scrollTop() - header.height());
				;;; console.debug(container, container.scrollTop());
			};

	if (typeof storage !== 'undefined') {
		$('a.btn').on('click', function(event) {
			var id = this.id ? this.id : $(this).closest('[id]').attr('id');
			if (id) {
				setLocation(id);
			}
		});

		$('[data-toggle=tab][href^=#]').on('click', function(event) {
			var id = $(this).attr('href').replace(/^#/, '');
			if (id) {
				setLocation(id);
			}
		});

		$(document).ready(function() {
			;;; console.debug('locations', getLocations());
			var id = getLocation();
			if (id) {
				;;; console.debug('location', id);
				document.location.hash = '#' + id;
			}

			if (document.location.hash !== '') {
				if ($('a[href="#' + id + '"]').tab) {
					if ($('a[href="#' + id + '"]').tab('show'));
					scrollIntoView($('a[href="#' + id + '"]').closest('ul'));
				}
			}
		});
	}
}(jQuery))
