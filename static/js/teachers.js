$(function() {
    $('#timetable_teachers_search').click(function() {
       $.get('api.php', {
           action: 'get_teachers_timetable',
           teacherId: $('#timetable_teachers_choice').val()
       })
       .done(function(result) {
           if (result.includes('Error : ') && !result.includes('<')) {
               $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto mt-3 alert alert-danger">' + result + '</div></div>');
           } else if (!result.includes('<')) {
               $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto mt-3 alert alert-info">' + result + '</div></div>');
           } else {
               $('#search_results').html(result);
           }
       })
       .fail(function() {
           $('#search_results').html('<div class="d-flex"><div class="ml-auto mr-auto mt-3 alert alert-danger">Error : results unavailable</div></div>');
       });
    });
});
