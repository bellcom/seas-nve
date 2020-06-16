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
  function addMoreForm($collectionHolder, $newLinkL, $ajaxSrc) {
    var prototype = false;
    if ($ajaxSrc) {
      var $ajaxSrc = new URL( window.location.protocol + "//" + window.location.host + $ajaxSrc);
      var $currentId = $collectionHolder.data('current-id');
      if ($currentId) {
        $ajaxSrc.searchParams.append('current_id', $currentId);
      }
      $.get($ajaxSrc, function($data) {
        if (jQuery.isEmptyObject($data)) {
          console.log('Add more ajax request to ' + $ajaxSrc + ' is empty');
          // If we got wring data from backed.
          // Use fallback prototype.
          newForm = $collectionHolder.data('prototype');
          addMoreFormCallback($collectionHolder, $newLinkL, newForm);
          return;
        }
        newForm = $('<div></div>').append($collectionHolder.data('prototype'));
        $select = newForm.find('select');
        $select.find('option').each(function() {
          if (this.value) {
            this.remove();
          }
        });
        if ($data) {
          for ($key in $data) {
            $select.append($("<option>").attr('value', $data[$key].id).text($data[$key].value));
          }
        }
        addMoreFormCallback($collectionHolder, $newLinkL, newForm.html());
      }, "json");
    }
    else {
      newForm = $collectionHolder.data('prototype');
      addMoreFormCallback($collectionHolder, $newLinkL, newForm);
    }
  }
  function addMoreFormCallback($collectionHolder, $newLinkL, newForm) {
    var index = $collectionHolder.data('index');

    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div class="row form-group"><div class="col-sm-10"></div><div class="col-sm-2"></div>')
      .find('.col-sm-10').append(newForm)
      .end();
    $newLinkL.before($newFormLi);
    addDeleteLink($newFormLi);

    $collectionHolder.find('.add-link').removeClass('disabled');
  }

  function addDeleteLink($formRow) {
    if ($formRow.hasClass('required')) {
      return;
    }
    var $removeFormA = $('<a href="#" class="btn btn-danger">Slet</a>');
    $formRow.find('.col-sm-2').append($removeFormA);

    $removeFormA.on('click', function(e) {
      e.preventDefault();
      $formRow.remove();
    });
  }

  function addMore($collectionHolder, $ajaxSrc, $addNewUrl) {
    if (!$collectionHolder.length) {
      return;
    }
    var $addLink = $('<a href="#" class="btn btn-primary add-link">Tilføj flere</a>');
    var $newLinkRow = $('<div class="row"><div class="col-sm-12"></div></div>').find('div').append($addLink).end();
    if ($addNewUrl) {
      var $addNewLink = $('<a href="' + $addNewUrl +'" class="btn btn-primary" target="_blank">Opret nyt</a>');
      $newLinkRow.find('div').append('&nbsp;').append($addNewLink).end();
    }
    $collectionHolder.find('.row').each(function() {
      addDeleteLink($(this));
    });

    $collectionHolder.append($newLinkRow);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
      e.preventDefault();
      $(this).addClass('disabled');
      addMoreForm($collectionHolder, $newLinkRow, $ajaxSrc);
    });
  }

  addMore($('.contact_persons'));
  addMore($('.datter_selskaber'), '/virksomhed/datterselskab-list', '/virksomhed/new');
  addMore($('.ean_numbers'), '/bygning/eannumm-list');
  addMore($('.p_numbers'), '/bygning/pnumm-list');
  addMore($('.bygning_by_cvr_number'), '/bygning/cvrnumm-list');

  $('.cvr-search').change(function () {
    var $cvrNumber = '';
    if (this.value) {
        var $cvrNumber = $(this).find('option[value=' + this.value + ']').data('cvrnumber');
    }
    $('#appbundle_bygning_cvrNumber').val($cvrNumber);
  });

  $(document).on('change', '.bygningerByCvrNumber', function () {
    $wrapper = $(this).parents('div.form-group:first > div');
    $wrapper.find('.help-block').remove();
    if (this.value == '') {
      return;
    }
    if ($(this).find('option[value=' + this.value + ']').data('cvrnumber') != $('#appbundle_virksomhed_cvrNumber').val()) {
      $wrapper.append('<span class="help-block"><strong>OBS!!!</strong> Vælgt bygningen og virkosmhed har forskelige CVRnr. Bygningen vil være opdateret med virksomheds CVR.</span>');
    }
  });

  $('#appbundle_nyklimaskaermtiltagdetail_tIndeDetailed').change(function() {
      $('.monthly-inde')[this.checked ? "show" : "hide"]();
  });

  $('#appbundle_nyklimaskaermtiltagdetail_tUdeDetailed').change(function() {
      $('.monthly-ude')[this.checked ? "show" : "hide"]();
  });

  $('#appbundle_nyklimaskaermtiltagdetail_graddageFordeling').change(function() {
      $('.tOpvarmningTimerAarMonthly')[this.value == '' ? "show" : "hide"]();
  });

  $('#setDefaultTOpvarmningTimerAarMonthly').click(function($e) {
      $e.preventDefault();
      var $tOpvarmningTimerAarMonthly = $(this).data('topvarmningtimeraarmonthly');
      for (var $key in $tOpvarmningTimerAarMonthly) {
          $('#appbundle_nyklimaskaermtiltagdetail_tOpvarmningTimerAarMonthly_' + $key).val($tOpvarmningTimerAarMonthly[$key]);
      }
  });
  $('#setDefaultTjordMonthly').click(function($e) {
      $e.preventDefault();
      var $tjord = $(this).data('tjord');
      for (var $key in $tjord) {
          $('#appbundle_nyklimaskaermtiltagdetail_tUdeMonthly_' + $key).val($tjord[$key]);
      }
  });
  $('#appbundle_nyklimaskaermtiltagdetail_tIndeC').keyup(function() {
      if (document.getElementById('appbundle_nyklimaskaermtiltagdetail_tIndeDetailed').checked) {
          return;
      }
      $('.tindemonthly').val($(this).val());
  });
  $('#appbundle_nyklimaskaermtiltagdetail_tUdeC').keyup(function() {
      if (document.getElementById('appbundle_nyklimaskaermtiltagdetail_tUdeDetailed').checked) {
          return;
      }
      $('.tudemonthly').val($(this).val());
  });
  $('#setDefaultTUdeMonthly').click(function($e) {
      $e.preventDefault();
      var $tudemonthly = $(this).data('tudemonthly');
      for (var $key in $tudemonthly) {
          $('#appbundle_nyklimaskaermtiltagdetail_tUdeMonthly_' + $key).val($tudemonthly[$key]);
      }
  });

  $(document).ready(function() {
      conditionalRadioFormElements('.appbundle_tryklufttiltagdetail_indData');
      conditionalDropdownFormElements('#energiTypePrimaerFoer');
      conditionalDropdownFormElements('#energiTypeSekundaerFoer');
      conditionalDropdownFormElements('#energiTypePrimaerEfter');
      conditionalDropdownFormElements('#energiTypeSekundaerEfter');

      $('#appbundle_varmepumpetiltagdetail_varmePumpeForbrug_type').change(function() {
          var $value = $(this).val();
          var $faktor = $(this).find('option[value=' + $value + ']').data('faktor');
          $('#appbundle_varmepumpetiltagdetail_varmePumpeForbrug_effektFaktor').val($faktor);
      });

      var $varmePumpeForm = $('#varmeanlaegtiltagdetail').parents('form:first');
      if ($varmePumpeForm.length) {
          $varmePumpeForm.find('.form-group:last').append('<button type="submit" class="btn btn-primary save-and-continue">Gem og rediger videre</button>');
          $varmePumpeForm.find('.save-and-continue').click(function() {
              $action = $varmePumpeForm.attr('action');
              $varmePumpeForm.attr('action', $action + '?continue=1').submit();
          });
      }

      pinFormButtons();
  });

  $(document).on('click', '.pinned-buttons a', function () {
      $id = $(this).attr('id');
      $('button.pinned[data-id=' + $id + ']').click();
  });

  function conditionalRadioFormElements($wrapper) {
      $(document).on('change', $wrapper + ' input[type=radio]', function () {
          $($wrapper + ' .hidden').removeClass('hidden');
          $($wrapper + ' input[type=radio]:checked').each(function() {
              $value = $(this).val();
              if ($value) {
                  $('.' + $value + '-hidden').each(function() {
                      $(this).parents('div.form-group:first').not('.hidden').addClass('hidden');
                  });
              }
          });
      });
      $($wrapper + ' input:checked').change();
  }

  function conditionalDropdownFormElements($wrapper) {
      $(document).on('change', $wrapper + ' select', function () {
          $($wrapper + ' .hidden').removeClass('hidden');
          $($wrapper + ' select').each(function() {
              $value = $(this).val();
              if ($value == null) {
                  $value = '';
              }
              $($wrapper + ' .' + $value + '-hidden').each(function() {
                  $(this).parents('div.form-group:first').not('.hidden').addClass('hidden');
              });
          });
      });
      $($wrapper + ' select').each(function() {
          $(this).change();
      });
  }

  function pinFormButtons() {
      var $buttons = $('button.pinned');
      console.log($buttons);
      if ($buttons.length) {
          $('body').addClass('with-pinned-buttons');
          $pinned_wrapper = $('.pinned-buttons');
          $pinned_wrapper.show();
          for (var $i = 0; $i < $buttons.length; ++$i) {
              $this = $($buttons[$i]);
              $classes = $this.attr("class").replace(/pinned/g, '');
              $id = 'pinned-button-' + $i;
              $pinned_wrapper.append('<a id="' + $id +'" class="' + $classes + '">' + $this.html() + '</a>');
              $this.attr('data-id', $id).hide();

              $wrapper = $this.parents('.form-group:first');
              if ($wrapper.find('*:visible, .modal').length == 0) {
                  $wrapper.hide();
              }
          }
      }
  }

}(jQuery));
