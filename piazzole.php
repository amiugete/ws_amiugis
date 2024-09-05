<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include 'conn.php';





//$idcivico=$_GET["id"];
$query="select p.id_piazzola, v.nome as via,c.descr_comune as comune,m.descrizione as municipio,
q.nome  as quartiere, p.numero_civico,
p.riferimento, p.note, string_agg(concat(foo.num, ' x ', foo.descrizione),',') as elementi,
case 
when (select count(id_elemento) from elem.elementi where id_piazzola = p.id_piazzola) = 
(select count(id_elemento) from elem.elementi_privati where id_elemento in
	(select id_elemento from elem.elementi where id_piazzola = p.id_piazzola)
)  then 1
else 0
end pap,
(select count(id_elemento) from elem.elementi where id_piazzola = p.id_piazzola) as num_elementi,
(select count(id_elemento) from elem.elementi_privati where id_elemento in
	(select id_elemento from elem.elementi where id_piazzola = p.id_piazzola)
) as num_elementi_privati,
st_y(st_transform(p2.geoloc,4326)) as lat, st_x(st_transform(p2.geoloc,4326)) as lon
from elem.piazzole p 
join geo.piazzola p2 on p.id_piazzola = p2.id
join elem.aste a on a.id_asta = p.id_asta
join topo.vie v on v.id_via = a.id_via  
join topo.comuni c on v.id_comune = c.id_comune 
left join topo.quartieri q on a.id_quartiere = q.id_quartiere
left join topo.municipi m on m.id_municipio = q.id_municipio
join (
SELECT count(e.id_elemento) as num , t.nome, t.descrizione, t.tipo_rifiuto, t.tipo_elemento, t.volume,
    te.tipologia_elemento, te.descrizione as descrizione_tipologia,
    tr.nome as nome_rifiuto, tr.colore as colore_rifiuto, p.id_piazzola,
             string_agg(e.id_elemento::text, ','::text) AS elementi
         FROM elem.elementi e
    JOIN elem.tipi_elemento t ON e.tipo_elemento = t.tipo_elemento
    JOIN elem.tipi_rifiuto tr ON tr.tipo_rifiuto = t.tipo_rifiuto
    JOIN elem.tipologie_elemento te ON t.tipologia_elemento = te.tipologia_elemento
    JOIN elem.piazzole p ON e.id_piazzola = p.id_piazzola
    GROUP BY t.tipo_elemento, tr.tipo_rifiuto, te.tipologia_elemento, p.id_piazzola 
    ORDER BY tr.nome, t.descrizione
) as foo on p.id_piazzola =foo.id_piazzola
where p.data_eliminazione is null
group by p.id_piazzola, v.nome, p.numero_civico,
p.riferimento, p.note, p2.geoloc, c.descr_comune,q.nome, m.descrizione";

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