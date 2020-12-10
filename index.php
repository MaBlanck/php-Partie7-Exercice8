<?php
$isCivility = true;
$isFirstname = true;
$isLastname = true;
$civility = NULL;
$firstname = NULL;
$lastname = NULL;

if ($_POST) //si $_POST contient au moins une donnée, donc TRUE
{
    if (isset($_POST['civility'])) //Si le paramètre civility existe dans l'URL
    {
        if ($_POST['civility'] != '') //ON vérifie si le champs n'est pas vide
        {

            $civility = $_POST['civility']; //Si il n'est pas vide, la variable $civility va contenir la valeur insérée
        } else {
            $isCivility = false; //Sinon, la variable est vide et un message demande de le remplir
        }
    } else { //Si le paramètre civility n'existe pas, un message d'erreur est envoyé
        echo 'Requête GET incorrect';
        exit();
    }
    if (isset($_POST['firstname'])) //Si le paramètre firstname existe dans l'URL
    {
        if ($_POST['firstname'] != '') //On vérifie si le champs n'est pas vide
        {
            $firstname = $_POST['firstname']; //Si il n'est pas vide, la variable $firstname va contenir la valeur insérée
        } else {
            $isFirstname = false; //Sinon, la variable est vide et un message demande de le remplir
        }
    } else { //Si le paramètre firstname n'existe pas, un message d'erreur est envoyé
        echo 'Requête GET incorrect';
        exit();
    }
    if (isset($_POST['lastname'])) {
        if ($_POST['lastname'] != '') {
            $lastname = $_POST['lastname'];
        } else {
            $isLastname = false;
        }
    } else {
        echo 'Requête GET incorrect';
        exit();
    }
}
$valid_extension = '';
$extension_upload = '';
$authorized_extensions = array('pdf');
if ($_FILES) {
    //test si le fichier a bien été envoyé et s'il n'y a pas d'erreurs
    if (isset($_FILES['myFile']) && $_FILES['myFile']['error'] == 0) {      //test si le fichier n'est pas trop gros
        if ($_FILES['myFile']['size'] <= 1000000) {   //on récupère l'extension et son le nom du fichier grâce à la fonction pathinfo() qu'on stocke dans extension_upload
            $fileInfo = pathinfo($_FILES['myFile']['name']);
            $extension_upload = $fileInfo['extension'];
            $filename = $fileInfo['filename'];
            $valid_extension = in_array($extension_upload, $authorized_extensions) ? '' : 'L\'extension du fichier n\'est pas valide'; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exercice 8 Partie 7</title>
</head>

<body>
    <h1>Exercice 8 Partie 7</h1>

    <?php if ($_POST && $isCivility && $isFirstname && $isLastname && (in_array($extension_upload, $authorized_extensions))) : ?>
        <p><?= 'Hello' . ' ' . $civility . ' ' . $lastname . ' ' . $firstname ?></p>
        <p><?= $filename . ' ' . $extension_upload ?></p>
        <p><?= 'Fichier bien envoyé' ?></p>
    <?php else : ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Formulaire</legend>
                <select name="civility" id="civility">
                    <option value="Monsieur">Mr</option>
                    <option value="Madame">Mme</option>
                </select>
                <p><?= $isCivility ? '' : 'Veuillez renseigner votre civilité'; ?></p>
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" value="<?= $lastname ?>">
                <p><?= $isFirstname ? '' : 'Veuillez renseigner votre prénom'; ?></p>
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" value=" <?= $firstname ?>">
                <p><?= $isLastname ? '' : 'Veuillez renseigner votre nom'; ?></p>
                <input type="file" name="myFile">
                <p><?= $valid_extension ?></p>
                <input type="submit" value="submit">
            </fieldset>
        </form>
    <?php endif ?>

</body>

</html>