$(document).ready(function() {
    $('td.totaler-field input').keyup(function() {
        var row = $(this).closest('tr');
        var fields = row.find('td.totaler-field input');
        row.find('.row-total').html("$" + ($(fields[0]).val() * $(fields[1]).val()));
    });

    $('button#add-row').click(function() {
        var $rows = $('form').find('tr.item-row');

        var count = $rows.length;
        var row = $($rows[0]).clone().insertAfter($rows[count - 1]);

        $(row).hide()
            .find('input')
            .attr('name', function(i, val) {
                return val.replace(count - 1, count);
            }).val(''); // it may copy values from first one
        $(row).slideDown(1000);
    });
});