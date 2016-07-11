// The parseNumber function should be defined already to handle
// localized numbers. This is just a fallback.
if (typeof parseNumber === 'undefined') {
  var parseNumber = function(value) {
    return parseFloat(value);
  }
}

(function($) {
  var columns = {};

  var sortFields = $('#list-details .column-sort');
  var filterFields = $('#list-details .column-filter > input');

  // Collect all columns used for sorting or filtering.
  sortFields.each(function() {
    var column = $(this).data('column');
    var attr = $(this).data('attr');
    if (column && !columns[column]) {
      if (attr) {
        columns[column] = { name: column, attr: attr };
      } else {
        columns[column] = column;
      }
    }
  });

  // Make filter input as wide as the column.
  filterFields.each(function() {
    $(this).css('width', '0');
    $(this).parent().css('padding', '0');
    $(this).css('width', $(this).parent().css('width'));
  });

  var valueNames = [];
  for (var column in columns) {
    valueNames.push(columns[column]);
  }

  var options = {
    valueNames: valueNames
  };

  var list = new List('list-details', options);

  var compare = function(column, operator, value) {
    switch (operator) {
    case '<' : return function(item) { return parseNumber(item.values()[column]) <  value; };
    case '<=': return function(item) { return parseNumber(item.values()[column]) <= value; };
    case '>' : return function(item) { return parseNumber(item.values()[column]) >  value; };
    case '>=': return function(item) { return parseNumber(item.values()[column]) >= value; };
    case '=' : return function(item) { return parseNumber(item.values()[column]) =  value; };
    case '<>':
    case '!=': return function(item) { return parseNumber(item.values()[column]) != value; };
    }
    return function(item) { return false; }
  };

  var contains = function(column, value) {
    value = value.toLowerCase();
    return function(item) {
      var text = item.values()[column];
      text = text.toLowerCase();
      return text.search(value) > -1;
    };
  };

  filterFields
    .on('keyup', function(event) {
      list.filter(function(item) {
        var pass = true;
        filterFields.each(function() {
          var column = $(this).data('column');
          var value = $.trim($(this).val());
          var isNumeric = $(this).parent().is('.number');
          if (value !== '') {
            var expression = new RegExp('^(<=|>=|<>|!=|<|>|=)(.*)').exec(value);
            if (isNumeric && expression) {
              var operator = expression[1];
              value = parseNumber(expression[2])
              if (!isNaN(value)) {
                if (!compare(column, operator, value)(item)) {
                  pass = false;
                }
              }
            } else {
              if (!contains(column, value)(item)) {
                pass = false;
              }
            }
          }
          return pass;
        });
        return pass;
      });
    })
    .on('keydown', function(event) {
      if (event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });

  var sortOrders = [];

  var sortNumeric = function(itemA, itemB, options) {
    var column = options.valueName;
    var a = parseNumber(itemA.values()[column]);
    var b = parseNumber(itemB.values()[column]);
    if (a < b) {
      return -1;
    } else if (a > b) {
      return 1;
    }
    return 0;
  };

  sortFields.on('click', function() {
    var column = $(this).data('column');
    var isNumeric = $(this).is('.number') || $(this).parent().is('.number');
    var sortAsc = !(column in sortOrders) || sortOrders[column];
    var options = {
      order: sortAsc ? 'asc' : 'desc'
    };
    sortFields.removeClass('sort-asc').removeClass('sort-desc');
    $(this).addClass('sort-' + options.order);
    if (isNumeric) {
      options.sortFunction = sortNumeric;
    }
    list.sort(column, options);
    sortOrders[column] = !sortAsc;
  });
}(jQuery));
