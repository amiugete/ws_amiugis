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

 include 'conn.php';
 //-- ELENCO PERCORSI POSTERIORI
 $query0=" select ep.cod_percorso, 
 ep.descrizione, at2.descrizione as servizio,
 pu.id_ut, u.descrizione as ut_rimessa, 
 ep.freq_testata, fo.descrizione_long as freq,
 ep.id_turno, t.descrizione as turno, 
 ep.codice_cer, 
 to_char(pu.data_attivazione, 'YYYYMMDD') as data_inizio_validita,
 to_char((pu.data_disattivazione - interval '1' day), 'YYYYMMDD') as data_fine_validita, 
 coalesce( ep.data_ultima_modifica,'2023-07-27') as data_ultima_modifica,
 ep.versione_testata
 from anagrafe_percorsi.elenco_percorsi ep 
 join anagrafe_percorsi.anagrafe_tipo at2 
     on (select max(id_tipo) 
     from anagrafe_percorsi.elenco_percorsi ep2 
     where ep2.cod_percorso= ep.cod_percorso) = at2.id --= ep.id_tipo
 join etl.frequenze_ok fo on fo.cod_frequenza  = ep.freq_testata 
 join elem.turni t on t.id_turno = ep.id_turno 
 join anagrafe_percorsi.percorsi_ut pu 
         on pu.cod_percorso = ep.cod_percorso 
         AND (pu.data_attivazione = ep.data_inizio_validita OR pu.data_disattivazione = ep.data_fine_validita) 
         and pu.solo_visualizzazione = 'N'
 join anagrafe_percorsi.cons_mapping_uo cmu on cmu.id_uo = pu.id_ut 
 join topo.ut u on u.id_ut = cmu.id_uo_sit 
 where (ep.cod_percorso in (
         select distinct cod_percorso from anagrafe_percorsi.elenco_percorsi ep  
         where data_fine_validita >= now()::date or data_ultima_modifica >= now()::date - interval '1' day
         )  or data_fine_validita >= now()::date - interval '1' month)
         and at2.id_servizio_sit in 
           (
         select id_servizio from elem.servizi s 
         where riempimento = 1
         and id_servizio in (
             select id_servizio  from elem.elementi_servizio es where tipo_elemento in 
                 (
                 select tipo_elemento  
                 from elem.tipi_elemento te 
                 where tipologia_elemento in ('P'/*Posteriore*/, 'T' /*Terra*/)
                 )
             )
      ) and u.id_zona in (1,2,3,5,6)";

    if($_POST['last_update']){
        $query1= " and ep.data_ultima_modifica >= to_date($1, 'YYYYMMDD') order by cod_percorso, ep.versione_testata limit $2 offset $3*($4-1)";
    } else {
        $query1= ' order by cod_percorso, ep.versione_testata limit $1 offset $2*($3-1)';
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
    $result = pg_prepare($conn, "query_getpercorsi", $query);
    #echo $result. "<br>";
   
    if($_POST['last_update']){
        $result = pg_execute($conn, "query_getpercorsi", array($_POST['last_update'], $page_size, $page_size, $page_n));
    } else {
        $result = pg_execute($conn, "query_getpercorsi", array($page_size, $page_size, $page_n));
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
 ?>