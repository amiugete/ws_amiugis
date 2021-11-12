<?php
session_start();

include 'conn.php';

$titolo=$_GET["t"];
$livello=$_GET["l"];
$nome=str_replace("'","",$_GET["n"]);
//echo $titolo . "<br>";
//echo $livello . "<br>";
//echo $nome . "<br>";


if ($livello == 'ambito'){
    $tl = 'geo.v_ambiti';
    $field= 'descrizione';
} else if ($livello == 'comune'){
    $tl = 'geo.confini_comuni_area';
    $field= 'descrizione';
} else if ($livello == 'municipio'){
    //$tl = 'geo.municipi_area_comuni';
    //$field= 'nome_municipio';
    $tl = 'geo.municipi_area';
    $field= 'descrizione';
}

//echo $tl."<br>";


if(!$conn) {
    die('Connessione fallita !<br />');
} else {
	//$idcivico=$_GET["id"];
	$query="SELECT 'https://amiugis.amiu.genova.it/mappe/lizmap/www/index.php/view/map/' as url, al.repo as repository, al.qgis_project as project,
	 replace(replace(replace(st_extent(st_transform(g.geoloc,3857))::text,'BOX(',''),')',''),' ',',') as bbox, 'EPSG:3857' as crs,
	 concat(al.layername,':+\"".$livello."\"+ILIKE+''', g.descrizione, '''+') as filter 
	 from ".$tl." g,
	 geo.api_layers al 
	 where al.title = $1 and g.descrizione ilike $2 
	 group by g.descrizione, al.repo, al.qgis_project, al.layername;";
    
    //echo $query . "<br>";
	$result = pg_prepare($conn, "my_query", $query);
	#echo $result. "<br>";
    $result = pg_execute($conn, "my_query", array($titolo, $nome));
	#echo $result. "<br>";
	#echo $query;
	#exit;
	$rows = array();
	while($r = pg_fetch_assoc($result)) {
			//echo $r;
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
