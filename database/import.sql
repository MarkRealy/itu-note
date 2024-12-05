create table temporary_note(
    num_etu VARCHAR(100),
    nom_etudiant VARCHAR(100),
    prenom_etudiant VARCHAR(100),
    genre VARCHAR(100),
    date_naissance DATE,
    promotion VARCHAR(100),
    code_matiere VARCHAR(100),
    semestre VARCHAR(100),
    note DOUBLE PRECISION
);



create or replace FUNCTION insert_promotion()
RETURNS void as $$
    BEGIN
        insert into promotion(nom_promotion)
        SELECT
            promotion
        FROM temporary_note 
        group by promotion;
    END;
$$ LANGUAGE plpgsql;

create or replace FUNCTION insert_etudiant()
RETURNS void as $$
    BEGIN
        insert into etudiant (unique_etu,nom_etudiant,prenom_etudiant,genre,date_naissance,id_promotion)
        SELECT
            tn.num_etu,
            tn.nom_etudiant,
            tn.prenom_etudiant,
            tn.genre,
            tn.date_naissance,
            p.id_promotion
        FROM temporary_note  tn 
        join promotion p on p.nom_promotion = tn.promotion
        group by tn.num_etu,
            tn.nom_etudiant,
            tn.prenom_etudiant,
            tn.genre,
            tn.date_naissance , p.id_promotion;
    END;
$$ LANGUAGE plpgsql;

/*create or replace FUNCTION insert_semestre()
RETURNS void as $$
    BEGIN
        insert into semestre(numero_semestre)
        SELECT
            semestre
        FROM temporary_note 
        group by semestre;
    END;
$$ LANGUAGE plpgsql;


--create or replace FUNCTION insert_matiere()
 RETURNS void as $$ 
    BEGIN
        insert into matiere(code_matiere,id_semestre)
        SELECT
            tn.code_matiere,
            s.id_semestre
        FROM temporary_note tn 
        join semestre s on s.numero_semestre=tn.semestre 
        group by tn.code_matiere,s.id_semestre;
    END;
$$ LANGUAGE plpgsql;*/


create or replace FUNCTION insert_note()
RETURNS void as $$
    BEGIN
        insert into note(num_etu,id_matiere,valeur)
        SELECT
            e.num_etu,
            m.id_matiere,
            tn.note
        FROM temporary_note tn 
        join matiere m on tn.code_matiere = m.code_matiere
        join etudiant e on e.unique_etu = tn.num_etu;
    END;
$$ LANGUAGE plpgsql;


/*create or replace FUNCTION insert_semestre_inscrit()
RETURNS void as $$
    BEGIN
        insert into semestre_inscrit(num_etu,id_semestre)
        SELECT
            e.num_etu,
            s.id_semestre
        FROM temporary_note tn 
        join semestre s on tn.semestre=s.numero_semestre
        join etudiant e on e.unique_etu = tn.num_etu
        group by e.num_etu,s.id_semestre;
    END;
$$ LANGUAGE plpgsql;*/


create or replace FUNCTION insert_via_temp_note()
RETURNS void AS $$
    BEGIN 
        PERFORM insert_promotion();
        PERFORM insert_etudiant();
        PERFORM insert_note();
        PERFORM insert_semestre_inscrit();
    END;
$$ language plpgsql;
