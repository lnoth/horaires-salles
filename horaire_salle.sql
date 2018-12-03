SELECT registrations.registration_id, weekdays.name_fr, courses.name, registrations.room_id, rooms.name,
  CONCAT(LPAD(timeslots.start_hour, 2, '0'), ':',
         LPAD(timeslots.start_minute, 2, '0'), ' - ',
         LPAD(timeslots.end_hour, 2, '0'), ':',
         LPAD(timeslots.end_minute, 2, '0'))
  AS period
FROM registrations
JOIN courses ON registrations.course_id = courses.course_id
JOIN weekdays ON registrations.weekday_id = weekdays.weekday_id
JOIN rooms ON registrations.room_id = rooms.room_id
NATURAL JOIN timeslots_registrations
JOIN timeslots ON timeslots_registrations.timeslot_id = timeslots.timeslot_id
WHERE rooms.name = 'AR029';