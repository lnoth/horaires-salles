<?php

include('connect.php');

$data = array();
eval('$data = ' . file_get_contents('http://localhost:8888/horaires-salles/raw_data.txt') . ';');

$days = array();
foreach($bdd->query('SELECT weekday_id, name_fr FROM weekdays') as $result) {
    $days[$result['name_fr']] = intval($result['weekday_id']);
}

$timeslots = array();
$tr_fields = ['start_hour', 'start_minute', 'end_hour', 'end_minute'];
foreach($bdd->query('SELECT * FROM timeslots') as $result) {
    array_push($timeslots, array_map('intval', $result));
}

$rooms = array();
foreach($bdd->query('SELECT room_id, name FROM rooms') as $result) {
    $rooms[$result['name']] = intval($result['room_id']);
}

$courses = array();
foreach($bdd->query('SELECT course_id, name FROM courses') as $result) {
    $courses[$result['name']] = intval($result['course_id']);
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
}

// update registrations in db
$registrations_query = 'INSERT INTO registrations(registration_id, weekday_id, room_id, course_id) VALUES ';
$reg_simple_array = array();

foreach ($registrations as $key=>$registration) {
    $registrations_query .= '(?, ?, ?, ?)'.(($key == count($registrations) - 1) ? ';':', ');

    foreach(['registration_id', 'weekday_id', 'room_id', 'course_id'] as $field) {
        array_push($reg_simple_array, $registration[$field]);
    }
}

$bdd->query('DELETE FROM registrations');
$bdd->prepare($registrations_query)->execute($reg_simple_array);

// update timeslots_registrations in db
$tr_query = 'INSERT INTO timeslots_registrations(timeslot_id, registration_id) VALUES ';
$tr_simple_array = array();

foreach ($timeslots_registrations as $key=>$tr) {
    $tr_query .= '(?, ?)'.(($key == count($timeslots_registrations) - 1) ? ';':', ');

    foreach(['timeslot_id', 'registration_id'] as $field) {
        array_push($tr_simple_array, $tr[$field]);
    }
}

$bdd->query('DELETE FROM timeslots_registrations');
$bdd->prepare($tr_query)->execute($tr_simple_array);




