// Écoute le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {

    //Sélectionne toutes les recettes avecla class 'recipe'
    let recipes = document.querySelectorAll('.recipe');

    //Ajouteun écouteur d'événementsur chaque recette
    recipes.forEach(recipe => {

        recipe.addEventListener("mouseover", (event) => {
            recipe.style.backgroundColor = 'ligthgray'; //Ajoute un fond gris lorsque la souris passe dessus la recette 500ms aprés 
            //le survol de la souris 500 ms avant l'event click
            recipe.style.cursor = 'pointer';

        });

        recipe.addEventListener('mouseout', (event) => {
            recipe.style.backgroundColor = ''; //Reset le fond gris quad la souris quitte la recette
            recipe.style.cursor = '';
        });

        recipe.addEventListener('click', (event) => {
            event.preventDefault(); // Empêche le comportement par défaut
            let recipeID = recipe.dataset.id;// Réucp id de la recette
            //alert(`Détail de la recette : ${recipeId}`);
            window.open('?c=detail&id=' + recipeID, '_self')//Ouvre le détail de la recette
        });
    });
});