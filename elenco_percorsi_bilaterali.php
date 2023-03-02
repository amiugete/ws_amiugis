<?php
session_start();

// AUTENTICAZIONE
//require_once("test_bearer.php");

include 'conn.php';





//$idcivico=$_GET["id"];
//OLD
/*$query="select distinct p.id_percorso, u.descrizione as ut_responsabile, 
s.descrizione as desc_servizio, ss.id_tipi_rifiuto[1] as id_tipo_rifiuto, ss.tipi_rifiuto,
t.descrizione as desc_turno, t.cod_turno, --t.inizio_ora,
p.cod_percorso, p.descrizione
from elem.percorsi p 
join elem.percorsi_ut pu on pu.cod_percorso = p.cod_percorso
join topo.ut u on u.id_ut = pu.id_ut and pu.responsabile = 'S'
join elem.turni t on t.id_turno =p.id_turno
join elem.servizi s on s.id_servizio = p.id_servizio
join (select distinct es.id_servizio, s.descrizione, array_agg(distinct tr.tipo_rifiuto) as id_tipi_rifiuto,
string_agg(distinct tr.nome, ',') as tipi_rifiuto
from elem.elementi_servizio es 
join elem.tipi_elemento te on te.tipo_elemento = es.tipo_elemento 
join elem.tipi_rifiuto tr on tr.tipo_rifiuto = te.tipo_rifiuto 
join elem.servizi s on s.id_servizio = es.id_servizio
group by es.id_servizio, s.descrizione) ss on ss.id_servizio = s.id_servizio 
where id_categoria_uso = 3 
and p.id_servizio in (103,104,105,106)
order by descrizione";*/


// senza frequenza
/*$query="select d.id_area as id_padre, 
ut_responsabile, id_tipo_rifiuto, tipi_rifiuto, desc_turno, id_percorso, cod_percorso, desc_percorso, frequenza
from etl.v_percorsi_bilaterali a
join etl.v_percorsi_bilaterali_3 d on d.descrizione = a.desc_turno
join etl.v_percorsi_bilaterali_2 c on c.descrizione = a.tipi_rifiuto and c.id_area = d.id_padre
join etl.v_percorsi_bilaterali_1 b on b.descrizione = a.ut_responsabile and b.id_area = c.id_padre
group by d.id_area, ut_responsabile, id_tipo_rifiuto, tipi_rifiuto, desc_turno, id_percorso, cod_percorso, desc_percorso, frequenza";*/



$query="select f.id_area as id_padre, 
ut_responsabile, id_tipo_rifiuto, tipi_rifiuto, desc_turno, id_percorso_ok as id_percorso, cod_percorso,
concat(desc_percorso, ' (',frequenza,')') as desc_percorso , frequenza
from etl.v_percorsi_bilaterali_giorno a
join etl.v_percorsi_bilaterali_5 f on f.descrizione = a.frequenza
JOIN etl.v_percorsi_bilaterali_4 e ON e.descrizione = concat(a.cod_percorso, ' - ', a.desc_percorso) and e.id_area = f.id_padre
join etl.v_percorsi_bilaterali_3 d on d.descrizione = a.desc_turno and d.id_area = e.id_padre
join etl.v_percorsi_bilaterali_2 c on c.descrizione = a.tipi_rifiuto and c.id_area = d.id_padre
join etl.v_percorsi_bilaterali_1 b on b.descrizione = a.ut_responsabile and b.id_area = c.id_padre
group by f.id_area, ut_responsabile, id_tipo_rifiuto, tipi_rifiuto, desc_turno, id_percorso_ok, 
cod_percorso, desc_percorso, frequenza";




//echo $query . "<br>";
$result = pg_prepare($conn, "my_query", $query);
#echo $result. "<br>";
$result = pg_execute($conn, "my_query", array());
#echo $result. "<br>";
#echo $query;
#exit;
$rows = array();
while($r = pg_fetch_assoc($result)) {
		//echo $r;
		$rows[] = $r;
		//$rows[] = $rows[]. "<a href='puntimodifica.php?id=" . $r["NAME"] . "'>edit <img src='../../famfamfam_silk_icons_v013/icons/database_edit.png' width='16' height='16' alt='' /> </a>";
}
pg_close($conn_api);
#echo $rows ;
if (empty($rows)==FALSE){
	//print $rows;
	print json_encode(array_values(pg_fetch_all($result)));
} else {
	echo "[{\"NOTE\":'No data'}]";
}

?>