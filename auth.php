<?php 
include 'config.php';
var_dump($_POST['submit']);
if(isset($_POST['submit'])){
    $name = $_POST['nom'];
    // $name1 = filter_var($name, FILTER_SANITIZE_STRING);

    $username = $_POST['prenom'];
    // $username1 = filter_var($username, FILTER_SANITIZE_STRING);
    // $mtr = $_POST["mtr"];
    // $mtr = firter_var($mtr, FILTER_SANITIZE_STRING);

    $mail = $_POST['mail'];
    // $mail1 = filter_var($mail, FILTER_SANITIZE_STRING);

    // $role = "user";
    // $role = filter_var($role, FILTER_SANITIZE_STRING);

    $mdp = md5($_POST['mdp']);
    // $mdp1 = filter_var($mdp, FILTER_SANITIZE_STRING);
    $mdp2 = md5($_POST['mdp2']);
    // $mdp21 = filter_var($mdp2, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES ['image']['size'];
    $image_folder = 'upload_img/'.$image;

    $select = $conn->prepare("SELECT * FROM `users` WHERE mail =?");
    $select -> execute([$mail]);


    if($select->rowCount() > 0){
        $message[] = 'utilisteur existe';

    }
    else{
        if($mdp != $mdp2){
            $message[] = 'mot de passe non identique';

        }
        elseif ($image_size>2000000) {
            $message[] = 'la taille de l`image est large';
        }
        else{
            $insert = $conn-> prepare("
            INSERT INTO `users`(id,matricule, nom, prenom,mail,roles,mdp,image,etat, date_Ins, date_modif, date_archi )VALUES ('','',:nom,:prenom,:mail,'',:mdp,:image,'','','','')
            ");
            $insert->execute(array('prenom'=>$prenom,'nom'=>$nom,'mail'=>$mail,'mdp'=>$mdp,'image'=>$image));
            if ($insert){
                move_uploaded_file($image_size, $image_folder);
                $message[]= 'enregistrer avec succées';
                header('Location:login.php');
            }
        }

    }
    



}


?>

   