<h1>Inscription</h1>
<?php
if (isset($_POST['inscription'])) {
    $name = mb_strtoupper(trim($_POST['name'])) ?? '';
    $firstname = ucfirst(mb_strtolower(trim($_POST['firstname']))) ?? '';
    $email = mb_strtolower(trim($_POST['email'])) ?? '';
    $password = htmlentities(trim($_POST['password'])) ?? '';
    $passwordverif = htmlentities(trim($_POST['passwordverif'])) ?? '';
    $pseudo = htmlentities(trim($_POST['pseudo'])) ?? '';
    $bio = htmlentities(trim($_POST['bio'])) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', $name) !== 1)
        array_push($erreur, "Veuillez saisir votre nom");

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', $firstname) !== 1)
        array_push($erreur, "Veuillez saisir votre prénom");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (strlen($password) === 0)
        array_push($erreur, "Veuillez saisir un mot de passe");

    if (strlen($passwordverif) === 0)
        array_push($erreur, "Veuillez saisir la vérification de votre mot de passe");

    if ($password !== $passwordverif)
        array_push($erreur, "Vos mots de passe ne correspondent pas");

    if (strlen($pseudo) === 0)
        array_push($erreur, "Veuillez saisir un pseudo");

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        dump($_FILES['avatar']);
        $fileName = $_FILES['avatar']['name'];
        $fileType = $_FILES['avatar']['type'];
        $fileTmpName = $_FILES['avatar']['tmp_name'];
        
        $tableauTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($fileType, $tableauTypes)) {
            $path = getcwd() . "/avatars/";
            $date = date('Ymdhis');
            $fileName = $date . $fileName;
            if (move_uploaded_file($fileTmpName, $path . $fileName))
                echo "Fichier déplacé"; 
        }
        else {
            array_push($erreur, "Erreur type MIME");
        }
    } else {
        array_push($erreur, "Erreur upload " . $_FILES['avatar']['error']);
    }

    if (count($erreur) === 0) {
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "";

        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = $conn->prepare("
                INSERT INTO users(id_user, name, firstname, mail, pseudo, password, bio, avatar)
                VALUES (:id, :nom, :prenom, :mail, :pseudo, :mdp, :bio, :avatar)
            ");

            $id = null;
            $query->bindParam(':id', $id);
            $query->bindParam(':nom', $name);
            $query->bindParam(':prenom', $firstname);
            $query->bindParam(':mail', $email);
            $query->bindParam(':pseudo', $pseudo);
            $query->bindParam(':mdp', $password);
            $query->bindParam(':bio', $bio);
            $query->bindParam(':avatar', $avatar);
            $query->execute();


            echo "<p>Insertions effectuées</p>";
        } catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
    } else {
        $messageErreur = "<ul>";
        $i = 0;
        do {
            $messageErreur .= "<li>" . $erreur[$i] . "</li>";
            $i++;
        } while ($i < count($erreur));

        $messageErreur .= "</ul>";

        echo $messageErreur;
    }
} else {
    echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
    $name = $firstname = $email = $pseudo = $bio = '';
}

include 'frmInscription.php';
