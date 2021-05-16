/*
 * Fichier contenant les actions possibles par un utilisateur connecté
 * ex : candidat, particulier, entreprise, freelance
 */

/*
 * classe correspondant à l'event affiché lorsqu'on survole la mallette dans la navigation
 */
class ContratEvent {
    constructor(id, nom, ville, date) {
        if (!nom.length > 0) {
            nom = 'Offre n°' + id;
        }
        if (!ville.length > 0) {
            ville = ''
        } else {
            ville = ' à ' + ville;
        }
        date = date.substr(0, 10).split('-');
        date = date[2] + '-' + date[1] + '-' + date[0];
        let url = "{{ path('entreprise_show_offre_emploi', {'id': 1}) }}".slice(0, -1) + id;

        this.contratEventTemplate = `
        <div class="event">
            <div class="label">
            </div>
            <div class="content">
                <div class="date">
                   ${date}
                </div>
                <div class="summary">
                    ${nom}${ville}
                </div>
            </div>
        </div>`;
    }
}

// Le DOM est chargé
window.addEventListener("load", function () {
    loadContratsAmount()
});

// Charge le nombre de contrats en pending
function loadContratsAmount() {
    $.ajax({
        url: '/entreprise/get/my/candidatures',
        type: 'POST',
        dataType: 'json',
        success: function (results) {
            console.log(results)
            displayContratsFeed(results)
        }
    });
}

// Tronque les descriptions
const MAX_DESCRIPTION_LENGTH = 300;

function truncate(str, n, useWordBoundary) {
    if (str.length <= n) {
        return str;
    }
    const subString = str.substr(0, n - 1); // the original check
    return (useWordBoundary
        ? subString.substr(0, subString.lastIndexOf(" "))
        : subString) + " &hellip;";
};

// Affiche les candidatures de contrat dans la nav au survol de la mallette
const notificationsFeed = document.getElementById('notifications');
const contratsAmount = document.getElementById('contratsAmount');

function displayContratsFeed(results) {
    // Change la quantité de candidatures de contrat dans la case
    contratsAmount.innerHTML = results.candidatures.length;
    // results = httpRequest.responseText
    // Réinitialise la liste
    notificationsFeed.innerHTML = '';

    // Il n'y a pas de résultats :
    if (results.candidatures === undefined || results.candidatures.length == 0) {
        notificationsFeed.innerHTML = `<div>Pas de nouvelle candidature.</div>`;
    }

    // Il y a des résultats :
    // Pour chaque candidature
    results.candidatures.forEach(candidature => {
        let card = new ContratEvent(candidature.identity, candidature.nom, candidature.lieu.ville, candidature.createdAt);
        notificationsFeed.innerHTML += card.contratEventTemplate;
    })
}