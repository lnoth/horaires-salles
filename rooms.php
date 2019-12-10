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
				<div class="col-lg-6 col-md-10 mx-auto">
					<div class="form-group col text-center mt-3">
						<h1>Horaire par salle</h1>
					</div>
					<div class="form-group row mt-3">
						<label for="timetable_room_choice" class="col-sm-4 col-form-label">Choix de la salle</label>
						<div class="col-sm-8">
							<select id="timetable_room_choice" class="form-control">
                                <?php foreach($db->get_all_rooms() as $r) { ?>
                                    <option value="<?= $r['room_id'] ?>">
                                        <?= $r['name'] . ' (' . $r['description'] . ')' ?>
                                    </option>
                                <?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row text-center mt-3">
						<div class="col">
							<button id="timetable_room_search" class="btn btn-primary">Rechercher</button>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div id="search_results"></div>
        <script src="static/js/rooms.js"></script>
	</body>
</html>



