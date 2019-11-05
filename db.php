<?php

class DB extends PDO {
    public $db;

    public function __construct() {
        try {
            parent::__construct('mysql:host=pyme.ch;dbname=horaires-salles;charset=utf8', 'admin_horaires', 'Cs#3jt87');
        } catch (Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }

    function get_all_rooms() {
        return $this->query('SELECT room_id, name, description FROM rooms');
    }

    function get_all_classes() {
        return $this->query('SELECT class_id, name FROM classes');
    }

    function get_class_timetable($classId) {
        return $this->query('SELECT classes.name AS class_name, weekdays.name_fr AS weekday_name, 
          LOWER(weekdays.name_en) AS weekday_name_en, weekdays.weekday_id AS weekday_id,
          registrations.registration_id AS registration_id, timeslots.timeslot_id AS timeslot_id,
          CONCAT(LPAD(timeslots.start_hour, 2, \'0\'), \':\', LPAD(timeslots.start_minute, 2, \'0\')) AS start_hour, 
          CONCAT(LPAD(timeslots.end_hour, 2, \'0\'), \':\', LPAD(timeslots.end_minute, 2, \'0\')) AS end_hour,
          courses.name AS course_name, teachers.name AS teacher_name, rooms.name AS room_name
          FROM classes
          JOIN timeslots_classes ON classes.class_id = timeslots_classes.class_id
          JOIN timeslots_registrations ON timeslots_registrations.registration_id = timeslots_classes.registration_id
          JOIN timeslots_teachers ON timeslots_teachers.registration_id = timeslots_classes.registration_id
          JOIN teachers ON timeslots_teachers.teacher_id = teachers.teacher_id
          JOIN registrations ON timeslots_classes.registration_id = registrations.registration_id
          JOIN courses ON registrations.course_id = courses.course_id
          JOIN rooms ON registrations.room_id = rooms.room_id
          JOIN timeslots ON timeslots_registrations.timeslot_id = timeslots.timeslot_id
          JOIN weekdays ON registrations.weekday_id = weekdays.weekday_id
          WHERE classes.class_id = '.intval($classId).' ORDER BY weekdays.weekday_id');
    }
}

$db = new DB();
