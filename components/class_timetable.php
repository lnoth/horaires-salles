<?php

if (!isset($_GET['classId'])) {
    die('Error : no classId specified');
}
if (intval($_GET['classId']) === 0) {
    die('Error : wrong classId');
}

$ct = $db->get_class_timetable($_GET['classId']);
$concerned_weekdays = array();
$class_timetable = array();
foreach($ct as $res) {
    $concerned_weekdays[$res['weekday_name_en']] = array($res['weekday_id'], $res['weekday_name']);
    array_push($class_timetable, $res);
}

if (count($concerned_weekdays) === 0) {
    die('Error : no timetable found for this class');
}

// sort by timeslot_id
usort($class_timetable, function($x, $y) {
    return $x['timeslot_id'] - $y['timeslot_id'];
});

$registrations_table = array();
$timeslots_ids_keys = array();
$timeslots_ids = array();

foreach ($class_timetable as $ct) {
    $regId = 'id_'.$ct['registration_id'];
    $timeslotId = 'id_'.$ct['timeslot_id'];
    if (!array_key_exists($regId, $registrations_table)) {
        $registrations_table[$regId] = array();
    }
    if (!array_key_exists($timeslotId, $registrations_table[$regId])) {
        $timeslots_ids_keys[$timeslotId] = true;
        $registrations_table[$regId][$timeslotId] = array();
    }
    array_push($registrations_table[$regId][$timeslotId], $ct);
}

foreach($timeslots_ids_keys as $tkey=>$tval) {
    array_push($timeslots_ids, $tkey);
}
sort($timeslots_ids);

$activeWeekday = intval(date("N", time()));
$activeWeekdayInList = false;
while ($activeWeekdayInList === false) {
    foreach($concerned_weekdays as $concerned_weekday) {
        if (intval($concerned_weekday[0]) === $activeWeekday) {
            $activeWeekdayInList = true;
            break;
        }
    }
    if (!$activeWeekdayInList) {
        $activeWeekday %= 8;
        $activeWeekday++;
    }
}

?>
<div class="container mt-3" style="background-color: white">
    <div class="text-center p-3">
        <ul class="nav justify-content-center nav-tabs" id="myTab" role="tablist">
            <?php
            foreach($concerned_weekdays as $wname => $concerned_weekday) { ?>
                <li class="nav-item">
                    <a class="<?= intval($concerned_weekday[0]) === $activeWeekday ? 'nav-link active':'nav-link' ?>"
                       id="<?= $wname ?>-tab" data-toggle="tab" href="#<?= $wname ?>" role="tab"
                       aria-controls="<?= $wname ?>" aria-selected="true">
                        <?= $concerned_weekday[1] ?>
                    </a>
                </li>
            <?php } ?>
            <!--<li class="nav-item">
                <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week" aria-selected="true">
                    Toute la semaine
                </a>
            </li>-->
        </ul>
    </div>
    <div class="tab-content">
        <?php foreach($concerned_weekdays as $wname => $concerned_weekday) { ?>
            <div class="text-center p-3 tab-pane fade show<?= intval($concerned_weekday[0]) === $activeWeekday ? ' active':'' ?>"
                 id="<?= $wname ?>" role="tabpanel" aria-labelledby="<?= $wname ?>-tab">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Plage horaire</th>
                        <th scope="col">Cours</th>
                        <th scope="col">Enseignant(s)</th>
                        <th scope="col">Salle(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($registrations_table as $registration) {
                        foreach($timeslots_ids as $timeslot_id) {
                            if (array_key_exists($timeslot_id, $registration)) {
                                if ($registration[$timeslot_id][0]['weekday_name_en'] === $wname) {
                                    $teachers = array();
                                    foreach($registration[$timeslot_id] as $pr) {
                                        array_push($teachers, $pr['teacher_name']);
                                    }
                                    $el = $registration[$timeslot_id][0]; ?>
                                    <tr>
                                        <td><?= $el['start_hour'] . ' - ' . $el['end_hour'] ?></td>
                                        <td><?= $el['course_name'] ?></td>
                                        <td><!--<?php for ($i = 0; $i < count($teachers); $i++) {
                                            $teacher = $teachers[$i];
                                                echo $teacher;
                                                if ($i + 1 < count($teachers)) {
                                                    echo ', ';
                                                };
                                            }
                                        ?>-->
                                        <?= count($teachers) > 1 ? 'plusieurs professeurs' : $teachers[0] ?>
                                        </td>
                                        <td><?= $el['room_name'] ?></td>
                                    </tr>
                                <?php }
                            }
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <!--<div class="text-center p-3 tab-pane fade show" id="week" role="tabpanel" aria-labelledby="week-tab">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">Jour</th>
                    <th scope="col">Plage horaire</th>
                    <th scope="col">Cours</th>
                    <th scope="col">Enseignant</th>
                    <th scope="col">Salle</th>
                </tr>
                </thead>
                <tbody>
                    <tr></tr>
                </tbody>
            </table>
        </div>-->
    </div>
</div>
