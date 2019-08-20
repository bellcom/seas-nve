; (function($, undefined) {
  var storage = sessionStorage,
      storageKey = 'aaplus_locations',

      /**
       * Get the current url.
       */
      getCurrentUrl = function() {
        return document.location.pathname;
      },

      /**
       * Get all stored locations, i.e. a map from path to element id.
       */
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

      /**
       * Get location for the current page or a specified url.
       */
      getLocation = function(url, keep) {
        if (!url) {
          url = getCurrentUrl();
        }
        var locations = getLocations();
        var id = locations[url];
        if (!keep) {
          setLocation(null, url);
        }
        return id;
      },

      /**
       * Stores the id for the current location or a specified location.
       */
      setLocation = function(id, url) {
        if (!url) {
          url = getCurrentUrl();
          setHash(id);
        }
        var locations = getLocations();
        if (id) {
          locations[url] = id;
        } else {
          delete locations[url];
        }
        storage.setItem(storageKey, JSON.stringify(locations));
      },

      /**
       * Scroll an element into view.
       */
      scrollIntoView = function(el, offset) {
        if (!offset) {
          offset = 0;
        }
        setTimeout(function() {
          // @see http://stackoverflow.com/a/2906009
          var container = $('html');
          var header = $('.navbar-fixed-top');
          // container.scrollTop(0);
          container.scrollTop($(el).offset().top - header.height() - offset);
        }, 100);
      },

      /**
       * Set url fragment identifier (hash) and scroll any element matching the hash into view.
       */
      setHash = function(hash) {
        if (!hash) {
          return;
        }
        hash = '#' + hash.replace(/^#+/, '');
        document.location.hash = hash;

        var el = $('a[href="' + hash + '"]');
        if (el.length > 0 && el.tab) {
          el.tab('show');
          scrollIntoView(el.closest('ul'));
        } else {
          el = $(hash);
          if (el.is('tr, th, td')) {
            var fixedHeader = el.closest('table').prev('.floatThead-container');
            scrollIntoView(el, fixedHeader.length === 0 ? 0 : fixedHeader.height());
          } else {
            scrollIntoView(el);
          }
        }
      };

  $(document).ready(function() {
    $("textarea").autoGrow();

    $(".table-header-rotated").floatThead({
      position: 'fixed',
      top: 50
    });

    $('.tooltip-wrapper').tooltip({position: "bottom"});

    $('[data-toggle=tab][href^=#]').on('click', function(event) {
      var id = $(this).attr('href').replace(/^#/, '');
      document.location.hash = '#' + id;
    });

    // Get hash or any stored location and scroll element into view.
    var hash = location.hash;
    if (hash) {
      setHash(hash);
      // Make any flashes "fixed" if not visible on screen.
      setTimeout(function() {
        // http://stackoverflow.com/a/488073
        var $elem = $('.aaplus-flashes');
        var $window = $(window);

        var docViewTop = $window.scrollTop();
        var docViewBottom = docViewTop + $window.height();

        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        if (!((elemBottom <= docViewBottom) && (elemTop >= docViewTop))) {
          $elem.addClass('fixed');
        }
      }, 150);
    }

    var $roles_checkbox = $('.role-checkbox');
    if ($roles_checkbox.length) {
      $roles_checkbox.on('change', function() {
        var _this = $(this);
        var $checked = _this.is(":checked");
        var $roles = _this.data('roles').split(',');

        for (var $key in $roles) {
          $('input[value="' + $roles[$key] + '"]').attr('disabled', $checked);
          if ($checked) {
            $('input[value="' + $roles[$key] + '"]').parents('tr:first').addClass('disabled');
          }
          else {
            $('input[value="' + $roles[$key] + '"]').parents('tr:first').removeClass('disabled');
          }
        }
      }).filter(':checked').change();
    }
  });

  // Add more / Remove functionality.
  function addMoreForm($collectionHolder, $newLinkL) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div class="row form-group"><div class="col-sm-10"></div><div class="col-sm-2"></div>')
        .find('.col-sm-10').append(newForm)
        .end();
    $newLinkL.before($newFormLi);
    addDeleteLink($newFormLi);
  }

  function addDeleteLink($formRow) {
    var $removeFormA = $('<a href="#" class="btn btn-danger">Fjern</a>');
    $formRow.find('.col-sm-2').append($removeFormA);

    $removeFormA.on('click', function(e) {
      e.preventDefault();
      $formRow.remove();
    });
  }

  function addMore($collectionHolder) {
    if (!$collectionHolder.length) {
      return;
    }
    var $addLink = $('<a href="#" class="btn btn-primary">Tilføj mere</a>');
    var $newLinkRow = $('<div class="row"><div class="col-sm-12"></div></div>').find('div').append($addLink).end();
    $collectionHolder.find('.row').each(function() {
      addDeleteLink($(this));
    });

    $collectionHolder.append($newLinkRow);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
      e.preventDefault();
      addMoreForm($collectionHolder, $newLinkRow);
    });
  }

  addMore($('.contact_persons'));
  addMore($('.datter_selskaber'));
  addMore($('.ean_numbers'));
  addMore($('.p_numbers'));

}(jQuery));
