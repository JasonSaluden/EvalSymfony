
// Fonction pour augmenter ou diminuer la quantité d'un produit dans le panier
 
// panier.js
function updateQuantity(url) {
    fetch(url, {
        method: 'GET', 
    })
    .then(response => {
        if (response.ok) {

            location.reload();
        } else {
            alert("Une erreur est survenue.");
        }
    })
    .catch(error => console.error('Erreur:', error));
}
