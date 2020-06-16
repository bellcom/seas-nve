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
