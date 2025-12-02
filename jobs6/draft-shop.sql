CREATE DATABASE IF NOT EXISTS `draft-shop`;
USE `draft-shop`;

CREATE TABLE `category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `product` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `photos` JSON,
    `price` INT NOT NULL DEFAULT 0,
    `description` TEXT,
    `quantity` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `category_id` INT NOT NULL,
    FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `category` (`name`, `description`) VALUES
('Électronique', 'Produits électroniques et gadgets'),
('Vêtements', 'Mode et accessoires'),
('Maison', 'Décoration et équipement maison');

INSERT INTO `product` (`name`, `photos`, `price`, `description`, `quantity`, `category_id`) VALUES
('Smartphone X', '["phone1.jpg", "phone2.jpg"]', 59900, 'Dernier smartphone haute performance', 50, 1),
('Laptop Pro', '["laptop1.jpg"]', 129900, 'Ordinateur portable professionnel', 25, 1),
('T-Shirt Basic', '["tshirt.jpg"]', 1990, 'T-shirt en coton bio', 100, 2),
('Lampe LED', '["lampe.jpg", "lampe2.jpg"]', 3490, 'Lampe de bureau moderne', 75, 3),
('Casque Bluetooth', '["casque1.jpg", "casque2.jpg"]', 7990, 'Casque sans fil avec réduction de bruit', 40, 1),
('Robe d\'été', '["robe1.jpg"]', 3490, 'Robe légère pour l\'été', 60, 2),
('Coussin déco', '["coussin1.jpg", "coussin2.jpg"]', 1590, 'Coussin décoratif pour le salon', 80, 3),
('Montre connectée', '["montre1.jpg"]', 49900, 'Montre intelligente avec suivi d\'activité', 30, 1);
