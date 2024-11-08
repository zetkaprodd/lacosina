<?php

class ContactController {

    function ajouter(){
        require_once(__DIR__.'/../Views/Contact/contact.php');
    }
    
    function enregistrer(){

        $nom = $_POST['nom'];
        $email = $_POST['mail'];
        $description = $_POST['description'];


        /** @var PDO $pdo */
        $pdo = new PDO('mysql:host=mysql8;dbname=lacosina', 'myuser', 'monpassword');
        
        $requete = $pdo->prepare('INSERT INTO contact (nom, email, description) VALUES (:nom, :email, :description)');
        $requete->bindParam(':nom',$nom);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':description', $description);

        $ajoutOk = $requete->execute();

        if($ajoutOk) {
            require_once(__DIR__.'/../Views/Contact/enregistrerContact.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de votre formulaire.';
        }
    }
}