<?php

class DB extends PDO {
    public $db;

    public function __construct() {
        try {
            parent::__construct('mysql:host=pyme.ch;dbname=horaires-salles;charset=utf8', 'admin_horaires', 'Cs#3jt87');
            // parent::__construct('mysql:host=localhost;dbname=horaires-salles;charset=utf8', 'root', 'root');
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

    function get_all_teachers() {
        return $this->query('SELECT teacher_id, name, acronym, desktop, phone, email FROM teachers');
    }

    function get_all_weekdays() {
        return $this->query('SELECT weekday_id, name_fr, name_de, name_en FROM weekdays');
    }

    function get_timeslots_infos() {
        $query = 'SELECT timeslot_id,
               start_hour,
               end_hour,
               start_minute,
               end_minute,
               CONCAT(LPAD(timeslots.start_hour, 2, \'0\'), \':\', LPAD(timeslots.start_minute, 2, \'0\')) AS start_hour_str,
               CONCAT(LPAD(timeslots.end_hour, 2, \'0\'), \':\', LPAD(timeslots.end_minute, 2, \'0\')) AS end_hour_str
        FROM timeslots';

        $results = array();
        foreach ($this->query($query) as $result) {
            $results['id_'.$result['timeslot_id']] = array(
                'timeslot_id' => $result['timeslot_id'],
                'start_hour' => $result['start_hour'],
                'end_hour' => $result['end_hour'],
                'start_minute' => $result['start_minute'],
                'end_minute' => $result['end_minute'],
                'start_hour_str' => $result['start_hour_str'],
                'end_hour_str' => $result['end_hour_str']
            );
        }

        return $results;
    }

    function get_teachers_infos() {
        $query = 'SELECT acronym, desktop, email, name, phone, teacher_id FROM teachers';

        $results = array();
        foreach ($this->query($query) as $result) {
            $results['id_'.$result['teacher_id']] = array(
                'acronym' => $result['acronym'],
                'desktop' => $result['desktop'],
                'email' => $result['email'],
                'name' => $result['name'],
                'phone' => $result['phone']
            );
        }

        return $results;
    }

    function get_room_timetable($roomId) {
        $query = 'SELECT * FROM (SELECT GROUP_CONCAT(DISTINCT classes.name
                    ORDER BY classes.class_id SEPARATOR \'%;%\') AS classes_names,
               weekdays.name_fr AS weekday_name,
               LOWER(weekdays.name_en) AS weekday_name_en,
               weekdays.weekday_id AS weekday_id,
               registrations.registration_id AS registration_id,
               GROUP_CONCAT(DISTINCT timeslots.timeslot_id
                            ORDER BY timeslots.timeslot_id SEPARATOR \'%;%\') AS timeslots_ids,
               GROUP_CONCAT(DISTINCT teachers.teacher_id
                            ORDER BY teachers.name SEPARATOR \'%;%\') AS teachers_ids,
               courses.name AS course_name,
               courses.course_id,
               rooms.name AS room_name
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
        WHERE rooms.room_id = '.intval($roomId).'
        GROUP BY registrations.registration_id) r1
        ORDER BY weekday_id, timeslots_ids';

        $timeslots_infos = $this->get_timeslots_infos();
        $teachers_infos = $this->get_teachers_infos();
        $concerned_weekdays = array();
        $results = array();

        foreach ($this->query($query) as $result) {
            $timeslots = array();
            foreach (explode('%;%', $result['timeslots_ids']) as $timeslot_id) {
                array_push($timeslots, $timeslots_infos['id_'.$timeslot_id]);
            }

            $teachers = array();
            foreach (explode('%;%', $result['teachers_ids']) as $teacher_id) {
                array_push($teachers, $teachers_infos['id_'.$teacher_id]);
            }

            if (!array_key_exists($result['weekday_name_en'], $concerned_weekdays)) {
                $concerned_weekdays[$result['weekday_name_en']] = array(
                    'weekday_id' => intval($result['weekday_id']),
                    'weekday_name' => $result['weekday_name'],
                    'weekday_name_en' => $result['weekday_name_en']
                );
            }

            array_push($results, array(
                'classes_names' => explode('%;%', $result['classes_names']),
                'course_id' => intval($result['course_id']),
                'course_name' => $result['course_name'],
                'weekday_id' => intval($result['weekday_id']),
                'weekday_name' => $result['weekday_name'],
                'weekday_name_en' => $result['weekday_name_en'],
                'room_name' => $result['room_name'],
                'timeslots' => $timeslots,
                'teachers' => $teachers,
            ));
        }

        $results['concerned_weekdays'] = $concerned_weekdays;
        return $results;
    }

    function get_class_timetable($classId) {
        $query = 'SELECT class_name,
            weekday_name,
            weekday_id,
            weekday_name_en,
            GROUP_CONCAT(DISTINCT registration_id
                         ORDER BY registration_id SEPARATOR \'%;%\') AS registrations_ids,
            GROUP_CONCAT(DISTINCT timeslot_ids SEPARATOR \'%;%\') AS timeslots_ids,
            GROUP_CONCAT(DISTINCT teacher_ids SEPARATOR \'%;%\') AS teachers_ids,
            course_id,
            course_name,
            GROUP_CONCAT(DISTINCT room_name
                         ORDER BY room_name SEPARATOR \'%;%\') AS room_names
        FROM
          (SELECT classes.name AS class_name,
                  weekdays.name_fr AS weekday_name,
                  LOWER(weekdays.name_en) AS weekday_name_en,
                  weekdays.weekday_id AS weekday_id,
                  registrations.registration_id AS registration_id,
                  GROUP_CONCAT(DISTINCT timeslots.timeslot_id
                               ORDER BY timeslots.timeslot_id SEPARATOR \'%;%\') AS timeslot_ids,
                  GROUP_CONCAT(DISTINCT teachers.teacher_id
                               ORDER BY teachers.name SEPARATOR \'%;%\') AS teacher_ids,
                  courses.name AS course_name,
                  courses.course_id,
                  rooms.name AS room_name
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
           WHERE classes.class_id = '.intval($classId).'
           GROUP BY registrations.registration_id) AS r1
        GROUP BY course_id,
                 weekday_id
        ORDER BY weekday_id, timeslots_ids';

        $timeslots_infos = $this->get_timeslots_infos();
        $teachers_infos = $this->get_teachers_infos();
        $concerned_weekdays = array();
        $results = array();

        foreach ($this->query($query) as $result) {
            $timeslots = array();
            foreach (explode('%;%', $result['timeslots_ids']) as $timeslot_id) {
                array_push($timeslots, $timeslots_infos['id_'.$timeslot_id]);
            }

            $teachers = array();
            foreach (explode('%;%', $result['teachers_ids']) as $teacher_id) {
                array_push($teachers, $teachers_infos['id_'.$teacher_id]);
            }

            if (!array_key_exists($result['weekday_name_en'], $concerned_weekdays)) {
                $concerned_weekdays[$result['weekday_name_en']] = array(
                    'weekday_id' => intval($result['weekday_id']),
                    'weekday_name' => $result['weekday_name'],
                    'weekday_name_en' => $result['weekday_name_en']
                );
            }

            array_push($results, array(
                'class_name' => $result['class_name'],
                'course_id' => intval($result['course_id']),
                'course_name' => $result['course_name'],
                'weekday_id' => intval($result['weekday_id']),
                'weekday_name' => $result['weekday_name'],
                'weekday_name_en' => $result['weekday_name_en'],
                'registrations_ids' => explode('%;%', $result['registrations_ids']),
                'room_names' => explode('%;%', $result['room_names']),
                'timeslots' => $timeslots,
                'teachers' => $teachers,
            ));
        }

        $results['concerned_weekdays'] = $concerned_weekdays;
        return $results;
    }

    function get_teachers_timetable($teacherId) {
        $query = 'SELECT weekday_name,
               weekday_name_en,
               weekday_id,
               registration_id,
               timeslot_ids,
               teacher_ids,
               course_name,
               course_id,
               GROUP_CONCAT(DISTINCT rooms_names SEPARATOR \'%;%\') AS room_names,
               GROUP_CONCAT(DISTINCT classes_names SEPARATOR \'%;%\') AS classes_names
        FROM
          (SELECT classes.name AS class_name,
                  weekdays.name_fr AS weekday_name,
                  LOWER(weekdays.name_en) AS weekday_name_en,
                  weekdays.weekday_id AS weekday_id,
                  registrations.registration_id AS registration_id,
                  GROUP_CONCAT(DISTINCT timeslots.timeslot_id
                               ORDER BY timeslots.timeslot_id SEPARATOR \'%;%\') AS timeslot_ids,
                  GROUP_CONCAT(DISTINCT teachers.teacher_id
                               ORDER BY teachers.name SEPARATOR \'%;%\') AS teacher_ids,
                  courses.name AS course_name,
                  courses.course_id,
                  GROUP_CONCAT(DISTINCT rooms.name
                               ORDER BY rooms.room_id SEPARATOR \'%;%\') AS rooms_names,
                  GROUP_CONCAT(DISTINCT classes.name
                               ORDER BY classes.class_id SEPARATOR \'%;%\') AS classes_names
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
           WHERE teachers.teacher_id = ' . intval($teacherId) . '
           GROUP BY registrations.registration_id,
                    rooms.room_id,
                    classes.class_id) AS r1
        GROUP BY timeslot_ids,
                 weekday_name,
                 weekday_name_en,
                 weekday_id,
                 registration_id,
                 timeslot_ids,
                 teacher_ids,
                 course_name,
                 course_id
        ORDER BY weekday_id, timeslot_ids';

        $timeslots_infos = $this->get_timeslots_infos();
        $concerned_weekdays = array();
        $results = array();

        foreach ($this->query($query) as $result) {
            $timeslots = array();
            foreach (explode('%;%', $result['timeslot_ids']) as $timeslot_id) {
                array_push($timeslots, $timeslots_infos['id_'.$timeslot_id]);
            }

            if (!array_key_exists($result['weekday_name_en'], $concerned_weekdays)) {
                $concerned_weekdays[$result['weekday_name_en']] = array(
                    'weekday_id' => intval($result['weekday_id']),
                    'weekday_name' => $result['weekday_name'],
                    'weekday_name_en' => $result['weekday_name_en']
                );
            }

            array_push($results, array(
                'classes_names' => explode('%;%', $result['classes_names']),
                'course_id' => intval($result['course_id']),
                'course_name' => $result['course_name'],
                'weekday_id' => intval($result['weekday_id']),
                'weekday_name' => $result['weekday_name'],
                'weekday_name_en' => $result['weekday_name_en'],
                'registrations_ids' => explode('%;%', $result['registrations_ids']),
                'room_names' => explode('%;%', $result['room_names']),
                'timeslots' => $timeslots,
            ));
        }

        $results['concerned_weekdays'] = $concerned_weekdays;
        return $results;
    }

    function get_rooms_available($weekdayId, $timeslotStart, $timeslotEnd) {
        $query = 'SELECT name, description FROM rooms
        WHERE room_id NOT IN
            (SELECT room_id
             FROM registrations
             JOIN timeslots_registrations ON timeslots_registrations.registration_id = registrations.registration_id
             JOIN timeslots ON timeslots_registrations.timeslot_id = timeslots.timeslot_id
             WHERE (registrations.weekday_id = '. intval($weekdayId) .' 
             AND timeslots.timeslot_id BETWEEN '. intval($timeslotStart) .' AND '. intval($timeslotEnd) .'))
        ORDER BY name';

        $results = array();
        foreach ($this->query($query) as $result) {
            array_push($results, array(
                'name' => $result['name'],
                'description' => $result['description']
            ));
        }
        return $results;
    }
}

$db = new DB();
