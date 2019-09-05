jQuery(function ($) {
  'use strict';

  // Select 2.
  $('select.select2').select2();
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
