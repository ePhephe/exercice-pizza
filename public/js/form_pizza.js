// On récupère tous les liens cliquable pour ajouter/modifier les compositions
let liensFormComposition = document.querySelectorAll(`#liensComposition a`);
// On récupère le formulaire d'un pizza
let formPizza = document.getElementById(`form_pizza`);

formPizza.addEventListener(`submit`, (e) => {
    e.preventDefault();

    // On prépare nos paramètres de requête
    let params = new FormData(formPizza);

    // Appel de l'URL avec fetch en méthode POST
    fetch(`creer_pizza.php`, {
        method: `POST`,
        body: params
    })
    .then(res => { return res.json()})
    .then(rep => {
        if(rep.succes === true) {
            afficheModal(rep.message,rep.succes);
            setTimeout(redirectFormulaire(`afficher_form_pizza.php?id=${rep.idpizza}&action=update`),5000);
        }
        else {
            afficheModal(rep.message,rep.succes);
        }
    })
    .catch((error) => {
        console.error(`Error:`, error);
    });
});

/**
 * 
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

    // Appel de l'URL avec fetch en méthode POST
    fetch(`modifier_composition_pizza.php?idpizza=${idpizza}&type=${typeComposition}`, {
        method: `POST`,
        body: params
    })
    .then(res => { return res.json()})
    .then(rep => {
        console.log(`Success:`, rep);
    })
    .catch((error) => {
        console.error(`Error:`, error);
    });


}

liensFormComposition.forEach(unLien => {
    unLien.addEventListener(`click`,(e) => {
        e.preventDefault();

        let type = e.target.getAttribute(`data-type`);
        let formPizza = document.getElementById(`form_pizza`);
        let idpizza = getQueryParams(formPizza.action, `idpizza`);

        //Execution de la requête
        fetch(`afficher_form_composition.php?idpizza=${idpizza}&type=${type}`).then(res => {
            return res.json();
        }).then(rep => {
            //On appelle notre fonction d'affichage si on a 10 résultats ou moins
            if(rep.succes === true){
                let divFormulaire = document.getElementById(`formComposition`);

                divFormulaire.innerHTML = rep.result;

                let inputsForm = divFormulaire.querySelectorAll(`input[name=c_ref_ingredient]`);

                inputsForm.forEach(input => {
                    input.addEventListener(`change`, (e) => {
                        let typeCompostion = input.getAttribute(`data-type`);
                        majPizza(typeCompostion);
                    });
                });

            }
            //console.log(rep);
        }).catch(err => {
            console.log(err);
        });
    });
});


