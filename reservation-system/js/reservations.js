// Attendre que le DOM soit entièrement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la liste des réservations depuis le backend
    fetch('http://localhost:8000/api/reservations')
        .then(response => response.json())
        .then(data => {
            // Manipuler les données reçues
            console.log(data); // Pour le débogage
            
            // Sélectionner l'élément HTML où afficher les réservations
            const reservationList = document.getElementById('reservation-list');

            // Parcourir les réservations et les afficher sur la page
            data.forEach(reservation => {
                const reservationItem = document.createElement('li');
                reservationItem.textContent = `ID: ${reservation.id}, Nom: ${reservation.name}, Siège: ${reservation.seat}, Vol: ${reservation.flight_id}`;
                reservationList.appendChild(reservationItem);
            });
        })
        .catch(error => console.error('Erreur lors de la récupération des réservations:', error));
});
