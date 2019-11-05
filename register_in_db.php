<?php

include('db.php');

$data = array();
eval('$data = ' . file_get_contents('raw_data.txt') . ';');

$days = array();
foreach($db->query('SELECT weekday_id, name_fr FROM weekdays') as $result) {
    $days[$result['name_fr']] = intval($result['weekday_id']);
}

$timeslots = array();
$tr_fields = ['start_hour', 'start_minute', 'end_hour', 'end_minute'];
foreach($db->query('SELECT * FROM timeslots') as $result) {
    array_push($timeslots, array_map('intval', $result));
}

$rooms = array();
foreach($db->query('SELECT room_id, name FROM rooms') as $result) {
    $rooms[$result['name']] = intval($result['room_id']);
}

$courses = array();
foreach($db->query('SELECT course_id, name FROM courses') as $result) {
    $courses[$result['name']] = intval($result['course_id']);
}

$classes = array();
foreach($db->query('SELECT class_id, name FROM classes') AS $result) {
    $classes[$result['name']] = intval($result['class_id']);
}

$teachers = array();
foreach($db->query('SELECT teacher_id, acronym FROM teachers') AS $result) {
    $teachers[$result['acronym']] = intval($result['teacher_id']);
}

function get_timeslot_data($timeslot) {
    $result = array();
    foreach(explode('-', $timeslot) as $start_end_time) {
        foreach(explode(':', $start_end_time) as $start_end_minute_hour) {
            array_push($result, $start_end_minute_hour);
        }
    }
    return $result;
}

function find_timeslot_id($timeslot_data) {
    global $tr_fields;
    global $timeslots;

    foreach($timeslots as $timeslot) {
        $is_right_id = true;
        foreach($timeslot_data as $key=>$data) {
            if ($timeslot[$tr_fields[$key]] != $data) {
                $is_right_id = false;
            }
        }
        if ($is_right_id) {
            return $timeslot['timeslot_id'];
        }
    }
}

$registrations = array();
$timeslots_registrations = array();
$timeslots_classes = array();
$timeslots_teachers = array();
$reg_id = 0;

foreach($data as $r) {
    $reg_id++;
    $result = array();
    $result['registration_id'] = $reg_id;
    $result['weekday_id'] = $days[$r['Jour']];
    $result['room_id'] = $rooms[$r['Salle']];
    $result['course_id'] = $courses[$r['Cours']];
    array_push($registrations, $result);

    foreach(explode(' ', $r['Heures']) as $timeslot) {
        array_push($timeslots_registrations, array(
            'registration_id' => $reg_id,
            'timeslot_id' => find_timeslot_id(get_timeslot_data($timeslot))
        ));
    }

    foreach(explode(' ', $r['Prof']) as $prof) {
        array_push($timeslots_teachers, array(
            'registration_id' => $reg_id,
            'teacher_id' => $teachers[$prof]
        ));
    }

    foreach(explode(' ', $r['Classe']) as $classe) {
        array_push($timeslots_classes, array(
            'registration_id' => $reg_id,
            'class_id' => $classes[$classe]
        ));
    }
}

// delete data
$db->query('DELETE FROM timeslots_registrations');
$db->query('DELETE FROM timeslots_classes');
$db->query('DELETE FROM timeslots_teachers');
$db->query('DELETE FROM registrations');

// update registrations in db
$registrations_query = 'INSERT INTO registrations(registration_id, weekday_id, room_id, course_id) VALUES ';
$reg_simple_array = array();

foreach ($registrations as $key=>$registration) {
    $registrations_query .= '(?, ?, ?, ?)'.(($key == count($registrations) - 1) ? ';':', ');

    foreach(['registration_id', 'weekday_id', 'room_id', 'course_id'] as $field) {
        array_push($reg_simple_array, $registration[$field]);
    }
}

// test
function boundQuery($db, $query, $values) {
    $ret = preg_replace_callback(
        "#(\\?)(?=(?:[^']|['][^']*')*$)#ms",
        // Notice the &$values - here, we want to modify it.
        function($match) use ($db, &$values) {
            if (empty($values)) {
                throw new PDOException('not enough values for query');
            }
            $value  = array_shift($values);

            // Handle special cases: do not quote numbers, booleans, or NULL.
            if (is_null($value)) return 'NULL';
            if (true === $value) return 'true';
            if (false === $value) return 'false';
            if (is_numeric($value)) return $value;

            // Handle default case with $db charset
            return $db->quote($value);
        },
        $query
    );
    if (!empty($values)) {
        throw new PDOException('not enough placeholders for values');
    }
    return $ret;
}

$db->prepare($registrations_query)->execute($reg_simple_array);

// update timeslots_registrations in db
$tr_query = 'INSERT INTO timeslots_registrations(timeslot_id, registration_id) VALUES ';
$tr_simple_array = array();

foreach ($timeslots_registrations as $key=>$tr) {
    $tr_query .= '(?, ?)'.(($key == count($timeslots_registrations) - 1) ? ';':', ');

    foreach(['timeslot_id', 'registration_id'] as $field) {
        array_push($tr_simple_array, $tr[$field]);
    }
}

$db->prepare($tr_query)->execute($tr_simple_array);

// update timeslots_classes in db
$tc_query = 'INSERT INTO timeslots_classes(class_id, registration_id) VALUES ';
$tc_simple_array = array();

foreach ($timeslots_classes as $key=>$tc) {
    $tc_query .= '(?, ?)'.(($key == count($timeslots_classes) - 1) ? ';':', ');

    foreach(['class_id', 'registration_id'] as $field) {
        array_push($tc_simple_array, $tc[$field]);
    }
}

$db->prepare($tc_query)->execute($tc_simple_array);

// update timeslots_teachers in db
$tt_query = 'INSERT INTO timeslots_teachers(teacher_id, registration_id) VALUES ';
$tt_simple_array = array();

foreach ($timeslots_teachers as $key=>$tt) {
    $tt_query .= '(?, ?)'.(($key == count($timeslots_teachers) - 1) ? ';':', ');

    foreach(['teacher_id', 'registration_id'] as $field) {
        array_push($tt_simple_array, $tt[$field]);
    }
}

$db->prepare($tt_query)->execute($tt_simple_array);
