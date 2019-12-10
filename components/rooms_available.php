<?php

if (!isset($_GET['weekdayId'])) {
    die('Error : no weekdayId specified');
}
if (intval($_GET['weekdayId']) === 0) {
    die('Error : wrong weekdayId');
}

if (!isset($_GET['timeslotStart'])) {
    die('Error : no timeslotStart specified');
}
if (intval($_GET['timeslotStart']) === 0) {
    die('Error : wrong timeslotStart');
}

if (!isset($_GET['timeslotEnd'])) {
    die('Error : no timeslotEnd specified');
}
if (intval($_GET['timeslotEnd']) === 0) {
    die('Error : wrong timeslotEnd');
}

$rooms_available = $db->get_rooms_available($_GET['weekdayId'], $_GET['timeslotStart'], $_GET['timeslotEnd']);

?>
<div class="container mt-3" style="background-color: white">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">Salle</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rooms_available as $room) { ?>
            <tr>
                <td><?= $room['name'] ?></td>
                <td><?= $room['description'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
