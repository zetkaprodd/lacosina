<?php

class UserController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql8;dbname=lacosina', 'myuser', 'monpassword', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function inscription() {
        require_once(__DIR__ . '/../Views/User/inscription.php');
    }

    function connexion() {
        require_once(__DIR__ . '/../Views/User/connexion.php');
    }


    function enregistrer() {

        $identifiant = $_POST['identifiant'];
        $pwd = $_POST['pwd'];
        $mail = $_POST['mail'];  

        $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
    
        $requete = $this->pdo->prepare('INSERT INTO users (identifiant, password, mail, create_time, is_admin) VALUES(:identifiant, :password, :mail, NOW(), false)');

        $requete->bindParam(':identifiant', $identifiant);
        $requete->bindParam(':password', $hashedPassword);
        $requete->bindParam(':mail', $mail);
    
        $ajoutOk = $requete->execute();
    
        if ($ajoutOk) {
            require_once(__DIR__.'/../Views/User/enregistrement.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de l\'utilisateur';
        }

    }

    function verifieConnexion() {

        if (isset($_POST['identifiant']) && isset($_POST['pwd'])) {
            $identifiant = $_POST['identifiant'];
            $pwd = $_POST['pwd'];

            // Requête pour récupérer l'utilisateur avec l'identifiant
            $requete = $this->pdo->prepare('SELECT * FROM users WHERE identifiant = :identifiant');
            $requete->bindParam(':identifiant', $identifiant);
            $requete->execute();
            $user = $requete->fetch();

            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($user && password_verify($pwd, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['identifiant'] = $user['identifiant'];
                $_SESSION['is_admin'] = $user['is_admin'];

                // Rediriger vers une page d'accueil ou tableau de bord
                require_once(__DIR__.'../../Views/home.php');
                exit();
            } else {
                echo 'Identifiant ou mot de passe incorrect.';
                require_once(__DIR__ . '/../Views/User/connexion.php');
            }
        }
    }

    function deconnexion(){
        session_destroy();
        require_once(__DIR__.'../../Views/home.php');
    }

    function profil() {

        if (isset($_SESSION['identifiant'])) {
            $identifiant = $_SESSION['identifiant'];
    
            // Préparer la requête pour récupérer les informations de l'utilisateur depuis la base de données
            $requete = $this->pdo->prepare('SELECT id, identifiant, mail FROM users WHERE identifiant = :identifiant');
            $requete->bindParam(':identifiant', $identifiant);
            $requete->execute();
    
            $user = $requete->fetch();
    
            if ($user) {
                require_once(__DIR__ . '../../Views/User/profil.php');
            } else {
                echo "Utilisateur non trouvé.";
            }
        } else {
            header('Location: ?c=connexion');
            exit;
        }
    }
}
?>