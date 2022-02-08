<?php

$serverName = "localhost";
$userName = "root";
$database = "exercice";
$userPassword = "";

try{
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT * FROM tets ORDER BY nom ASC");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $html = "<table>";
    $html .= "<tr>";
    $html .= "<th>ID utilisateur</th>";
    $html .= "<th>Nom</th>";
    $html .= "<th>Prenom</th>";
    $html .= "<th>Mail</th>";
    $html .= "<th>Date inscription</th>";
    $html .= "</tr>";

    for($i = 0 ; $i < count($resultat) ; $i++) {
        $html .= "<tr>";
        
        foreach($resultat[$i] as $key=>$value) {
            if($key != "mdp") {
                $html .= "<td>";
                if($key == "dateinscription") {
                    $date = date_create($value);
                    $html .= $date->format('d/m/Y H:i:s');
                } 
                else {
                    $html .= $value;
                }
                $html .= "</td>";
            }   
        }

        $html .= "</tr>";

    }

    $html .= "</table>";

    echo $html;
}

catch(PDOException $e){
    die("Erreur :  " . $e->getMessage());
}
