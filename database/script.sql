\c postgres
drop database itu_note;

CREATE DATABASE itu_note;

\c itu_note

CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    login VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

insert into admin (login,mdp) values ('admin1','admin1');


CREATE TABLE promotion (
    id_promotion SERIAL PRIMARY KEY,
    nom_promotion VARCHAR(255) NOT NULL,
    date_promotion DATE
);

CREATE TABLE etudiant (
    num_etu SERIAL PRIMARY KEY,
    unique_etu VARCHAR(100) unique,
    nom_etudiant VARCHAR(255) NOT NULL,
    prenom_etudiant VARCHAR(255) NOT NULL,
    genre VARCHAR(255),
    date_naissance DATE,
    id_promotion INT REFERENCES promotion (id_promotion)
);

CREATE TABLE annee (
    id_annee SERIAL PRIMARY KEY,
    numero_annee VARCHAR(255) NOT NULL
);

CREATE TABLE semestre (
    id_semestre SERIAL PRIMARY KEY,
    numero_semestre VARCHAR(255) NOT NULL,
    id_annee INT REFERENCES annee (id_annee)
);

CREATE TABLE matiere (
    id_matiere SERIAL PRIMARY KEY,
    code_matiere VARCHAR(255) NOT NULL,
    nom_matiere VARCHAR(255),
    credit INT,
    est_optionnelle Boolean, 
    option INT,
    id_semestre INT REFERENCES semestre (id_semestre)
);

CREATE TABLE note (
    id_note SERIAL PRIMARY KEY,
    num_etu INT REFERENCES etudiant (num_etu),
    id_matiere INT REFERENCES matiere (id_matiere),
    valeur DOUBLE PRECISION,
    resultat VARCHAR(255),
    date_session DATE
);

/*CREATE TABLE semestre_inscrit (
    id_semestre_inscrit SERIAL PRIMARY KEY,
    num_etu INT REFERENCES etudiant (num_etu),
    id_semestre INT REFERENCES semestre (id_semestre)
);*/

CREATE TABLE configuration_note (
    code VARCHAR(255),
    config VARCHAR(255),
    valeur INT
);

INSERT INTO annee (numero_annee) VALUES
('L1'),
('L2'),
('L3');

INSERT INTO semestre (numero_semestre, id_annee) VALUES
('S1',1),
('S2',1),
('S3',2),
('S4',2),
('S5',3),
('S6',3);

insert into matiere(code_matiere, nom_matiere, credit, est_optionnelle, option, id_semestre) values
    ('INF101', 'Programmation procedurale', 7, false, 1, 1),
    ('INF104', 'HTML et Introduction au Web', 5, false, 2, 1),
    ('INF107', 'Informatique de Base', 4, false, 3, 1),
    ('MTH101', 'Arithmetique et nombres', 4, false, 4, 1),
    ('MTH102', 'Analyse mathematique', 6, false, 5, 1),
    ('ORG101', 'Technique de communication', 4, false, 6, 1),

    ('INF102', 'Bases de donnees relationnelles', 5, false, 7, 2),
    ('INF103', 'Base de l''administration systeme', 5, false, 8, 2),
    ('INF105', 'Maintenance materiel et logiciel', 4, false, 9, 2),
    ('INF106', 'Complements de programmation', 6, false, 10, 2),
    ('MTH103', 'Calcul Vectoriel et Matriciel', 6, false, 11, 2),
    ('MTH105', 'Probabilite et Statistique', 4, false, 12, 2),

    ('INF201', 'Programmation orientee objet', 6, false, 13, 3),
    ('INF202', 'Bases de donnees objets', 6, false, 14, 3),
    ('INF203', 'Programmation systeme', 4, false, 15, 3),
    ('INF208', 'Reseaux informatiques', 6, false, 16, 3),
    ('MTH201', 'Methodes numeriques', 4, false, 17, 3),
    ('ORG201', 'Bases de gestion', 4, false, 18, 3),

    ('INF204', 'Systeme d''information geographique', 6, true, 19, 4),
    ('INF205', 'Systeme d''information', 6, true, 19, 4),
    ('INF206', 'Interface Homme/Machine', 6, true, 19, 4),
    ('INF207', 'Elements d''algorithmique', 6, false, 20, 4),
    ('INF210', 'Mini-projet de developpement', 10, false, 21, 4),
    ('MTH204', 'Geometrie', 4, true, 22, 4),
    ('MTH205', 'Equations differentielles', 4, true, 22, 4),
    ('MTH206', 'Optimisation', 4, true, 22, 4),
    ('MTH203', 'MAO', 4, false, 23, 4),

    ('INF301', 'Architecture logicielle', 6, false, 24, 5),
    ('INF304', 'Developpement pour mobiles', 6, false, 25, 5),
    ('INF307', 'Conception en modele oriente objet', 6, false, 26, 5),
    ('ORG301', 'Gestion d''entreprise', 5, false, 27, 5),
    ('ORG302', 'Gestion de projets', 4, false, 28, 5),
    ('ORG303', 'Anglais pour les affaires', 3, false, 29, 5),

    ('INF310', 'Codage', 4, false, 30, 6),
    ('INF313', 'Programmation avancee, frameworks', 6, false, 31, 6),
    ('INF302', 'Technologie d''acces aux reseaux', 6, true, 32,6),
    ('INF303', 'Multimedia', 6, true, 32, 6),
    ('INF316', 'Projet de developpement', 10, false, 33, 6),
    ('ORG304', 'Communication d''entreprise', 4, false, 34, 6);


asina bouton eo amle releve notes makany @ page vaovao mampiseo anle notes ihany fa categorizena 3 : 
_ ze note Informatique (asina moyenne kely par categorie) (code_matiere commence par'INF')
_ze note mathematique (code_matiere commence par'MTH')
_ze ouverture (code_matiere autre)

1620