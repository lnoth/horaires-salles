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
						<h1>Horaire par classe</h1>
					</div>
					<div class="form-group row mt-3">
						<label for="timetable_class_choice" class="col-sm-4 col-form-label">Choix de la classe</label>
						<div class="col-sm-8">
							<select id="timetable_class_choice" class="form-control">
                                <?php foreach($db->get_all_classes() as $c) { ?>
                                    <option value="<?= $c['class_id'] ?>">
                                        <?= $c['name'] ?>
                                    </option>
                                <?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group row text-center mt-3">
						<div class="col">
							<button id="timetable_class_search" class="btn btn-primary">Rechercher</button>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div id="search_results"></div>
        <script src="static/js/index.js"></script>
	</body>
</html>



