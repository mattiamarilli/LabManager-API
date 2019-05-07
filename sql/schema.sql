DROP SCHEMA labmanager;
CREATE SCHEMA labmanager;
USE labmanager;

CREATE TABLE classe (
  id_classe   serial PRIMARY KEY,
  nome        varchar(64) NOT NULL,
  anno        int(4)      NOT NULL,
  abilita     boolean     NOT NULL DEFAULT FALSE,
  UNIQUE(nome, anno)
);

CREATE TABLE gruppo (
  id_gruppo   serial PRIMARY KEY
);

CREATE TABLE studente (
  id_studente serial PRIMARY KEY,
  nome        varchar(64) NOT NULL,
  cognome     varchar(64) NOT NULL,
  username    varchar(64) NOT NULL UNIQUE,
  password    varchar(64) NOT NULL,
  id_classe   BIGINT UNSIGNED NOT NULL REFERENCES classe (id_classe),
  id_gruppo   BIGINT UNSIGNED REFERENCES gruppo (id_gruppo)
);

CREATE TABLE docente (
  id_docente  serial PRIMARY KEY,
  nome        varchar(64) NOT NULL,
  cognome     varchar(64) NOT NULL,
  username    varchar(64) NOT NULL UNIQUE,
  password    varchar(64) NOT NULL,
  admin       boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE categoria (
  id_categoria  serial PRIMARY KEY,
  nome          varchar(64)
);

CREATE TABLE utensile (
  id_utensile   serial PRIMARY KEY,
  nome          varchar(64),
  id_categoria  BIGINT UNSIGNED REFERENCES categoria (id_categoria),
  segnala       boolean NOT NULL DEFAULT FALSE,
  locked          boolean NOT NULL DEFAULT FALSE,
  deleted       boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE evento (
  id_evento   serial PRIMARY KEY,
  id_utensile bigint UNSIGNED NOT NULL REFERENCES utensile (id_utensile),
  inizio      datetime NOT NULL DEFAULT NOW(),
  fine        datetime DEFAULT NULL
);

CREATE TABLE studente_evento (
  id_studente_evento serial PRIMARY KEY,
  id_studente        bigint UNSIGNED NOT NULL REFERENCES studente (id_studente),
  id_evento          bigint UNSIGNED NOT NULL REFERENCES evento (id_evento)
);

 CREATE VIEW utensile_abilitato AS SELECT * FROM utensile WHERE lock = FALSE AND deleted = FALSE;
 CREATE VIEW classe_corrente AS SELECT * FROM classe WHERE anno = YEAR(DATE_ADD(CURDATE(), INTERVAL -7 MONTH)); -- FROM 1/8 to 31/7
 CREATE VIEW studente_corrente AS SELECT * FROM studente WHERE id_classe IN (SELECT id_classe FROM classe_corrente);
