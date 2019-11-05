<?php

include('db.php');

if (!isset($_GET['action'])) {
    die('Error : please specify more parameters');
}

switch($_GET['action']) {
    case 'get_class_timetable':
        include('components/class_timetable.php');
        break;
    default:
        die('Error : action not recognized');
}

?>
