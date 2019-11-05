<?php

if (!isset($_GET['classId'])) {
    die('Error : no classId specified');
}
if (intval($_GET['classId'] === 0)) {
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
            <li class="nav-item">
                <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week" aria-selected="true">
                    Toute la semaine
                </a>
            </li>
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
                    <?php foreach($class_timetable as $class_timeslot) {
                        if ($class_timeslot['weekday_name_en'] === $wname) { ?>
                            <tr>
                                <td><?= $class_timeslot['start_hour'] . ' - ' . $class_timeslot['end_hour'] ?></td>
                                <td><?= $class_timeslot['course_name'] ?></td>
                                <td><?= $class_timeslot['teacher_name'] ?></td>
                                <td><?= $class_timeslot['room_name'] ?></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <div class="text-center p-3 tab-pane fade show" id="week" role="tabpanel" aria-labelledby="week-tab">
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
                <?php $weekdays_shown = array();
                $isFirstWeekday = true;
                foreach($concerned_weekdays as $wname => $concerned_weekday) {
                    foreach($class_timetable as $class_timeslot) {
                        if ($class_timeslot['weekday_name_en'] === $wname) {
                            if (!array_key_exists($wname, $weekdays_shown)) {
                                $weekdays_shown[$wname] = true;
                                if (!$isFirstWeekday) { ?>
                                    <tr>
                                        <td></td><td></td><td></td><td></td><td></td>
                                    </tr>
                                <?php $isFirstWeekday = false;
                                } ?>
                                <tr>
                                    <td><?= $concerned_weekday[1] ?></td>
                                    <td><?= $class_timeslot['start_hour'] . ' - ' . $class_timeslot['end_hour'] ?></td>
                                    <td><?= $class_timeslot['course_name'] ?></td>
                                    <td><?= $class_timeslot['teacher_name'] ?></td>
                                    <td><?= $class_timeslot['room_name'] ?></td>
                                </tr>
                            <?php } else { ?>
                            <tr>
                                <td><?php if (!array_key_exists($wname, $weekdays_shown)) {
                                    $weekdays_shown[$wname] = true;
                                    echo $concerned_weekday[1];
                                } ?></td>
                                <td><?= $class_timeslot['start_hour'] . ' - ' . $class_timeslot['end_hour'] ?></td>
                                <td><?= $class_timeslot['course_name'] ?></td>
                                <td><?= $class_timeslot['teacher_name'] ?></td>
                                <td><?= $class_timeslot['room_name'] ?></td>
                            </tr><?php
                            }
                        }
                    }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
