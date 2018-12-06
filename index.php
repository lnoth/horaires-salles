<?php include('../connect.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horaires</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center mt-2">
            <h1 id="page_title">horaires-heia.ch</h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center mt-2">
            <form method="post">
                <div class="form-group">
                    <!--<div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="perolles" value="perolles">
                        <label class="form-check-label" for="perolles">Pérolles</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="arsenaux" value="arsenaux">
                        <label class="form-check-label" for="arsenaux">Arsenaux</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="autre" value="autre">
                        <label class="form-check-label" for="autre">Autres</label>
                    </div>-->
                </div>
                <div class="form-group">
                    <select class="form-control" id="weekday_id">
                        <?php
                        $results = $bdd->query('SELECT weekday_id, name_fr FROM weekdays');
                        foreach($results as $result) {
                            echo '<option value="'.$result['weekday_id'].'">'.$result['name_fr'].'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group text-center">
                    <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">
                        Choisir plage horaire
                    </button>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" id="search_button" disabled>Rechercher</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <table id="result_table" class="table table-striped mt-4" style="display: none;">
            <tr>
                <th>Nom de la salle</th>
            </tr>
        </table>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Périodes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-info text-center">
                        Cliquez sur la première heure, puis sur la deuxième heure que vous voulez réserver.
                    </div>
                    <table class="table table-striped">
                        <tbody>
                            <?php
                            $results = $bdd->query('
                                SELECT timeslot_id,
                                  CONCAT(LPAD(timeslots.start_hour, 2, \'0\'), \':\',
                                         LPAD(timeslots.start_minute, 2, \'0\'), \' - \',
                                         LPAD(timeslots.end_hour, 2, \'0\'), \':\',
                                         LPAD(timeslots.end_minute, 2, \'0\'))
                                  AS period
                                FROM timeslots');
                            foreach($results as $result) {
                                echo '<tr class="timeslot"><td id="timeslot_'. $result['timeslot_id'] .'" class="text-center">'. $result['period'] .'</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="period_reset">Réinitialiser</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Valider</button>
                </div>

            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>