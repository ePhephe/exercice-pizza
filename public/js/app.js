let divModal = document.querySelector(`.modal`);
let divMessageModal = document.querySelector(`.modal div`);

/**
 * Affiche une erreur sur le champ dont l'id est passé en paramètre
 * @param {string} id - id unique de l'élément dans le DOM
 * @param {string} messageErreur - Message d'erreur à afficher
 */
function afficheErreur(id,messageErreur){
    //On récupère l'élément et son élément message d'erreur
    let element = document.getElementById(id);
    let message = document.getElementById(id + `-erreur`);

    //On lui ajoute la classe d'erreur sur un input
    element.classList.add(`input-error`);
    //On insère le message d'erreur et on l'affiche en lui retirant la classe display none
    message.innerHTML += messageErreur + `<br>`;
    message.classList.remove(`d-none`);

}
/**
 * Enlève les erreurs sur le champ dont l'id est passé en paramètre
 * @param {string} id - id unique de l'élément dans le DOM
 */
function enleveErreur(id){
    //On récupère l'élément et son élément message d'erreur
    let element = document.getElementById(id);
    let message = document.getElementById(id + `-erreur`);

    //On enlève la classe d'erreur sur l'input
    element.classList.remove(`input-error`);
    //On enlève le message d'erreur et on le masque en lui remettant la classe display none
    message.innerHTML = ``;
    message.classList.add(`d-none`);
}

/**
 * Masque le message de la modal
 */
function masqueModal(){
    //On masque les messages avec le display none (classe CSS d-none)
    divModal.classList.add(`d-none`);
    divMessageModal.innerHTML = ``;
}

/**
 * Affiche le message de la modal
 */
function afficheModal(message,succes){
    //Selon le succès ou l'échec, on place des classes CSS différentes
    if(succes===true) {
        divModal.classList.add(`succes`);
        divModal.classList.remove(`erreur`);
    }
    else {
        divModal.classList.add(`erreur`);
        divModal.classList.remove(`succes`);
    }
    
    //On affecte le message au contenu de la div et on enlève le display none
    divModal.classList.remove(`d-none`);
    divMessageModal.innerHTML = message;
    //On laisse 5sec avant de remasquer le message
    setTimeout(masqueModal,5000);
}

/**
 * Redirige vers une autre page
 * 
 * @param {string} url URL de la page sur laquelle redirigée
 */
function redirectFormulaire(url){
    //On masque les messages avec le display none (classe CSS d-none)
    window.location = url;
}

/**
 * Retourne un tableau des paramètres d'une URL ou un paramètre seulement s'il est fourni
 * 
 * @param {string} url URL à décomposer
 * @param {string} param Paramètre à récupérer
 * @returns Tableau des paramètres ou valeur d'un paramètre
 */
function getQueryParams(url,param = ``) {
    // Création d'un objet URL
    let urlObj = new URL(url);
    
    // Création d'un tableau pour stocker les paramètres ou d'une variable pour stocker le paramètre
    let params = [];
    let valeur = ``;
    
    // Utilisation de la méthode searchParams pour parcourir les paramètres
    urlObj.searchParams.forEach((value, key) => {
        // Si on a un paramètre de la fonction égal à un des paramètres, on le retour
        if(key===param) {
            valeur = value;
        }

        // On ajoute juste le paramètre dans le tableau
        params[key] = value;
    });

    if(param != ``) {
        return valeur;
    }
    else {
        // On retourne le tableau de paramètres
        return params;
    }
}

