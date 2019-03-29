USE labmanager;

INSERT INTO classe (nome, anno) VALUES
('dummyclass1', 2019),
('dummyclass2', 2019),
('dummyclass3', 2019);

INSERT INTO studente (nome,cognome, password, username, id_classe) VALUES

('Andrew','Calderon','demo','demo1','1'),
('Hedley','Gardner','demo','demo2','1'),
('Wallace','Norris','demo','demo3','1'),
('Brennan','Cochran','demo','demo4','1'),
('Cadman','George','demo','demo5','1'),
('Bruno','Myers','demo','demo6','1'),
('Sebastian','Dillard','demo','demo7','1'),
('Deacon','Mcleod','demo','demo8','1'),
('Nero','Mcintyre','demo','demo9','1'),
('Blake','Armstrong','demo','demo','1'),

('Wallace','George','dummypassword','marcello11','2'),
('Bruno','Norris','dummypassword','marcello12','2'),
('Andrew','Mcintyre','dummypassword','marcello13','3'),
('Nero','Mcleod','dummypassword','marcello14','3'),
('Bruno','Myers','dummypassword','marcello15','2'),
('Blake','Cochran','dummypassword','marcello16','3'),
('Prova','Prova','$2y$10$7fk0u0Rt9dEhoT7iO1tBf.9I4xB4fl6CZthaiY3GsiD3FzX3R.JX6','prova','3');

INSERT INTO docente (nome, cognome, username, password) VALUES
('Pipp', 'One', 'docente1', 'dummypassword'),
('Scop', 'One', 'docente2', 'dummypassword'),
('Swagg', 'One','docente3', 'dummypassword');

INSERT INTO categoria (nome) VALUES
('Punte trapano da 28mm'),
('Punte trapano da 30mm'),
('Barre acciaio da 28mm'),
('Barre acciaio da 30mm'),
('Torni'),
('Frese');

INSERT INTO utensile (nome, id_categoria, segnala) VALUES
('Punta trapano da 28mm 1', '1', 1);

INSERT INTO utensile (nome, id_categoria) VALUES
('Punta trapano da 28mm 2', '1'),
('Punta trapano da 30mm 1', '2'),
('Barra acciaio da 30mm 2', '2'),
('Barra acciaio da 28mm 1', '3'),
('Barra acciaio da 28mm 2', '3'),
('Barra acciaio da 30mm 1', '4'),
('Barra acciaio da 30mm 2', '4'),
('Utensile senza categoria', NULL),
('Tornio 1', '5'),
('Tornio 2', '5'),
('Tornio 3', '5'),
('Tornio 4', '5'),
('Tornio 5', '5'),
('Tornio 6', '5'),
('Tornio 7', '5'),
('Tornio 8', '5'),
('Tornio 9', '5'),
('Tornio 10', '5'),
('Tornio 11', '5'),
('Tornio 12', '5'),
('Tornio 13', '5'),
('Tornio 14', '5'),
('Tornio 15', '5'),
('Fresa 1', '6'),
('Fresa 2', '6'),
('Fresa 3', '6');