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
 // formatto il file in formato json
 header('Content-Type: application/json; charset=utf-8');




$res_ok=200;
$dettagli_errore= array();


// takes raw data from the request 
//$json = file_get_contents('php://input');
//echo $json;
// Converts it into a PHP object 
//$data = json_decode($json, true);

$data = json_decode(file_get_contents('php://input'), true);

$error='';

switch (json_last_error()) {
    case JSON_ERROR_NONE:
      //echo "No errors";
      break;
    case JSON_ERROR_DEPTH:
      $error = "Maximum stack depth exceeded";
      break;
    case JSON_ERROR_STATE_MISMATCH:
      $error = "Invalid or malformed JSON";
      break;
    case JSON_ERROR_CTRL_CHAR:
      $error = "Control character error";
      break;
    case JSON_ERROR_SYNTAX:
      $error = "Syntax error";
      break;
    case JSON_ERROR_UTF8:
      $error = "Malformed UTF-8 characters";
      break;
    default:
      $error = "Unknown error";
      break;
  }

if ($error != ''){
    http_response_code(400);
    print_r(json_encode($error));
    exit();
}


//echo $data;

//echo count($data);

include 'conn.php';



$query_insert="INSERT INTO tellus.posizioni 
            (id, data_ora,
            geoloc,
            vel, km_parziali,
            targa) VALUES
            ($1, /*to_timestamp($2, 'YYYY-MM-DD HH24:MI:SS.MS'),*/
            $2::TIMESTAMPTZ,
            ST_SetSRID(ST_MakePoint($3, $4),4326), 
            $5, $6,
            $7)
            ON CONFLICT (data_ora,targa) /* or you may use [DO NOTHING;] */ 
            DO UPDATE  
            SET data_ultima_modifica = now(),
                /*data_ora=to_timestamp($2, 'YYYY-MM-DD HH24:MI:SS.MS'),*/
                data_ora=$2::TIMESTAMPTZ,
                geoloc=ST_SetSRID(ST_MakePoint($3, $4),4326),
                vel=$5,
                km_parziali=$6,
                targa=$7";

$result = pg_prepare($conn, "query_insert", $query_insert);
    //echo  pg_last_error($conn_sovr);
    if (pg_last_error($conn)){
        
        //$dettagli_errore = $dettagli_errore. '<br>'. pg_last_error($conn);
       array_push($dettagli_errore, pg_last_error($conn));
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
        $data[$i]['longitude'],
        $data[$i]['latitude'],
        $data[$i]['vel'],
        $data[$i]['km_parziali'],
        $data[$i]['vehiclePlate'],


    )
    );
    
    
    
    if (pg_last_error($conn)){
        array_push($dettagli_errore, pg_last_error($conn));
        $res_ok=$res_ok+1;
    }

    // aggiono il contatore e leggo il secondo array del json
    $i= $i +1;

}

//echo $res_ok;
if ($res_ok>200){
    http_response_code(400);
    //echo $dettagli_errore ;
    print_r(json_encode($dettagli_errore));
} else {
    //echo '["OK"]';
    print_r(json_encode($dettagli_errore));
}

 ?>