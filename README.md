# ws_amiugis
WS of the amiugis server

Si appoggiano a un DB PostgreSQL installato sul server 


```
-- public.users definition

CREATE TABLE public.users (
	username varchar NOT NULL,
	"password" varchar NULL,
	note varchar NULL,
	CONSTRAINT users_pk PRIMARY KEY (username)
);


-- Permissions

ALTER TABLE public.users OWNER TO api;
GRANT ALL ON TABLE public.users TO api;


-- public."session" definition


CREATE TABLE public."session" (
	user_token varchar NOT NULL,
	username varchar NOT NULL,
	token_expire varchar NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (user_token, username, token_expire)
);


-- Permissions

ALTER TABLE public."session" OWNER TO api;
GRANT ALL ON TABLE public."session" TO api;

ALTER TABLE public."session" ADD CONSTRAINT session_fk FOREIGN KEY (username) REFERENCES public.users(username);


CREATE SCHEMA geo AUTHORIZATION api;

GRANT ALL ON SCHEMA geo TO api;

-- geo.api_layers definition

-- Drop table

-- DROP TABLE geo.api_layers;

CREATE TABLE geo.api_layers (
	title varchar NOT NULL,
	repo varchar NOT NULL,
	qgis_project varchar NOT NULL,
	layername varchar NOT NULL,
	descrizione varchar NULL
);

-- Permissions

ALTER TABLE geo.api_layers OWNER TO api;
GRANT ALL ON TABLE geo.api_layers TO api;
```


Il DB viene usato per l'autenticazione degli utenti per tutti i WS ad accesso profilato


## File coon.php

Esiste un file di configurazione (conn.php) che gestisce la connessione ai vari DB avente il seguente formato ed escluso per ovvie ragioni dal repository:

```
<?php 
$conn = pg_connect("host=XXXXXX port=XXXX dbname=NOME_DB_SIT user=XXXXXXXX password=XXXXXXX");
if (!$conn) {
        die('Could not connect to DB, please contact the administrator.');
}
$conn_api = pg_connect("host=XXXXXX port=XXXX dbname=api_db user=XXXXXX password=XXXXXX");
if (!$conn_api) {
        die('Could not connect to DB, please contact the administrator.');
}
?>
```


## Codice embedded 

Si usa la libreria prism che è stata scaricata con un po' di impostazioni

https://prismjs.com/download.html#themes=prism-dark


curl -d "user=rmarzocchi&pwd=robbo@1984" -X POST http://localhost/ws_amiugis/create_token.php


