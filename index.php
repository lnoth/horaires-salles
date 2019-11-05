<!DOCTYPE html>
<html>
	<head>
		<title>Horaires</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</head>
	<body>
		<!-- Navigation bar -->
		<?php include('components/navbar.php'); ?>
		<!-- Main page component -->
		<div class="container mt-3 bg-white">
			<div class="row align-items-center">
				<form class="col-sm-6 mx-auto">
					<div class="form-group col text-center mt-3">
						<h1>Horaire par classe</h1>
					</div>
					<div class="form-group row mt-3">
						<label for="classChoice" class="col-sm-4 col-form-label">Choix de la classe</label>
						<div class="col-sm-8">
							<select id="classChoice" class="form-control">
								<option>Large select</option>
							</select>
						</div>
					</div>
					<div class="form-group row text-center mt-3">
						<div class="col">
							<button type="submit" class="btn btn-primary">Rechercher</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="container mt-3" style="background-color: white">
			<div class="text-center mt-3 p-3">
				<h1>Résultat de la recherche</h1>
			</div>
			<div class="text-center p-3">
				<p class="alert alert-danger">Aucune recherche en cours actuellement.</p>
			</div>

			<div class="text-center p-3">
				<ul class="nav justify-content-center nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="monday-tab" data-toggle="tab" href="#monday" role="tab" aria-controls="monday" aria-selected="true">Lundi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tuesday-tab" data-toggle="tab" href="#tuesday" role="tab" aria-controls="tuesday" aria-selected="true">Mardi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="wednesday-tab" data-toggle="tab" href="#wednesday" role="tab" aria-controls="wednesday" aria-selected="true">Mercredi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="thursday-tab" data-toggle="tab" href="#thursday" role="tab" aria-controls="thursday" aria-selected="true">Jeudi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="friday-tab" data-toggle="tab" href="#friday" role="tab" aria-controls="friday" aria-selected="true">Vendredi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week" aria-selected="true">Toute la semaine</a>
					</li>
				</ul>
			</div>
			<div class="tab-content" id="myTabContent">
				<div class="text-center p-3 tab-pane fade show active" id="monday" role="tabpanel" aria-labelledby="monday-tab">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th scope="col">Plage horaire</th>
								<th scope="col">Cours</th>
								<th scope="col">Enseignant</th>
								<th scope="col">Salle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>08:15 - 09:00</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>09:05 - 09:50</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>10:15 - 11:00</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>11:05 - 11:50</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:00 - 13:45</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:50 - 14:35</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:00 - 15:45</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:50 - 16:35</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center p-3 tab-pane fade show" id="tuesday" role="tabpanel" aria-labelledby="tuesday-tab">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th scope="col">Plage horaire</th>
								<th scope="col">Cours</th>
								<th scope="col">Enseignant</th>
								<th scope="col">Salle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>08:15 - 09:00</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>09:05 - 09:50</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>10:15 - 11:00</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>11:05 - 11:50</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:00 - 13:45</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:50 - 14:35</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:00 - 15:45</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:50 - 16:35</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center p-3 tab-pane fade show" id="wednesday" role="tabpanel" aria-labelledby="wednesday-tab">
					<table class="table table-striped table-bordered">
						<thead>
						<tr>
							<th scope="col">Plage horaire</th>
							<th scope="col">Cours</th>
							<th scope="col">Enseignant</th>
							<th scope="col">Salle</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td>08:15 - 09:00</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>09:05 - 09:50</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>10:15 - 11:00</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>11:05 - 11:50</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:00 - 13:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:50 - 14:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>AR033</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center p-3 tab-pane fade show" id="thursday" role="tabpanel" aria-labelledby="thursday-tab">
					<table class="table table-striped table-bordered">
						<thead>
						<tr>
							<th scope="col">Plage horaire</th>
							<th scope="col">Cours</th>
							<th scope="col">Enseignant</th>
							<th scope="col">Salle</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td>08:15 - 09:00</td>
								<td>Gestion de projet TIC</td>
								<td>Omar Abou Khaled</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>09:05 - 09:50</td>
								<td>Gestion de projet TIC</td>
								<td>Omar Abou Khaled</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>10:15 - 11:00</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>11:05 - 11:50</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:00 - 13:45</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>13:50 - 14:35</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:00 - 15:45</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td>15:50 - 16:35</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center p-3 tab-pane fade show" id="friday" role="tabpanel" aria-labelledby="friday-tab">
					<table class="table table-striped table-bordered">
						<thead>
						<tr>
							<th scope="col">Plage horaire</th>
							<th scope="col">Cours</th>
							<th scope="col">Enseignant</th>
							<th scope="col">Salle</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td>08:15 - 09:00</td>
								<td>Bases de données 1</td>
								<td>Houda Chabbi</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td>09:05 - 09:50</td>
								<td>Bases de données 1</td>
								<td>Houda Chabbi</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td>10:15 - 11:00</td>
								<td>Statistiques</td>
								<td>Thomas Clercr</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td>11:05 - 11:50</td>
								<td>Statistiques</td>
								<td>Thomas Clerc</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td>13:00 - 13:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td>13:50 - 14:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td>15:00 - 15:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td>15:50 - 16:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
						</tbody>
					</table>
				</div>
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
							<tr>
								<td>Lundi</td>
								<td>08:15 - 09:00</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>09:05 - 09:50</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>10:15 - 11:00</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>11:05 - 11:50</td>
								<td>Programmation Concurente</td>
								<td>Francois Kilchoer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:00 - 13:45</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:50 - 14:35</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:00 - 15:45</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:50 - 16:35</td>
								<td>Algorithmique 2</td>
								<td>Frédéric Bapst</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Mardi</td>
								<td>08:15 - 09:00</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>09:05 - 09:50</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>10:15 - 11:00</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>11:05 - 11:50</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:00 - 13:45</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:50 - 14:35</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:00 - 15:45</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:50 - 16:35</td>
								<td>Systèmes Embarqués</td>
								<td>Daniel Gachet</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Mercredi</td>
								<td>08:15 - 09:00</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>09:05 - 09:50</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>10:15 - 11:00</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>11:05 - 11:50</td>
								<td>Systèmes d'exploitation 1 & TP</td>
								<td>Damien Goetschi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:00 - 13:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:50 - 14:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Jeudi</td>
								<td>08:15 - 09:00</td>
								<td>Gestion de projet TIC</td>
								<td>Omar Abou Khaled</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>09:05 - 09:50</td>
								<td>Gestion de projet TIC</td>
								<td>Omar Abou Khaled</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>10:15 - 11:00</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>11:05 - 11:50</td>
								<td>Mathématique Spécifique 1</td>
								<td>Roseline NussBaumer</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:00 - 13:45</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>13:50 - 14:35</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:00 - 15:45</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td>15:50 - 16:35</td>
								<td>TP Bases de données</td>
								<td>Houda Chabbi</td>
								<td>AR033</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Vendredi</td>
								<td>08:15 - 09:00</td>
								<td>Bases de données 1</td>
								<td>Houda Chabbi</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td></td>
								<td>09:05 - 09:50</td>
								<td>Bases de données 1</td>
								<td>Houda Chabbi</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td></td>
								<td>10:15 - 11:00</td>
								<td>Statistiques</td>
								<td>Thomas Clercr</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td></td>
								<td>11:05 - 11:50</td>
								<td>Statistiques</td>
								<td>Thomas Clerc</td>
								<td>C2006</td>
							</tr>
							<tr>
								<td></td>
								<td>13:00 - 13:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td></td>
								<td>13:50 - 14:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td></td>
								<td>15:00 - 15:45</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
							<tr>
								<td></td>
								<td>15:50 - 16:35</td>
								<td>Génie logiciel 1 & TP</td>
								<td>Pierre Kuonen</td>
								<td>D2018</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>



