$(function () {
    $('.timeslot').click(function () {
        let timeslot_id = this.firstElementChild.id.replace('timeslot_', '');
        let el = $(this.firstElementChild);
        let period_selected = $('.period_selected');

        if (period_selected.length === 0) {
            el.addClass('period_selected');
            $('#rooms_available_search').prop('disabled', false);
        } else if (el.hasClass('period_selected') || period_selected.length > 1) {
            period_selected.each(function () {
                $(this).removeClass('period_selected');
            });
            $('#rooms_available_search').prop('disabled', true);
        } else {
            if (period_selected.length === 1) {
                let ts = [timeslot_id, period_selected.attr('id').replace('timeslot_', '')].sort();

                for (let i = ts[0]; i <= ts[1]; i++) {
                    $('#timeslot_' + i).addClass('period_selected');
                }
                $('#rooms_available_search').prop('disabled', false);
            }
        }
    });

    $('#period_reset').click(function () {
        $('.period_selected').each(function () {
            $(this).removeClass('period_selected');
        });
        $('#rooms_available_search').prop('disabled', true);
    });

    $('#rooms_available_search').click(function(e) {
        e.preventDefault();
        let period_selected = $('.period_selected');
        let first_period = period_selected.first().attr('id').replace('timeslot_', '');
        let last_period = period_selected.last().attr('id').replace('timeslot_', '');
        let weekday_id = $('#weekday_id').val();

        $.get('api.php', {
            action: 'get_rooms_available',
            weekdayId: weekday_id,
            timeslotStart: first_period,
            timeslotEnd: last_period
        })
            .done(function (result) {
                if (result.includes('Error : ') && !result.includes('<')) {
                    $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto mt-2 alert alert-danger">' + result + '</div></div>');
                } else {
                    $('#search_results').html(result);
                }
            })
            .fail(function () {
                $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto mt-2 alert alert-danger">Error : results unavailable</div></div>');
            });
    });
});
