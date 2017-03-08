
# creation de la database wcs_pizz
# note : il faut se connecter en root pour lancer ce script

# on fait d'abord le menage
DROP DATABASE IF EXISTS wcs_pizz;
# puis on créé la database (avec utf-8)
CREATE DATABASE wcs_pizz DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

# on cree ensuite le user pour la gerer
GRANT all ON wcs_pizz.* TO 'admpizz' IDENTIFIED BY 'pizzpAsse';

# on selectionne la database
USE wcs_pizz;

# on cree la table pizzatypes
DROP TABLE IF EXISTS pizzatypes;
CREATE TABLE pizzatypes (
  idtype INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  pizztype VARCHAR(250),
  txtbtn varchar(20),
  ordreaff TINYINT
) DEFAULT CHARACTER SET=utf8;

# on peuple la table pizzatypes
INSERT INTO pizzatypes (idtype, pizztype, txtbtn, ordreaff) VALUES (1, 'Pizzas base tomate','Base tomate',1);
INSERT INTO pizzatypes (idtype, pizztype, txtbtn, ordreaff) VALUES (2, 'Pizzas base crême','Base crême',2);
INSERT INTO pizzatypes (idtype, pizztype, txtbtn, ordreaff) VALUES (3, 'Pizzas dessert','Dessert',3);

# controle
SELECT * FROM pizzatypes;


# on cree la table pizzas
DROP TABLE IF EXISTS pizzas;
CREATE TABLE pizzas (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nompizz VARCHAR(50),
  compo VARCHAR(250),
  prix29 FLOAT DEFAULT 0,
  prix33 FLOAT DEFAULT 0,
  idtype INT NOT NULL DEFAULT 1
) DEFAULT CHARACTER SET=utf8;

# on peuple la table pizzas
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Margherita', 'Sauce tomate, fromage, olives.', 5.20, 7.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Jamón', 'Sauce tomate, jambon blanc, fromage, olives.', 6.50, 8.20, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Régina', 'Sauce tomate, jambon blanc, champignons, fromage.', 7.00, 9.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Catalane', 'Sauce tomate, chorizo, oignons rouges, poivrons, fromage.', 7.50, 10.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('L\'Orientale', 'Sauce tomate, mergez, oignons rouges, poivrons, fromage.', 7.50, 10.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Cabra', 'Sauce tomate, chèvre, fromage, accompagnement au choix : miel, persillade, ciboulette.', 7.80, 10.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Calzone', 'Sauce tomate, jambon blanc, oeuf, fromage.', 7.80, 10.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La 4 Fromages', 'Sauce tomate, bleu,parmesan, emmental, mozzarella.', 9.00, 11.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('L\'Hawaïenne', 'Sauce tomate, jambon blanc, ananas, crème fraîche.', 7.60, 10.20, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Temporados', 'Sauce tomate, jambon blanc, champignons, artichauts, poivrons, oeufs, fromage.', 9.00, 11.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Barcelona', 'Sauce tomate, boeuf haché, champignons, oeuf, oignons rouges, fromage.', 9.00, 12.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Malaga', 'Sauce tomate, boeuf haché, chèvre, oeuf, oignons rouges, persillade, fromage.', 10.10, 13.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Mexicaine', 'Sauce tomate, boeuf haché, chorizo, oignons rouges, persillade, oeuf, fromage.', 10.10, 13.50, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Burger', 'Sauce tomate, boeuf haché, oignons rouges, cheddar, tomate fraîche, sauce burger, fromage.', 5.20, 7.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('L\'Andalouse', 'Sauce tomate, chorizo, mergez, lardons, boeuf haché, jambon blanc, oeuf, piment d\'Espelette, fromage.', 11.00, 14.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Flamenco', 'Sauce tomate, pommes de terre, jambon Serrano, oeuf, piment d\'Espelette, fromage.', 8.50, 11.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Caliente', 'Sauce tomate, jambon Serrano, chorizo, oeuf, piment d\'Espelette, fromage.', 9.00, 12.00, 1);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Savoyarde', 'Sauce tomate, fromage, olives.', 5.20, 7.00, 1);

INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Campesina', 'Crème, lardons, oignons rouges, persillade, fromage.', 7.50, 10.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Coklina', 'Crème, poulet, chèvre, miel, fromage.', 9.30, 12.50, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Rambla', 'Crème, poulet, champignons, oeuf, oignons rouges, ciboulette, fromage.', 9.00, 12.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Madrilène', 'Crème, lardons, oignons rouges, persillade, fromage.', 5.20, 7.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Del Mar', 'Crème, lardons, oignons rouges, persillade, fromage.', 5.20, 7.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Carbonara', 'Crème, lardons, oignons rouges, persillade, fromage.', 5.20, 7.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Boursin', 'Crème, lardons, oignons rouges, persillade, fromage.', 5.20, 7.00, 2);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Tonno', 'Crème, lardons, oignons rouges, persillade, fromage.', 5.20, 7.00, 2);

INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Sweety Poire', 'Crème, poire, amandes, coulis de chocolat.', 6.70, 9.00, 3);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Sweety Ananas', 'Crème, ananas, amandes, coulis de chocolat.', 6.00, 9.00, 3);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Smarties', 'Crème, smarties, coulis de chocolat.', 7.00, 10.00, 3);
INSERT INTO pizzas (nompizz, compo, prix29, prix33, idtype) VALUES ('La Tagada', 'Crème, bonbons Fraises Tagada, coulis de chocolat.', 7.00, 10.00, 3);

# controle
SELECT * FROM pizzas;


