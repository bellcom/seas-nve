jQuery(function ($) {
  'use strict';

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
var containers = document.getElementsByClassName('calculation-expression');
var buttons = document.getElementsByClassName('calculation-expression-toggle');

function toggleCalculationExpressions(event) {
  for (var container of containers) {
    container.classList.toggle('hidden');
  }
}

for (var button of buttons) {
  button.addEventListener('click', toggleCalculationExpressions);
}
