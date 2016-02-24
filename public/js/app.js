$(document).ready(function() {
    var updateTotal = function() {
        var total = 0.0;
        $('.row-total').each(function(i, td) {
            var subtotal = parseFloat($(td).text().substring(1));
            if (!isNaN(subtotal)) {
                total += subtotal;
            }
        });
        $('#total').html('$' + total);
    };

    $('form').on('keyup', 'td.totaler-field input', function() {
        var row = $(this).closest('tr');
        var fields = row.find('td.totaler-field input');
        row.find('.row-total').html("$" + ($(fields[0]).val() * $(fields[1]).val()));

        updateTotal();
    });

    $('button#add-row').click(function() {
        var $rows = $('form').find('tr.item-row');

        var count = $rows.length;
        var row = $($rows[0]).clone().insertAfter($rows[count - 1]);

        $(row).hide()
            .find('input')
            .attr('name', function(i, val) {
                return val.replace(count - 1, count);
            })
            .val('');
        $(row).slideDown(1000);
    });
});