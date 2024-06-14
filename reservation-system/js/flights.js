$(document).ready(function() {
    $.ajax({
        url: 'http://localhost:8000/api/flights.php',
        method: 'GET',
        dataType: 'json',
        success: function(flights) {
            var flightsContainer = $('#flights-container');
            flights.forEach(function(flight) {
                var flightCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${flight.airline}</h5>
                                <p class="card-text">
                                    <strong>Départ :</strong> ${flight.departure}<br>
                                    <strong>Arrivée :</strong> ${flight.arrival}<br>
                                    <strong>Date :</strong> ${flight.date}<br>
                                    <strong>Heure de départ :</strong> ${flight.departure_time}<br>
                                    <strong>Heure d'arrivée :</strong> ${flight.arrival_time}<br>
                                    <strong>Prix :</strong> ${flight.price}€
                                </p>
                                <a href="#" class="btn btn-primary">Réserver</a>
                            </div>
                        </div>
                    </div>
                `;
                flightsContainer.append(flightCard);
            });
        },
        error: function() {
            alert('Erreur lors de la récupération des vols.');
        }
    });
});
