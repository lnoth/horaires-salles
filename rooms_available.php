<!DOCTYPE html>
<html lang="fr">
    <?php include('db.php') ?>
    <?php include('components/head.php') ?>
	<body>
		<!-- Navigation bar -->
		<?php include('components/navbar.php'); ?>
		<!-- Main page component -->
		<div class="container mt-3 bg-white">
			<div class="row align-items-center">
				<div class="col-sm-6 mx-auto">
					<div class="form-group col text-center mt-3">
						<h1>Disponibilité des salles</h1>
					</div>
					<div class="form-group row mt-3">
						<!--<label for="weekday_choice" class="col-sm-4 col-form-label">Jour</label>-->
						<div class="col">
                            <div class="row">
                                <div class="col-sm mb-3">
                                    <select id="weekday_id" class="form-control">
                                        <?php foreach($db->get_all_weekdays() as $w) { ?>
                                            <option value="<?= $w['weekday_id'] ?>">
                                                <?= $w['name_fr'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group text-center">
                                        <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">
                                            Choisir plage horaire
                                        </button>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="form-group row text-center mt-3" style="position: relative; bottom: 16px;">
						<div class="col">
							<button id="rooms_available_search" class="btn btn-primary" disabled>Rechercher</button>
						</div>
					</div>
				</div>
			</div>
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
                            <?php foreach($db->get_timeslots_infos() as $t) { ?>
                                <tr class="timeslot">
                                    <td id="timeslot_<?= $t['timeslot_id'] ?>" class="text-center">
                                        <?= $t['start_hour_str'] . ' - ' . $t['end_hour_str'] ?>
                                    </td>
                                </tr>
                            <?php } ?>
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
        <div class="row">
            <div class="col"></div>
            <div id="search_results" class="col-sm-8"></div>
            <div class="col"></div>
        </div>
        <script src="static/js/rooms_available.js"></script>
	</body>
</html>



