<?php
// AUTENTICAZIONE
require_once("test_bearer.php");

// Utenze Domestiche UD / Utenze Non Domestiche UND
$tipo=$_POST['tipo'];
$row_number=$_POST['row_start'];

if ($tipo=='UD'){
    $tabella="etl.utenze_tia_domestiche";
} else if ($tipo=='UND'){
    $tabella="etl.utenze_tia_non_domestiche";
} else {
    die("Tipo utenza non supportato\n");
}

$query= "select foo.* from (
    SELECT row_number() over ( order by id_utente),* 
    FROM ".$tabella."
    ) foo where row_number>= $1 limit 1000;";

//echo $query . "<br>";
$result = pg_prepare($conn, "my_query100", $query);
#echo $result. "<br>";
$result = pg_execute($conn, "my_query100", array($row_number));
#echo $result. "<br>";
#echo $query;
#exit;
$rows = array();
while($r = pg_fetch_assoc($result)) {
		//echo $r['id_utente'];
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



?>