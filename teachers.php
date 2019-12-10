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
						<h1>Disponibilité des profs</h1>
					</div>
					<div class="form-group row mt-3">
						<label for="timetable_teachers_choice" class="col-sm-4 col-form-label">Choix&nbsp;du&nbsp;professeur</label>
						<div class="col-sm-8">
							<select id="timetable_teachers_choice" class="form-control">
                                <?php foreach($db->get_all_teachers() as $t) { ?>
                                    <option value="<?= $t['teacher_id'] ?>">
                                        <?= $t['name'] . ' (' . $t['acronym'] . ')' ?>
                                    </option>
                                <?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row text-center mt-3">
						<div class="col">
							<button id="timetable_teachers_search" class="btn btn-primary">Rechercher</button>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div id="search_results"></div>
        <script src="static/js/teachers.js"></script>
	</body>
</html>



