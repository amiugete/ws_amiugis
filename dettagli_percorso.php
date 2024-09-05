<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// AUTENTICAZIONE
//require_once("test_bearer.php");

include 'conn.php';


$id_percorso=$_POST['id'];

//echo $id_percorso;
$id_percorso=explode("_", $id_percorso)[0];

if(count(explode("_", $_POST['id']))>1){
	$giorno=explode("_", $_POST['id'])[1];
	//echo $giorno;
	$query_giorno = " and fo.descrizione_long ilike '%".$giorno."%' ";
} else {
	$query_giorno='';
}


//$idcivico=$_GET["id"];
$query="select
row_number() OVER (order by ap2.num_seq) AS seq,
e.id_piazzola, v.nome as via,
p2.numero_civico as civ, p2.riferimento, p2.note as note_piazzola,
te.nome as tipo_elem, count(distinct e.id_elemento) as num
from elem.elementi_aste_percorso eap 
join etl.frequenze_ok fo on fo.cod_frequenza = eap.frequenza::int 
join elem.elementi e on e.id_elemento = eap.id_elemento 
join elem.piazzole p2 on p2.id_piazzola = e.id_piazzola 
join elem.aste a on a.id_asta = e.id_asta 
join topo.vie v on v.id_via = a.id_via 
join elem.tipi_elemento te on te.tipo_elemento = e.tipo_elemento 
join elem.aste_percorso ap2  on ap2.id_asta_percorso = eap.id_asta_percorso 
where eap.id_asta_percorso in ( 
select id_asta_percorso 
from elem.aste_percorso ap
where id_percorso = $1 and id_percorso in (select id_percorso from elem.percorsi where id_categoria_uso=3)
".$query_giorno."
)
group by ap2.num_seq,
e.id_piazzola, v.nome, p2.numero_civico, p2.riferimento, p2.note, te.nome  ";

//echo $query . "<br>";
$result = pg_prepare($conn, "my_query", $query);
#echo $result. "<br>";
$result = pg_execute($conn, "my_query", array($id_percorso));
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