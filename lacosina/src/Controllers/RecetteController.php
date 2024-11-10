<?php

class RecetteController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql8;dbname=lacosina', 'myuser', 'monpassword', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function ajouter() {
        require_once(__DIR__ . '/../Views/Recettes/ajout.php');
    }

    function enregistrer() {
        $titre = $_POST['titre'];
        $description = $_POST['description'];  
        $auteur = $_POST['auteur'];
        $image = $_FILES['image'];
    
        $imagePath = null;
        
        // Si une nouvelle image est téléchargée
        if (!empty($image) && $image['error'] != 4) {
            $tempName = $image['tmp_name'];
    
            if (is_uploaded_file($tempName)) {
                // Déplacer l'image vers le répertoire de destination
                $imageName = basename($image['name']); // On sécurise le nom de l'image
                $uploadPath = __DIR__.'/../../upload/'.$imageName;
                
                // Supprimer l'ancienne image si elle existe déjà (dans la base de données)
                $id = $_GET['id'];
                if (isset($id)) {
                    $recipeRequest = $this->pdo->prepare('SELECT image FROM recettes WHERE id = :id');
                    $recipeRequest->bindParam(':id', $id);
                    $recipeRequest->execute();
                    $recipe = $recipeRequest->fetch(PDO::FETCH_ASSOC);
                    
                    // Si une ancienne image existe, on la supprime du serveur
                    if ($recipe['image'] && file_exists(__DIR__.'/../../upload/'.$recipe['image'])) {
                        unlink(__DIR__.'/../../upload/'.$recipe['image']);
                    }
                }
                
                // Déplacer la nouvelle image
                if (!move_uploaded_file($tempName, $uploadPath)) {
                    echo 'Erreur lors de l\'enregistrement de l\'image';
                    exit;
                } else {
                    $imagePath = $imageName;  // Nouveau chemin de l'image
                }
            }
        } else {
            // Si aucune nouvelle image n'est téléchargée, récupérer l'ancienne image
            $id = $_GET['id'];
            if (isset($id)) {
                $recipeRequest = $this->pdo->prepare('SELECT image FROM recettes WHERE id = :id');
                $recipeRequest->bindParam(':id', $id);
                $recipeRequest->execute();
                $recipe = $recipeRequest->fetch(PDO::FETCH_ASSOC);
                $imagePath = $recipe['image']; // Conserver l'ancienne image
            }
        }
    
        // Mise à jour ou insertion de la recette
        if (isset($id)) {
            $requete = $this->pdo->prepare('UPDATE recettes SET titre = :titre, description = :description, auteur = :auteur, image = :image WHERE id = :id');
            $requete->bindParam(':id', $id);
        } else {
            // Si c'est une nouvelle recette
            $requete = $this->pdo->prepare('INSERT INTO recettes (titre, description, auteur, image, date_creation) VALUES(:titre, :description, :auteur, :image, NOW())');
        }
    
        // Bind des paramètres
        $requete->bindParam(':titre', $titre);
        $requete->bindParam(':description', $description);
        $requete->bindParam(':auteur', $auteur);
        $requete->bindParam(':image', $imagePath);
    
        // Exécution de la requête
        $ajoutOk = $requete->execute();
    
        if ($ajoutOk) {
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'recettes'.DIRECTORY_SEPARATOR.'enregistrer.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de la recette';
        }
    }

    function lister() {
        $requete = $this->pdo->query("SELECT * FROM recettes");
        $recipes = $requete->fetchAll();
        require_once(__DIR__ . '/../Views/Recettes/liste.php');
    }

    function detail($id) {
        $requete = $this->pdo->prepare("SELECT * FROM recettes WHERE id = :id");
        $requete->execute([':id' => $id]);
        $recipe = $requete->fetch();

        require_once(__DIR__ . '/../Views/Recettes/detail.php');
    }

    function modifier($id) {
        $requete = $this->pdo->prepare("SELECT * FROM recettes WHERE id = :id");
        $requete->execute([':id' => $id]);
        $recipe = $requete->fetch();

        if (!$recipe) {
            echo "Recette introuvable.";
            return;
        }

        require_once(__DIR__ . '/../Views/Recettes/modif.php');
    }
}
