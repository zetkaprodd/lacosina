<body>

    <h1> Recettes </h1>


    <div class="row">
        <?php foreach ($recipes as $recipe) : ?>
            <div class="col-4 p-2">
                <div class='card recipe' data-id='<?php echo $recipe['id']; ?>'>
                    <h2 class="card-title"><?php echo $recipe['titre']; ?></h2>
                    <img src="upload/<?php echo ((isset($recipe['image']) && $recipe['image'] != "") ? $recipe['image'] : "no_image.png"); ?>" alt="upload/no_image.png">
                    <p class="card-test"><?php echo $recipe['description']; ?></p>
                    <a href="mailto:<?php echo $recipe['auteur']; ?>"><?php echo $recipe['auteur']; ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="?c=home" class="btn btn-primary"> Retour à l'acceuil</a>


</body> 