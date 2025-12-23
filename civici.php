<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include 'conn.php';





//$idcivico=$_GET["id"];
$query="select cc.cod_civico, 
numero::int, 
lettera,
colore, 
testo,
cod_strada,
1 as id_comune, 
id_municipio, 
g.id_quartiere,
st_y(st_transform(geoloc,4326)) as lat,
st_x(st_transform(geoloc,4326)) as lon,
cc.ins_date as insert_date,
cc.mod_date as update_date 
from etl.civici_comune cc
left join lateral (
  select id_quartiere
  from geo.v_grafostradale g
  order by g.geoloc <-> cc.geoloc
  limit 1
  ) g on true";

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