// On récupère tous les liens cliquable pour ajouter/modifier les compositions
let liensFormComposition = document.querySelectorAll(`#liensComposition a`);

liensFormComposition.forEach(unLien => {
    unLien.addEventListener(`click`,(e) => {
        e.preventDefault();

        let type = e.target.getAttribute(`data-type`);

        //Execution de la requête
        fetch(`afficher_form_composition.php?idpizza=1&type=${type}`).then(res => {
            return res.json();
        }).then(rep => {
            //On appelle notre fonction d'affichage si on a 10 résultats ou moins
            if(rep.succes === true){
                let divFormulaire = document.getElementById(`formComposition`);

                divFormulaire.innerHTML = rep.result;
                //Afficher le formulaire
                //Ajouter l'évenement submit du formulaire
            }
            //console.log(rep);
        }).catch(err => {
            console.log(err);
        });
    });
});


