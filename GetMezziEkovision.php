<?php
    session_start();
    $res_ok=200;
    $dettagli_errore= array();

    header('Content-Type: application/json; charset=utf-8');

    include 'conn.php';

    //-- ELENCO depositi
    $query_mezzi="SELECT m.id_scheda_ekovision, 
    see.data_esecuzione_prevista, see.orario_esecuzione, see.fascia_turno,
    m.sportello
    /*,see.nomefile*/ 
    from consunt.mezzi m 
    join consunt.schede_eseguite_ekovision see on see.id_scheda = m.id_scheda_ekovision 
    where see.data_esecuzione_prevista = $1
    order by see.data_esecuzione_prevista, m.sportello limit $2 offset $3*($4-1)";

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
     if($_POST['check_date']){
        $check_date= strval($_POST['check_date']);
        #echo 'check_date: '.$check_date.'<br>';
    } else { 
        http_response_code(400);  
        array_push($dettagli_errore, 'Manca parametro check_date');
        print_r(json_encode($dettagli_errore));
        exit();
    }

    //echo 'page_size: '.$page_size.' page_n: '.$page_n.'<br>';
    //echo 'data post: '.$_POST["checkdate"].'<br>';
    //echo $query . "<br>";
    $result = pg_prepare($conn, "query_getmezzieko", $query_mezzi);
    if (pg_last_error($conn)){
        
        //$dettagli_errore = $dettagli_errore. '<br>'. pg_last_error($conn);
       array_push($dettagli_errore, pg_last_error($conn));
        $res_ok=$res_ok+1;
    }

    $result = pg_execute($conn, "query_getmezzieko", array($check_date, $page_size, $page_size, $page_n));
    if (pg_last_error($conn)){
        
        //$dettagli_errore = $dettagli_errore. '<br>'. pg_last_error($conn);
       array_push($dettagli_errore, pg_last_error($conn));
        $res_ok=$res_ok+1;
    }

    $rows = array();
    while($r = pg_fetch_assoc($result)) {
            //echo $r['cod_percorso'];
            $rows[] = $r;
    }
    pg_close($conn);
    if (count($rows)>0) {
        $columnsNames = array_keys($rows[0]);
        echo '{ "meta": {"page_index":'.$page_n.', "page_max_size":'.$page_size.', ';
        echo '"page_size":'.count($rows).', "columns":'.json_encode($columnsNames).'},';
        
        $arr = array_map('array_values', $rows );
        echo '"data": '.json_encode($arr) ;
        echo '}';
        echo '';
    } else {
        echo '{ "meta": {"page_index":'.$page_n.', "page_max_size":'.$page_size.', ';
        echo '"page_size":'.count($rows).', "columns":[]},';
        echo '"data": []';
        echo '}';
        echo '';
    }

    if ($res_ok>200){
        http_response_code(400);
        //echo $dettagli_errore ;
        print_r(json_encode($dettagli_errore));
    } else {
        //echo '["OK"]';
        print_r(json_encode($dettagli_errore));
    }
 ?>