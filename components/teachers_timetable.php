<?php

if (!isset($_GET['teacherId'])) {
    die('Error : no teacherId specified');
}
if (intval($_GET['teacherId']) === 0) {
    die('Error : wrong teacherId');
}

$teachers_timetable = $db->get_teachers_timetable($_GET['teacherId']);

if (count($teachers_timetable['concerned_weekdays']) === 0) {
    die('Error : no timetable found for this teacher');
}

$activeWeekday = intval(date("N", time()));
$activeWeekdayInList = false;
while ($activeWeekdayInList === false) {
    foreach($teachers_timetable['concerned_weekdays'] as $concerned_weekday) {
        if ($concerned_weekday['weekday_id'] === $activeWeekday) {
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
            foreach($teachers_timetable['concerned_weekdays'] as $wname => $concerned_weekday) { ?>
                <li class="nav-item">
                    <a class="<?= $concerned_weekday['weekday_id'] === $activeWeekday ? 'nav-link active':'nav-link' ?>"
                       id="<?= $wname ?>-tab" data-toggle="tab" href="#<?= $wname ?>" role="tab"
                       aria-controls="<?= $wname ?>" aria-selected="true">
                        <?= $concerned_weekday['weekday_name'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-content">
        <?php foreach($teachers_timetable['concerned_weekdays'] as $wname => $concerned_weekday) { ?>
            <div class="text-center p-3 tab-pane fade show<?= $concerned_weekday['weekday_id'] === $activeWeekday ? ' active':'' ?>"
                 id="<?= $wname ?>" role="tabpanel" aria-labelledby="<?= $wname ?>-tab">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Plage horaire</th>
                        <th scope="col">Cours</th>
                        <th scope="col">Classe(s)</th>
                        <th scope="col">Salle(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($teachers_timetable as $timetable) {
                        if ($timetable['weekday_id'] === $concerned_weekday['weekday_id']) {
                            foreach ($timetable['timeslots'] as $timeslot) { ?>
                                <tr>
                                    <td><?= $timeslot['start_hour_str'].' - '.$timeslot['end_hour_str'] ?></td>
                                    <td><?= $timetable['course_name'] ?></td>
                                    <td><?php for ($i = 0; $i < count($timetable['classes_names']); $i++) {
                                        echo $timetable['classes_names'][$i];
                                        if ($i + 1 < count($timetable['classes_names'])) {
                                            echo ', ';
                                        }
                                    } ?>
                                    </td>
                                    <td><?php for ($i = 0; $i < count($timetable['room_names']); $i++) {
                                            echo $timetable['room_names'][$i];
                                            if ($i + 1 < count($timetable['room_names'])) {
                                                echo ', ';
                                            }
                                        } ?>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
