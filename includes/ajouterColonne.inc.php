<?php

// Ajouter colonne
try{
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ajoutColonne = "ALTER TABLE utilisateurs
    ADD dateinscription TIMESTAMP";
    
    $conn->exec($ajoutColonne);
}

catch(PDOException $e){
    die("Erreur :  " . $e->getMessage());
}

// Supprimer colonne
