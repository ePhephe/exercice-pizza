// On récupère tous les liens cliquable pour ajouter/modifier les compositions
let liensFormComposition = document.querySelectorAll(`#liensComposition a`);
// On récupère le formulaire d'une pizza
let formPizza = document.getElementById(`form_pizza`);
// On va cherche la div qui nous sert à afficher le formulaire de composition
let divFormulaire = document.getElementById(`formComposition`);

formPizza.addEventListener(`submit`, (e) => {
    // On arrête le fonctionnement normal du submit
    e.preventDefault();

    // On prépare nos paramètres de requête
    let params = new FormData(formPizza);

    // Appel de l'URL avec fetch en méthode POST
    fetch(`creer_pizza.php`, {
        method: `POST`,
        body: params
    })
    .then(response => response.json())
    .then(data => {
        // On affiche le résultat
        afficheModal(data.message,data.succes);
        // Si l'opération est un succès
        if(data.succes === true) {
            // On redirige vers le formulaire de la pizza créé mais en modification
            setTimeout(() => {
                redirectFormulaire(`afficher_form_pizza.php?id=${data.idpizza}&action=update`);
            }, 5000);
        }
    })
    .catch((error) => {
        console.error(`Error:`, error);
    });
});

/**
 * Met à jour la composition de la pizza
 * @param {*} typeComposition 
 */
function majPizza(typeComposition){
    // On récupère nos formulaires
    let formPizza = document.getElementById(`form_pizza`);
    let formIngredient = document.getElementById(`form_composition`);
    // On récupère l'id de la pizza
    let idpizza = getQueryParams(formPizza.action, `idpizza`);

    // On prépare nos paramètres de requête
    let params = new FormData(formIngredient);

    //console.log([...params.entries()]);

    // Appel de l'URL avec fetch en méthode POST
    fetch(`modifier_composition_pizza.php?idpizza=${idpizza}&type=${typeComposition}`, {
        method: `POST`,
        body: params
    })
    .then(response  => response.json())
    .then(data  => {
        afficheModal(data.message,data.succes);
        console.log(`Success:`, data );
    })
    .catch((error) => {
        console.error(`Error:`, error);
    });
}

liensFormComposition.forEach(unLien => {
    unLien.addEventListener(`click`,(e) => {
        // On arrête le fonctionnement normal du lien
        e.preventDefault();

        // On récupère les informations dont on a besoin
        // Le type d'ingrédient à afficher
        let type = e.target.getAttribute(`data-type`);
        // Le formulaire de la pizza
        let formPizza = document.getElementById(`form_pizza`);
        // L'identifiant de la pizza
        let idpizza = getQueryParams(formPizza.action, `idpizza`);

        // On va chercher la composition à afficher
        fetch(`afficher_form_composition.php?idpizza=${idpizza}&type=${type}`)
        .then(response => response.json())
        .then(data => {
            // Dans le cas où cela a fonctionné
            if(data.succes === true){
                // On récupère le code HTML que l'on met dans la div
                divFormulaire.innerHTML = data.result;

                // On appelle la fonction pour gérer l'affichage des dosages
                setListenerIngredientDosage();

                // On appelle la fonction pour gérer la mise en place du déclenchement de la msie à jour
                setListenerMaj();
            }
            console.log(`Success:`, data );
        }).catch(error => {
            console.error(`Error:`, error);
        });
    });
});

/**
 * Met en place les listener sur nos ingrédient avec dosage
 */
function setListenerIngredientDosage() {
    // On récupère les ingrédients
    let inputsIngredientForm = divFormulaire.querySelectorAll(`[type="checkbox"][id^="c_ref_ingredient_"]`);

    // On les parcourt un à un
    inputsIngredientForm.forEach(inputIngredient => {
        // Dès qu'il y a un changement de l'input
        inputIngredient.addEventListener(`change`, (e) => {
            // On récupère les inputs radio de dosage correspondant
            let inputsDosage = divFormulaire.querySelectorAll(`div#div_` + e.target.id + ` input[name=` + e.target.id + `_c_dosage_ingredient]`);
            // On les parcourt un à un
            inputsDosage.forEach(unDosage => {
                // Si la checkbox est cochée
                if (e.target.checked === true) {
                    // Le dosage n'est plus disabled
                    unDosage.disabled = false;
                    // On met le dosage par défaut
                    if (unDosage.value == 1) unDosage.checked = true;
                }
                else {
                    // Si la checkbox n'est pas coché on passe les inputs à disabled
                    unDosage.disabled = true;
                    // Et aucun n'est coché par défaut
                    unDosage.checked = false;
                }
            });
        });
    });
}

/**
 * Met en place les listener sur les inputs du formulaire pour mettre à jour la composition
 */
function setListenerMaj() {
    // On récupère tous les inputs du formulaire de composition
    let inputsForm = divFormulaire.querySelectorAll(`input`);

    // On parcourt tous les inputs un à un
    inputsForm.forEach(input => {
        // Dans le cas où leur valeur change
        input.addEventListener(`change`, (e) => {
            // On récupère l'input de l'ingrédient
            let inputIngredientForm = divFormulaire.querySelector(`[id^="c_ref_ingredient_"]`);
            // On récupère le type d'ingrédient
            let typeCompostion = inputIngredientForm.getAttribute(`data-type`);
            // On appelle la mise à jour de la pizza
            majPizza(typeCompostion);
        });
    });
}



