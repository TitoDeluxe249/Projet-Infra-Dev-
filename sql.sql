CREATE DATABASE reservation_system_db;

USE reservation_system_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    statut VARCHAR(10) NOT NULL DEFAULT 'inactif',
    activation_token VARCHAR(255) DEFAULT NULL,
    est_admin BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ALTER TABLE users ADD COLUMN statut VARCHAR(10) NOT NULL DEFAULT 'inactif' AFTER password;
-- ALTER TABLE users ADD COLUMN activation_token VARCHAR(255) DEFAULT NULL AFTER statut;


CREATE TABLE flights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    airline VARCHAR(255) NOT NULL,
    flight_number VARCHAR(255) NOT NULL,
    departure VARCHAR(255) NOT NULL,
    arrival VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    departure_time TIME NOT NULL,
    arrival_time TIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);


INSERT INTO flights (airline, flight_number, departure, arrival, date, departure_time, arrival_time, price) VALUES
('Air France', 'FN001', 'Paris', 'New York', '2024-06-15', '10:00:00', '13:00:00', 450.00),
('Delta Airlines', 'DA231', 'Los Angeles', 'Tokyo', '2024-07-01', '16:00:00', '08:00:00', 800.00),
('Lufthansa', 'LT386', 'Frankfurt', 'Singapore', '2024-06-20', '18:00:00', '12:00:00', 900.00),
('Qatar Airways', 'QA304', 'Doha', 'Sydney', '2024-08-10', '22:00:00', '06:00:00', 1200.00),
('Emirates', 'EM555', 'Dubai', 'London', '2024-06-25', '05:00:00', '09:00:00', 600.00),
('British Airways', 'BA426', 'London', 'Toronto', '2024-09-15', '07:00:00', '10:00:00', 550.00),
('Singapore Airlines', 'SA787', 'Singapore', 'San Francisco', '2024-10-05', '20:00:00', '14:00:00', 950.00),
('United Airlines', 'UA138', 'Chicago', 'Miami', '2024-11-20', '12:00:00', '16:00:00', 300.00),
('American Airlines', 'AA789', 'Dallas', 'Madrid', '2024-12-01', '13:00:00', '08:00:00', 750.00),
('KLM', 'KML210', 'Amsterdam', 'Johannesburg', '2024-12-15', '21:00:00', '07:00:00', 850.00);



-- Créer une table pour stocker les vols sélectionnés par l'utilisateur
CREATE TABLE paniers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (flight_id) REFERENCES flights(id)
);

-- Créer une table pour stocker les réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (flight_id) REFERENCES flights(id)
);

CREATE TABLE codes_promo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    valeur DECIMAL(5, 2) NOT NULL,
    actif BOOLEAN DEFAULT 0,
    user_id INT NOT NULL

);

CREATE TABLE IF NOT EXISTS demandes_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO codes_promo (code, valeur, actif, user_id) VALUES ('TOM1', 10.00, 1, 1);
INSERT INTO codes_promo (code, valeur, actif, user_id) VALUES ('TIM2', 15.00, 1, 1);
INSERT INTO codes_promo (code, valeur, actif, user_id) VALUES ('TITO3', 20.00, 1, 2);
