<?php
session_start();

include 'conn.php';

$lat=(float) $_GET["lat"];
$lon=(float) $_GET["lon"];

#echo $lon . "<br>";
#echo $lat . "<br>";


// date le coordinate di un punto ricavo:
// - ambito
// - comune 
// - se Genova anche Zona, UT, Municipio, Quartiere
// export come json 
//echo $tl."<br>";


if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$query="select a.id_ambito, a.descr_ambito as ambito, 
	cca.id as id_comune, c.descr_comune as comune,
	case when c.id_comune=1 
	then
	u.id_zona
	else 
	6
	end as id_zona,
	case when c.id_comune=1 
	then
	za.cod_zona 
	else 
	(select cod_zona from topo.zone_amiu where id_zona=6)
	end as zona,
	case when c.id_comune=1 
	then  
	u.id_ut
	else 
	u2.id_ut 
	end as id_ut
	, case when c.id_comune=1 
	then  
	u.descrizione
	else 
	u2.descrizione
	end as ut,
	mac.codice_municipio as id_municicio, mac.nome_municipio as municipio,
	case when c.id_comune=1 
	then 
	qa.id
	else
	q.id_quartiere 
	end 
	as id_quartiere,
	case when c.id_comune=1 
	then 
	qa.descrizione
	else
	q.nome 
	end as quartiere
	from (
	select 1 as id, st_transform(st_setsrid(st_point($1,$2),4326),3003) as geom
	) p
	join geo.confini_comuni_area cca on  st_intersects(cca.geoloc,p.geom)
	join topo.comuni c on c.id_comune = cca.id
	join topo.comuni_ut cu on cu.id_comune = c.id_comune 
	join topo.ut u2 on u2.id_ut = cu.id_ut 
	join topo.ambiti a on c.id_ambito = a.id_ambito 
	left join geo.confini_ut_zona cuz on st_intersects(cuz.geoloc,p.geom)
	left join topo.ut u on u.descrizione =cuz.descrizione 
	left join topo.zone_amiu za on za.id_zona = u.id_zona 
	left join geo.municipi_area_comune mac on st_intersects(mac.geom,p.geom)
	left join geo.quartieri_area qa on st_intersects(qa.geoloc,p.geom)
	left join topo.quartieri q on q.id_comune = c.id_comune;";
    
    #echo $query . "<br>";
	$result = pg_prepare($conn, "my_query", $query);
	#echo $result. "<br>";
    $result = pg_execute($conn, "my_query", array($lon, $lat));
	#echo $result. "<br>";
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
			#echo $r;
    		$rows[] = $r;
    		//$rows[] = $rows[]. "<a href='puntimodifica.php?id=" . $r["NAME"] . "'>edit <img src='../../famfamfam_silk_icons_v013/icons/database_edit.png' width='16' height='16' alt='' /> </a>";
	}
	pg_close($conn);
	#echo $rows ;
	if (empty($rows)==FALSE){
		//print $rows;
		print json_encode(array_values(pg_fetch_all($result)));
	} else {
		echo "[{\"NOTE\":'No data'}]";
	}
}
