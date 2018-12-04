<?php

    include "connect.php";

    $firstTimeslot = $_GET['f'];
    $lastTimeslot = $_GET['l'];
    $weekday = $_GET['wd'];
    //$building = $_GET['b'];

    $request = $bdd->prepare("
    SELECT name from rooms where room_id NOT IN (
	SELECT room_id
	FROM registrations
	NATURAL JOIN timeslots_registrations JOIN timeslots on timeslots_registrations.timeslot_id = timeslots.timeslot_id 
	WHERE ((timeslots.timeslot_id BETWEEN :firstTimeslot AND :lastTimeslot) AND weekday_id = :weekday)
    )");

    $request->execute(array(
        ":firstTimeslot" => $firstTimeslot,
        ":lastTimeslot" => $lastTimeslot,
        ":weekday" => $weekday
    ));

    $result = $request->fetchAll();

    $result = json_encode($result);
    echo $result;
?>

