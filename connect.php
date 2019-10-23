<?php

try {
    $bdd = new PDO('mysql:host=pyme.ch;dbname=horaires-salles;charset=utf8', 'admin_horaires', 'Cs#3jt87');

}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

