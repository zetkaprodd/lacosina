<?php

class RecetteController {

    function ajouter(){
        require_once(__DIR__.'/../Views/Recettes/ajout.php');
    }

    function enregistrer(){
        
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $auteur = $_POST['auteur'];
        $image = $_POST['image'];

        /** @var PDO $pdo **/
        $pdo = new PDO('mysql:host=mysql8;dbname=lacosina', 'myuser', 'monpassword');

        $requete = $pdo->prepare('INSERT INTO recettes (titre, description, auteur, date_creation, image) VALUES (:titre, :description, :auteur,  NOW(), :image)');
        $requete->bindParam(':titre',$titre);
        $requete->bindParam(':description', $description);
        $requete->bindParam(':auteur', $auteur);
        $requete->bindParam(':image', $image);

        $ajoutOk = $requete->execute();

        if($ajoutOk) {
            require_once(__DIR__.'/../Views/Recettes/enregistrer.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de la recette.';
        }
    }
    
    function lister(){

        /** @var PDO $pdo */
        $pdo = new PDO('mysql:host=mysql8;dbname=lacosina', 'myuser', 'monpassword');
        
        $requete = $pdo->prepare("SELECT * FROM recettes");

        $requete->execute();
        $recipes = $requete->fetchAll(PDO::FETCH_ASSOC);

        require_once(__DIR__.'/../Views/Recettes/liste.php');
    }

    function detail($pdo, $id){

        /** @var PDO $pdo **/

        $requete = $pdo->prepare("SELECT * FROM recettes WHERE id = :id");
        $requete->bindParam(':id', $id);

        $requete->execute();
        $recipe = $requete->fetch(PDO::FETCH_ASSOC);

        require_once(__DIR__.'/../Views/Recettes/detail.php');  
    }

    function modifier($pdo) {
        // Récupération de l'ID depuis l'URL
        if (!isset($_GET['id'])) {
            echo 'Erreur : ID non spécifié.';
            return;
        }
        
        $id = (int) $_GET['id']; // Sécurisation de l'ID en entier

        // Vérification si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des valeurs soumises dans le formulaire
            $titre = $_POST['titre'] ?? null;
            $description = $_POST['description'] ?? null;
            $auteur = $_POST['auteur'] ?? null;

            // Vérifier que les champs sont bien remplis
            if (!$titre || !$description || !$auteur) {
                echo 'Erreur : tous les champs doivent être remplis.';
                return;
            }

            // Préparation et exécution de la requête de mise à jour
            $requete = $pdo->prepare('
                UPDATE recettes 
                SET titre = :titre, description = :description, auteur = :auteur 
                WHERE id = :id
            ');
            $requete->bindParam(':titre', $titre);
            $requete->bindParam(':description', $description);
            $requete->bindParam(':auteur', $auteur);
            $requete->bindParam(':id', $id, PDO::PARAM_INT);

            if ($requete->execute()) {
                echo 'La recette a été modifiée avec succès.';
                // Rediriger ou afficher un message de succès
            } else {
                echo 'Erreur lors de la modification de la recette.';
            }
        } else {
            // Si le formulaire n'est pas soumis, récupérer les données de la recette existante
            $requete = $pdo->prepare('SELECT * FROM recettes WHERE id = :id');
            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->execute();
            $recipe = $requete->fetch(PDO::FETCH_ASSOC);

            if (!$recipe) {
                echo 'Erreur : recette introuvable.';
                return;
            }

            // Inclure le formulaire de modification avec les données actuelles
            require_once(__DIR__.'/../Views/Recettes/modifier.php');
        }
    }
}
    



