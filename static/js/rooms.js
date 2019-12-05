$(function() {
    $('#timetable_room_search').click(function() {
       $.get('api.php', {
           action: 'get_room_timetable',
           roomId: $('#timetable_room_choice').val()
       })
       .done(function(result) {
           if (result.includes('Error : ') && !result.includes('<')) {
               $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto alert alert-danger">' + result + '</div></div>');
           } else {
               $('#search_results').html(result);
           }
       })
       .fail(function() {
           $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto alert alert-danger">Error : results unavailable</div></div>');
       });
    });
});
