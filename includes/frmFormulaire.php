<form action="index.php?page=formulaire" method="post">
    <label for="nom">Nom :</label><input type="text" id="nom" name="nom" value="<?php echo $nom;?>" /><br />
    <label for="prenom">Prénom :</label><input type="text" id="prenom" name="prenom"  value="<?php echo $prenom;?>" /><br />
    <label for="email">e-mail :</label><input type="text" id="email" name="email"  value="<?php echo $email;?>" /><br />
    <label for="password">Mot de passe :</label><input type="password" id="password" name="password" /><br />
    <label for="passwordverif">Vérification mot de passe :</label><input type="password" id="passwordverif" name="passwordverif" /><br />
    <input type="reset" value="Effacer" />
    <input type="submit" value="Clique-moi grand fou !" />
    <input type="hidden" name="frm" />
</form>