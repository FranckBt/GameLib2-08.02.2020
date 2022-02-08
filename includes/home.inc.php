<h1>Bienvenue sur GameLib</h1>
<?php
if(isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $bienvenue = "<p>";
    $bienvenue .= "Bonjour ";
    $bienvenue .= $_SESSION['firstname'];
    $bienvenue .= " ";
    $bienvenue .= $_SESSION['name'];
    $bienvenue .= "</p>";
    echo $bienvenue;
}