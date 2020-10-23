jQuery(function ($) {
  'use strict';

  // Popover.
  $('[data-toggle="popover"]').popover({'html' : true});

  // Select 2.
  $('select.select2').select2();
  $('select.form-control').select2();

  // Select 2 for ajax fields.
  var $wrapper = $('.wrapper');
  var $trigger = $wrapper.find('.add-link');

  $trigger.on('click', function() {
    $('select.form-control').select2('destroy');

    var timer = setInterval(function() {
      if ($trigger.hasClass('disabled')) {
        return;
      }

      // Re-apply select2 after ajax has run.
      $('select.form-control').select2();

      clearInterval(timer);
    }, 300);
  });

  // Default value selection.
  $('.js-default-value-select').each(function() {
    // Getting target element.
    var defaultValueKey = $(this).data('default-value-target');
    var targetElement = $('.js-default-value-target[data-default-value-source="' + defaultValueKey + '"]');

    // Moving the select.
    $(this).detach();
    $(targetElement).before(this);
  });
  $('.js-default-value-select').change(function() {
    // Getting target element.
    var defaultValueKey = $(this).data('default-value-target');
    var targetElement = $('.js-default-value-target[data-default-value-source="' + defaultValueKey + '"]');

    // Getting the selected text body.
    var selectedValue = $(this).val();
    if (default_value_groups[defaultValueKey][selectedValue]) {
      var body = default_value_groups[defaultValueKey][selectedValue].body;
      CKEDITOR.instances[targetElement.attr('id')].setData(body);
    }
  });
});

// Toggle calculation expression.
(function() {
  var containers = document.getElementsByClassName('calculation-expression');
  var buttons = document.getElementsByClassName('calculation-expression-toggle');

  function toggleCalculationExpressions(event) {
    for (i = 0; i < containers.length; i++) {
      var container = containers[i];

      container.classList.toggle('hidden');
    }
  }

  for (i = 0; i < buttons.length; i++) {
    var button = buttons[i];

    button.addEventListener('click', toggleCalculationExpressions);
  }
})();

(function() {
  var forms = document.querySelectorAll('form');

  function passifySubmit(e) {
    var submitter = e.submitter;
    var submits = new Array(
        submitter
    );
    var pinned_button = document.querySelector('#' + $(submitter).data('id'));
    if (pinned_button !== null) {
        submits.push(pinned_button);
    }

    for (i = 0; i < submits.length; i++) {
      var submit = submits[i];
      var icon = submit.querySelector('.fa');

      // Change icon to a spinner.
      if (icon !== null) {
        icon.className = ''; // Removes ALL classes.
        icon.classList.add('fa', 'fa-refresh', 'fa-spin');
      } else {
        icon = document.createElement('SPAN');
        icon.classList.add('fa', 'fa-refresh', 'fa-spin', 'appended');

        submit.appendChild(icon);
      }
    }
  }

  // Loop over all forms upon page load.
  for (i = 0; i < forms.length; i++) {
    var form = forms[i];

    form.addEventListener('submit', passifySubmit);
  }
})();

// Form errors.
(function() {
  function generateAlert(text, errors) {
    var alert = document.createElement('div');
    alert.classList.add('alert', 'alert-danger');

    alert.appendChild(document.createTextNode(text));

    return alert;
  }
  function findWrapperTab(element) {
    var pane = element.closest('.tab-pane');
    var id = pane.getAttribute('id');
    var tab = document.querySelector('.nav-tabs a[href="#' + id + '"]');

    return tab;
  }

  var submits = document.querySelectorAll('[type="submit"');

  for (var i = 0; i < submits.length; i++) {
    var submit = submits[i];

    submit.addEventListener('click', function(e) {
      var element = this;
      var form = element.closest('form');
      var validity = form.checkValidity();

      // Remove all previously added content to wrapper.
      var wrapper = document.querySelector('.aaplus-flashes');
      if (wrapper) {
        wrapper.innerHTML = '';
      }
      var tabLinks = document.querySelectorAll('.nav-tabs a.has-error');
      for(var i = 0; i < tabLinks.length; i++) {
        var tabLink = tabLinks[i];

        tabLink.classList.remove('has-error');
      }

      // Remove errors from inputs.
      var inputErrors = document.querySelectorAll('.form-group.has-error');

      for (var i = 0; i < inputErrors.length; i++) {
        var inputError = inputErrors[i];

        inputError.classList.remove('has-error');
      }

      // Form is not valid.
      if (!validity) {
        var inputs = form.querySelectorAll('.form-control');

        for (var i = 0; i < inputs.length; i++) {
          var input = inputs[i];

          // Input is not valid.
          if (!input.checkValidity()) {
            var group = input.closest('.form-group');

            group.classList.add('has-error');

            // Check if input is a child of a tab.
            var pane = findWrapperTab(input);
            if (pane !== null) {
              pane.classList.add('has-error');
            }
          }
        }

        // Show errors.
        var alert = generateAlert('Der er opstået én eller flere fejl.');

        wrapper.appendChild(alert);
      }
    });
  }

})();
