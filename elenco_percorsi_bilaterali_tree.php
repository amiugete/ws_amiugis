<?php
session_start();

// AUTENTICAZIONE
//require_once("test_bearer.php");

include 'conn.php';




//$idcivico=$_GET["id"];

// OLD
/*$query="select * from etl.v_percorsi_bilaterali_1
union 
select * from etl.v_percorsi_bilaterali_2
union 
select * from etl.v_percorsi_bilaterali_3
union 
select * from etl.v_percorsi_bilaterali_4
order by 1";
*/


// senza frequenza
/*$query="select * from etl.v_percorsi_bilaterali_1
union 
select * from etl.v_percorsi_bilaterali_2
union 
select * from etl.v_percorsi_bilaterali_3
order by 1";*/

$query="select * from  
(select * from etl.v_percorsi_bilaterali_1
union 
select * from etl.v_percorsi_bilaterali_2
union 
select * from etl.v_percorsi_bilaterali_3
union
select * from etl.v_percorsi_bilaterali_4
union 
select * from etl.v_percorsi_bilaterali_5)
a
order by coalesce(id_padre,0),
CASE 
	WHEN descrizione  = 'Lun' THEN 1
          WHEN descrizione  = 'Mar' THEN 2
          WHEN descrizione = 'Mer' THEN 3
          WHEN descrizione = 'Gio' THEN 4
          WHEN descrizione = 'Ven' THEN 5
          WHEN descrizione = 'Sab' THEN 6
          WHEN descrizione = 'Dom' THEN 7
          else  0
end";

# faccio la query
$result = pg_prepare($conn, "my_query", $query);
$result = pg_execute($conn, "my_query", array());
$rows=pg_fetch_all($result);
//echo "<br> <br>";



pg_close($conn);
#echo $rows ;
if (empty($rows)==FALSE){
	//print $rows;
	print json_encode($rows);
} else {
	echo "[{\"NOTE\":'No data'}]";
}

?>