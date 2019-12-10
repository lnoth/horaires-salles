<?php

include('db.php');

if (!isset($_GET['action'])) {
    die('Error : please specify more parameters');
}

switch($_GET['action']) {
    case 'get_class_timetable':
        include('components/class_timetable.php');
        break;
    case 'get_room_timetable':
        include('components/room_timetable.php');
        break;
    case 'get_teachers_timetable':
        include('components/teachers_timetable.php');
        break;
    case 'get_rooms_available':
        include('components/rooms_available.php');
        break;
    default:
        die('Error : action not recognized');
}

?>
