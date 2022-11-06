<?php 
include 'config.php';
if(isset($_POST['submit'])){
    // $name = $_POST['nom'];
    // $name = filter_var($name, FILTER_SANITIZE_STRING);

    // $username = $_POST['prenom'];
    // $username = filter_var($username, FILTER_SANITIZE_STRING);
    // $mtr = $_POST["mtr"];
    // $mtr = firter_var($mtr, FILTER_SANITIZE_STRING);

    $mail = $_POST['mail'];
    // $mail1 = filter_var($mail, FILTER_SANITIZE_STRING);

    // $role = $_POST['role'];
    // $role = filter_var($role, FILTER_SANITIZE_STRING);

    $mdp =$_POST['mdp'];
    // $mdp1 = filter_var($mdp, FILTER_SANITIZE_STRING);
    


    $select = $conn->prepare("SELECT * FROM `users` WHERE mail =? AND mdp =?" );
    $select->execute([$mail,$mdp]);
    $row = $select->fetch(PDO::FETCH_ASSOC);




    if($select->rowCount() > 0){
       if($row['roles'] == 'admin'){
        $_SESSION [ 'admin_id'] = $row['id'];
        header('Location:admin_page.php');
       }
       
       elseif($row['roles'] == 'user'){
        $_SESSION [ 'user_id'] = $row['id'];
        header('Location:user_page.php');


       }
       else{
        $message[]= 'existe pas';

       }

    }
    else{
       $message[]= 'email ou mot de passe incorrect';

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
                <!-- <input type="text" placeholder="Nom" class="box"name="nom"> -->
                <!-- <input type="text" placeholder="Prénom" class="box" name="prenom"> -->
                <!-- <input type="text" placeholder="Matricule" class="box" name="mtr"> -->
                <input type="email" placeholder="Email"class="box" name="mail">
                <!-- <input type="text" placeholder="Role"class="box" name="role"> -->
                <input type="password" placeholder="Mot de passe" class="box" name="mdp">
                <!-- <input type="password"placeholder="Confirmer Mot de passe"class= "box" name="mdp2"> -->
                <!-- <input type="file" name="image" class ="box"accept= "image/jpg, image/png, image/jpeg"> -->
                
                <p>Vous avez un compte?<a href = "register.php"> Inscrire</a></p>
                <input type="submit" value="S'inscrire" class="btn" name="submit">

             </form>
    </section>
</body>

</html>