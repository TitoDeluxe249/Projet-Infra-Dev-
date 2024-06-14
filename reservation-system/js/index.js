// Dans votre fichier index.js (ou tout autre fichier JavaScript lié à votre page accueil.html)

// Attendre que le DOM soit entièrement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la liste des vols depuis le backend
    fetch('http://localhost:8000/api/flights')
        .then(response => response.json())
        .then(data => {
            // Manipuler les données reçues
            console.log(data); // Pour le débogage
            
            // Sélectionner l'élément HTML où afficher les vols
            const flightList = document.getElementById('flight-list');

            // Parcourir les vols et les afficher sur la page
            data.forEach(flight => {
                const flightItem = document.createElement('li');
                flightItem.textContent = `Numéro de vol: ${flight.flight_number}, Départ: ${flight.departure_city}, Arrivée: ${flight.arrival_city}`;
                flightList.appendChild(flightItem);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des vols:', error));
});
