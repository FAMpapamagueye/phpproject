<?php 
include 'config.php';

if(isset($_POST['submit'])){
    $name = $_POST['nom'];
    // $name = filter_var($name, FILTER_SANITIZE_STRING);

    $username = $_POST['prenom'];
    // $username = filter_var($username, FILTER_SANITIZE_STRING);
    // $mtr = $_POST["mtr"];
    // $mtr = firter_var($mtr, FILTER_SANITIZE_STRING);

    $mail = $_POST['mail'];
    // $mail = filter_var($mail, FILTER_SANITIZE_STRING);

    // $role = $_POST['role'];
    // $role = filter_var($role, FILTER_SANITIZE_STRING);

    $mdp=$_POST['mdp'];
    // $mdp =filter_var(md5($mdp),FILTER_SANITIZE_STRING);
    $mdp2 =$_POST['mdp2'];
    // $mdp2 =filter_var(md5($mdp2),FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES ['image']['size'];
    $image_folder ='upload_img/'.$image;


    $select =$conn->prepare("SELECT * FROM `users` WHERE mail =?");
    $select->execute([$mail]);


    if($select->rowCount() > 0){
        $message[] = 'utilisteur existe';

    }else{
        if($mdp != $mdp2){
            $message[] = 'mot de passe non identique';

        }
        elseif ($image_size>2000000) {
            $message[] = 'la taille de l`image est large';
        }
        else{
            $insert=$conn->prepare('INSERT INTO users(nom,prenom,mail,mdp,image)VALUES (?,?,?,?,?)');
            $insert->execute([$name,$username,$mail,$mdp,$image]);
            echo"Entrée ajoutée dans la table".md5($mdp);
            
            if ($insert==true){
                move_uploaded_file($image_size, $image_folder);
                $message[]='enregistrer avec succées';
                header('Location:login.php');
            }
        }

    }
    



}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Inscription</title>
</head>

<body>

   <?php
   if(isset($message)){
    foreach ($message as $message){
        echo'
        <div class="message">
        <span>'.$message.'</span>
        <i class= "fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
    }
   }
   
   
   ?>
    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Inscription</h3>
                <input type="text" placeholder="Nom" class="box"name="nom">
                <input type="text" placeholder="Prénom" class="box" name="prenom">
                <!-- <input type="text" placeholder="Matricule" class="box" name="mtr"> -->
                <input type="mail" placeholder="Email"class="box" name="mail">
                <!-- <input type="text" placeholder="Role"class="box" name="role"> -->
                <input type="password"placeholder="Mot de passe" class="box" name="mdp">
                <input type="password"placeholder="Confirmer Mot de passe"class= "box" name="mdp2">
                <input type="file" name="image" class ="box"accept= "image/jpg, image/png, image/jpeg">
                
                <p>Vous avez un compte?<a href = "login.php"> Se connecter</a></p>
                <input type="submit" value="S'inscrire" class="btn" name="submit">

             </form>
    </section>
</body>

</html>