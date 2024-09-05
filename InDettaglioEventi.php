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

$res_ok=200;
// takes raw data from the request 
$json = file_get_contents('php://input');
//echo $json;
// Converts it into a PHP object 
$data = json_decode($json, true);

//echo $data;

//echo count($data);

include 'conn.php';



$query_insert="INSERT INTO tellus.dettaglio_eventi 
            (id, data_ora, geoloc,
            info0, info1, info2, info3,
            tipo_evento, targa) VALUES
            ($1, $2, ST_SetSRID(ST_MakePoint($3, $4),4326), $5, $6, $7,
            $8, $9, $10)
            ON CONFLICT (id) /* or you may use [DO NOTHING;] */ 
            DO UPDATE  
            SET data_ora=$2,
                geoloc=ST_SetSRID(ST_MakePoint($3, $4),4326),
                info0=$5,
                info1=$6,
                info2=$7,
                info3=$8,
                tipo_evento=$9, 
                targa=$10";

$result = pg_prepare($conn, "query_insert", $query_insert);
    //echo  pg_last_error($conn_sovr);
    if (pg_last_error($conn_sovr)){
        echo pg_last_error($conn_sovr);
        $res_ok=$res_ok+1;
    }



$i=0;
while ($i < count($data)){
    //echo $data[$i]['id'].'<br>';
    //echo $data[$i]['dateTime'].'<br>';
    //echo $data[$i]['latitude'].'<br>';
    


    

    $result = pg_execute($conn, "query_insert", 
    array(
        $data[$i]['id'],
        $data[$i]['dateTime'],
        $data[$i]['latitude'],
        $data[$i]['longitude'],
        $data[$i]['info0'],
        $data[$i]['info1'],
        $data[$i]['info2'],
        $data[$i]['info3'],
        $data[$i]['eventTypeId'],
        $data[$i]['vehiclePlate'],


    )
    );
    
    
    
    if (pg_last_error($conn_sovr)){
        echo pg_last_error($conn_sovr);
        $res_ok=$res_ok+1;
    }

    // aggiono il contatore e leggo il secondo array del json
    $i= $i +1;

}

echo $res_ok;

 ?>