<?php

session_start();

require_once(__DIR__.'/src/Models/connectDb.php');
require_once(__DIR__.'/src/Controllers/ContactController.php');
require_once(__DIR__.'/src/Controllers/RecetteController.php');
require_once(__DIR__.'/src/Controllers/UserController.php');
require_once(__DIR__.'/src/Views/header.php');


if(isset($_GET['c'])) {
    switch ($_GET['c']) {
        case 'contact':
            $contactController = new ContactController();
            $contactController->ajouter();
            break;

        case 'AjouterRecette':
            $recetteController = new RecetteController();
            $recetteController->ajouter();
            break;
        
        case 'enregistrer':
            $recetteController = new RecetteController();
            $recetteController->enregistrer();
            break;
        
        case 'enregisterContact':
            $contactController = new ContactController();
            $contactController->enregistrer();
            break;

        case 'recettes':
            $recetteController = new RecetteController();
            $recetteController->lister();
            break;

        case 'detail':
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $recetteController = new RecetteController();
                $recetteController->detail($_GET['id']);
            } else {
                echo "ID de recette invalide ou manquant.";
            }
            break;

        case 'modif':
            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id']; 
                $recetteController = new RecetteController();
                $recetteController->modifier($id);
            } else {
                echo "ID de recette invalide ou manquant.";
            }
            break;

        case 'inscription':
            $userController = new UserController();
            $userController->inscription();
            break;

        case 'inscrire':
            $userController = new UserController();
            $userController->enregistrer();
            break;

        case 'connexion':
            $userController = new UserController();
            $userController->connexion();
            break;
        
        case 'connecter':
            $userController = new UserController();
            $userController->verifieConnexion();
            break;
    
        case "deconnexion": {
            $userController = new UserController($pdo);
            $userController->deconnexion();

            break;
        }



        default:
            require_once(__DIR__.'/src/Controllers/homeController.php');
            break;
    }

} else {
    require_once(__DIR__.'/src/Controllers/homeController.php');
}

require_once(__DIR__.'/src/Views/footer.php');