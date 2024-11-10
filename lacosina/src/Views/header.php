<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cosina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/js/front.js"></script>

    <style>
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;  
        }

        .dropdown-menu {
            display: none;
        }
    </style>

</head> 
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="?c=acceuil">Accueil</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="?c=recettes">Recettes</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="?c=contact">Contact</a>
            </li>         
        </ul>

        <?php if (isset($_SESSION['identifiant'])) { ?>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bienvenue, <?php echo $_SESSION['identifiant']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?c=profil">Profil</a></li>
                        <li><a class="dropdown-item" href="?c=AjouterRecette">Ajouter une recette</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href='?c=deconnexion'>Déconnexion</a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href='?c=inscription'>Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href='?c=connexion'>Connexion</a>
                </li>
            </ul>
        <?php } ?>
    </nav>

    <div class="container w-75 m-auto">
