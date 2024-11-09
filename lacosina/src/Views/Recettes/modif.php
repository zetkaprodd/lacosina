<h1>Modifier la recette <?php echo $recipe['titre']; ?></h1>

<form action="?c=enregistrer&id=<?php echo $recipe['id']; ?>" method="post" enctype="multipart/form-data">

<div class="mb-3">
        <label for="titre" class="form-label">Titre de la recette</label>
        <input type="text" class="form-control" value="<?php echo $recipe["titre"]; ?>" name="titre" id="titre" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Description de la recette</label>
        <textarea class="form-control" id="description" name="description"  rows="3" required><?php echo $recipe['description']; ?></textarea>    
    </div>
    
    <div class="mb-3">
        <label for="auteur" class="form-label">Mail de l'auteur</label>    
        <input type="email" class="form-control" value="<?php echo $recipe['auteur']?>" name="auteur" id="auteur" required>
    </div>

    <div class="mb-3">
        <label type="image" class="form-label" >Image de la recette <br> (pour la modifier, merci de choisir une nouvelle image)</label>    
        <img src="upload/<?php echo ((isset($recipe['image']) && $recipe['image'] != "") ? $recipe['image'] : "no_image.png"); ?>" alt="upload/no_image.png">
        <input type="file" class="form-control" name="image" id="image">    
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="enregistrer">Modifier</button>    
    </div>

</form>