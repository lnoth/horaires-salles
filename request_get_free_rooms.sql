SELECT name from rooms where room_id NOT IN (
	SELECT room_id
	FROM registrations
	NATURAL JOIN timeslots_registrations JOIN timeslots on timeslots_registrations.timeslot_id = timeslots.timeslot_id 
	WHERE (timeslots.timeslot_id in (6))
)