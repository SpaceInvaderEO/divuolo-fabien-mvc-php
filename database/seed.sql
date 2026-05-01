USE `covoiturage_db`;

-- Insertion des Agences (Villes)
INSERT INTO `agency` (`name`) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Bordeaux'),
('Lille'),
('Strasbourg'),
('Nantes');

-- Insertion des Employés (Le mot de passe pour tous est 'password')
-- Hash généré par password_hash('password', PASSWORD_DEFAULT)
INSERT INTO `user` (`first_name`, `last_name`, `email`, `phone`, `password`, `is_admin`) VALUES
('Admin', 'Super', 'admin@entreprise.com', '0102030405', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE),
('Alexandre', 'Martin', 'alexandre.martin@email.fr', '0612345678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Sophie', 'Dubois', 'sophie.dubois@email.fr', '0698765432', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Julien', 'Bernard', 'julien.bernard@email.fr', '0622446688', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Camille', 'Moreau', 'camille.moreau@email.fr', '0611223344', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Lucie', 'Lefèvre', 'lucie.lefevre@email.fr', '0777889900', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Thomas', 'Leroy', 'thomas.leroy@email.fr', '0655443322', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Chloé', 'Roux', 'chloe.roux@email.fr', '0633221199', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Maxime', 'Petit', 'maxime.petit@email.fr', '0766778899', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Laura', 'Garnier', 'laura.garnier@email.fr', '0688776655', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Antoine', 'Dupuis', 'antoine.dupuis@email.fr', '0744556677', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Emma', 'Lefebvre', 'emma.lefebvre@email.fr', '0699887766', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Louis', 'Fontaine', 'louis.fontaine@email.fr', '0655667788', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Clara', 'Chevalier', 'clara.chevalier@email.fr', '0788990011', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Nicolas', 'Robin', 'nicolas.robin@email.fr', '0644332211', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Marine', 'Gauthier', 'marine.gauthier@email.fr', '0677889922', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Pierre', 'Fournier', 'pierre.fournier@email.fr', '0722334455', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Sarah', 'Girard', 'sarah.girard@email.fr', '0688665544', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Hugo', 'Lambert', 'hugo.lambert@email.fr', '0611223366', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Julie', 'Masson', 'julie.masson@email.fr', '0733445566', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE),
('Arthur', 'Henry', 'arthur.henry@email.fr', '0666554433', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE);

-- Insertion de quelques Trajets
-- NB : On utilise les IDs correspondants (Paris=1, Lyon=2, Marseille=3, Bordeaux=4)
-- Utilisateurs (Admin=1, Jean=2, Marie=3, Paul=4)
INSERT INTO `ride` (`departure_time`, `arrival_time`, `total_seats`, `available_seats`, `id_departure_agency`, `id_arrival_agency`, `id_user`) VALUES
(DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL '1 02:00:00' DAY_SECOND), 4, 3, 1, 2, 2), -- Jean: Paris -> Lyon demain
(DATE_ADD(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL '2 05:00:00' DAY_SECOND), 3, 3, 2, 3, 3), -- Marie: Lyon -> Marseille après-demain
(DATE_ADD(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL '5 06:00:00' DAY_SECOND), 2, 1, 4, 1, 4), -- Paul: Bordeaux -> Paris dans 5 jours
(DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL '0 20:00:00' DAY_SECOND), 4, 0, 1, 5, 2); -- Jean: Trajet passé (Paris -> Lille)
