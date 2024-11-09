<h1>
    <?php echo 'Titre de la recette :' ?>
    <?php echo $recipe['titre'] ?>
    <img src="upload/<?php echo ((isset($recipe['image']) && $recipe['image'] != "") ? $recipe['image'] : "no_image.png"); ?>" alt="../upload/no">
    </h1><br>
    <?php echo 'Description :' ?>
    <?php echo $recipe['description'] ?>
<br><br><br>
    <?php echo 'Auteur :' ?>
    <?php echo $recipe['auteur'] ?>

    <br><br>
    <a class="btn btn-primary" href="?c=modif&id=<?php echo $recipe['id']; ?>">Modifier la recette</a>
    <a class="btn btn-primary" href="?c=recettes">Retour à la liste des recettes</a>



