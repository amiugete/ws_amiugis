<?php
namespace App;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="API Example",
 *     description="API Example related operations"
 * )
 *
 * @OA\Info(
 *     version="1.0",
 *     title="API Documetation",
 *     description="API Documetation Example",
 *     @OA\Contact(name="API Team", email="info@example.it")
 * )
 *
 * @OA\Server(
 *     url="https://example.localhost",
 *     description="API server"
 * )
 *
 * @OA\Get(
 *     path="/api/articles/{id}",
 *     @OA\Parameter(
 *     name="id",
 *     in="path",
 *     required=true,
 *     @OA\Schema(
 *             type="integer"
 *         )
 * ),
 *     @OA\Response(
 *          response="200",
 *          description="Get article",
 *          @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(ref="#/components/schemas/Article"),
 *   )
 *  ),
 *    @OA\Response(response="422", description="422 Unprocessable Entity"),
 *    @OA\Response(response="default", description="an ""unexpected"" error")
 * ),
 *
 *  @OA\Schema(
 *    schema="Article",
 *    type="object",
 *
 *   @OA\Property(
 *        property="id",
 *        description="ID article",
 *        type="integer",
 *        example=1
 *      ),
 *
 *    @OA\Property(
 *      property="title",
 *      type="string",
 *      example="Lorem Ipsum"
 *    ),
 *
 *    @OA\Property(
 *      property="created_at",
 *      type="string",
 *      example="2023-11-20 13:49:00"
 *     ),
 *
 *    @OA\Property(
 *        property="descrition",
 *        type="string",
 *        example="Aliquip adipisicing do aliquip eu officia non minim eu do amet laboris et consectetur est."
 *      )
 *    )
 */


 session_start();

 header('Content-Type: application/json; charset=utf-8');

 include 'conn.php';
 //-- ELENCO depositi
 $query0="SELECT * FROM (
 select e.id_elemento as id_ut,
concat ('RIMESSA - Rif. ', e.riferimento, ' (', e.note,')') as descrizione, 
st_x(st_transform(r.geoloc, 4326)) as long,
st_y(st_transform(r.geoloc, 4326)) as lat, 
100 as raggio, 
coalesce(to_char(data_inserimento, 'YYYYMMDD'), '19700101') as data_inizio,
to_char(least(r.data_eliminazione, e.data_eliminazione), 'YYYYMMDD') as data_fine, 
coalesce(to_char(greatest(r.data_ultima_modifica, e.data_ultima_modifica), 'YYYYMMDD'), '19700101') as data_ultima_modifica
from (select id_elemento, riferimento, note, data_inserimento, null as data_eliminazione, data_ultima_modifica 
from elem.elementi 
where tipo_elemento = 128 /*rimessa*/
union 
select id_elemento, riferimento, note, data_inserimento, data_eliminazione, data_ultima_modifica 
from history.elementi where tipo_elemento = 128)  e
join 
(
select id, geoloc, data_ultima_modifica, null as data_eliminazione from geo.rimesse
union 
select id, geoloc, data_ultima_modifica, data_eliminazione  from history.rimesse 
) r on e.id_elemento = r.id 
union 
select e.id_elemento as id_ut,
concat ('UT - Rif. ', e.riferimento, ' (', e.note,')') as descrizione, 
st_x(st_transform(ut.geoloc, 4326)) as long,
st_y(st_transform(ut.geoloc, 4326)) as lat, 
60 as raggio, 
coalesce(to_char(data_inserimento, 'YYYYMMDD'), '19700101') as data_inizio,
to_char(least(ut.data_eliminazione, e.data_eliminazione), 'YYYYMMDD') as data_fine, 
to_char(greatest(ut.data_ultima_modifica, e.data_ultima_modifica), 'YYYYMMDD') as data_ultima_modifica
from (select id_elemento, riferimento, note, data_inserimento, null as data_eliminazione, data_ultima_modifica 
from elem.elementi 
where tipo_elemento = 166/*UT*/
union 
select id_elemento, riferimento, note, data_inserimento, data_eliminazione, data_ultima_modifica 
from history.elementi where tipo_elemento = 166)  e
join (select id, geoloc, data_ultima_modifica, null as data_eliminazione from geo.unita_territoriali 
union 
select id, geoloc, data_ultima_modifica, data_eliminazione  from history.unita_territoriali )  ut 
on e.id_elemento = ut.id ) a ";

    if($_POST['last_update']){
        $query1= " where greatest(data_inizio, data_fine, data_ultima_modifica) >= $1::text
        order by 1 limit $2 offset $3*($4-1)";
    } else {
        $query1= ' order by 1 limit $1 offset $2*($3-1)';
    }

    $query= $query0 .' '. $query1;

    if($_POST['page_size']){
        $page_size= $_POST['page_size'];
    } else {    
        $page_size=1000;
    }
    if($_POST['page_n']){
        $page_n= $_POST['page_n'];
    } else {   
        $page_n=1;
    }
    //echo $query . "<br>";
    $result = pg_prepare($conn, "query_getelementip", $query);
    #echo $result. "<br>";
   
    if($_POST['last_update']){
        $result = pg_execute($conn, "query_getelementip", array($_POST['last_update'], $page_size, $page_size, $page_n));
    } else {
        $result = pg_execute($conn, "query_getelementip", array($page_size, $page_size, $page_n));
    }
    
    
    #echo $result. "<br>";
    #echo $query;
    #exit;
    $rows = array();
    while($r = pg_fetch_assoc($result)) {
            //echo $r['cod_percorso'];
            $rows[] = $r;
            //$rows[] = $rows[]. "<a href='puntimodifica.php?id=" . $r["NAME"] . "'>edit <img src='../../famfamfam_silk_icons_v013/icons/database_edit.png' width='16' height='16' alt='' /> </a>";
    }
    pg_close($conn);
    if (count($rows)>0) {
        $columnsNames = array_keys($rows[0]);
    
        //echo json_encode($columnsNames);
        //exit();
        echo '{ "meta": {"page_index":'.$page_n.', "page_max_size":'.$page_size.', ';
        echo '"page_size":'.count($rows).', "columns":'.json_encode($columnsNames).'},';
        
        $arr = array_map('array_values', $rows );
        echo '"data": '.json_encode($arr) ; //JSON_FORCE_OBJECT rimuove le quadre
        
        
        /*if (empty($rows)==FALSE){
            //var_dump(json_encode($rows));
            //print_r(json_encode(array_values(pg_fetch_all($result))));
            //print_r(json_encode(array_values(pg_fetch_all_columns($result))));
        } else {
            echo "[{\"NOTE\":'No data'}]";
    }*/
        echo '}';
        echo '';
    } else {
        echo '{ "meta": {"page_index":'.$page_n.', "page_max_size":'.$page_size.', ';
        echo '"page_size":'.count($rows).', "columns":[]},';
        echo '"data": []';
        echo '}';
        echo '';
    }
 ?>