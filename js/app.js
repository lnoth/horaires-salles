$('.timeslot').click(function() {
    let timeslot_id = this.firstChild.id.replace('timeslot_', '');
    let el = $(this.firstChild);
    let period_selected = $('.period_selected');

    if (period_selected.length === 0) {
        el.addClass('period_selected');
        $('#search_button').prop('disabled', false);
    }

    else if (el.hasClass('period_selected') || period_selected.length > 1) {
        period_selected.each(function() {
            $(this).removeClass('period_selected');
        });
        $('#search_button').prop('disabled', true);
    }

    else {
        if (period_selected.length === 1) {
            let ts = [timeslot_id, period_selected.attr('id').replace('timeslot_', '')].sort();

            for (let i = ts[0]; i <= ts[1]; i++) {
                $('#timeslot_' + i).addClass('period_selected');
            }
            $('#search_button').prop('disabled', false);
        }
    }
});

$('#period_reset').click(function() {
    $('.period_selected').each(function() {
        $(this).removeClass('period_selected');
    });
    $('#search_button').prop('disabled', true);
});

$('#search_button').click(function(e) {
    e.preventDefault();
    let period_selected = $('.period_selected');
    let first_period = period_selected.first().attr('id').replace('timeslot_', '');
    let last_period = period_selected.last().attr('id').replace('timeslot_', '');
    let weekday_id = $('#weekday_id').val();

    jQuery.ajax({
        url: window.location.protocol + '//' + window.location.host + '/ajax_result.php',
        type: 'GET',
        data: {
            'f': first_period,
            'l': last_period,
            'wd': weekday_id,
        },
    })
    .done(function(data, textStatus, jqXHR) {
        let result = JSON.parse(data);
        let result_table = $('#result_table')
        result_table.html('<tr><th>Nom de la salle</th></tr>');
        result.forEach(function(element){
            result_table.append("<tr><td>" + element["name"] +"</td></tr>")
        });
        result_table.show();
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    })
});