<?php
session_start();

include 'conn.php';





//$idcivico=$_GET["id"];
$query="select id_ambito, descr_ambito from topo.ambiti a";

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