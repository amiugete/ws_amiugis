<?php


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />

    <!-- PRISMJS -->
    <link rel="stylesheet" href="./vendor/prism.css"/>

    
    <title>Pagine indice webservice</title>
  </head>
  <body>
  <div class="container">
    <h1 id='intro'>WS AMIU GIS</h1><hr>
    <h3>Indice API</h3>
        Da questa pagina si accede ad una serie di WebService creati dal gruppo SIGT (<i>Sistemi informativi e Gestione Telecomunicazioni</i>) di AMIU 
        per vari scopi:
        <ul>    
            <li> consentire un agevole accesso alle mappe da parte del portale servizi 
            <a href="#servizi" class="btn btn-info"><i class="bi bi-link"></i> </a>
            </li>
            <li> Recupero access token 
            <a href="#token" class="btn btn-info"><i class="bi bi-link"></i> </a>
            </li>
            <li> Interazione con IDEA BS per <ul>
              <li> visualizzazione utenti Genova (acceso protetto da <a href="#token">token</a>)</li>
              <li> censimento piazzole bilaterali,</li>
              <li> visualizzazione percorsi bilaterali</li>
            </ul>
            <br>  (alcuni WS prevedono utente e password, che abilita un access token con durata limitata nel tempo) 
            <a href="#idea" class="btn btn-info"><i class="bi bi-link"></i> </a>
            </li>
            <li> Interazione con Tellus<ul>
              <li> Visualizzazione percorsi </li>
              <li> altro (in fase di sviluppo)</li>
            </ul>
            <a href="#tellus" class="btn btn-info"><i class="bi bi-link"></i> </a>
            </li>
            <li> geoservizi WMS e WFS 
            <a href="#wms_wfs" class="btn btn-info btn-sm"><i class="bi bi-link"></i> </a>
          </li>
            <li> altro 
            <a href="#altro" class="btn btn-info btn-sm"><i class="bi bi-link"></i> </a>
            </li>
        </ul>
    


    <p>


  <hr><br>


    <!-- PORTALE SERVIZI -->
    <h3 id="servizi">Accesso alle mappe per il portale servizi.</h3>
    (attivi solo su rete interna per creare mappe pubbliche)
    <div class="accordion" id="accordionExample">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" 
          aria-controls="collapseOne">
          WS con elenco mappe disponibili
          </button>
        </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
            Si tratta di un semplice WS che non richiede alcun parametro che restituisce un elenco delle mappe disponibili. 

            <br> <strong>Endpoint</strong>:
            <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/mappe.php"> 
            https://amiugis.amiu.genova.it/ws_amiugis/mappe.php
            </a>
            
            
                
        
            </div>
          </div>
      </div>






      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
          aria-controls="collapseTwo">
            WS per la formazione dell’url delle mappe dinamiche da inserire sul portale servizi
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          All’interno dello stesso server AMIU ha  creato un WS che serve al portale servizi per costruire 
          l’url delle mappe dinamiche da inserire sul portale servizi.
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/layer_filter.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/layer_filter.php
            </a>
          <br> <strong>Metodo: GET </strong>
          <br> <strong>Parametri</strong>:
          <ul>
          <li>t: titolo della mappa. (vedi WS precedente).</li> 
          <li> l: livello del filtro. Esistono attualmente 3 livelli:</li>
            <ul>    
                <li> ambito</li>
                <li> comune</li>
                <li> municipio</li>
            </ul>
            <li> n: nome da usare nel filtro</li>
          </ul>
          Il WS risponde con un json con url e parametri da usare per creare l’url con cui accedere alle mappe. I parametri sono in totale 5:
        <ul>
        <li>url: endpoint pubblico da usare per costruire le mappe</li>
        <li>repository: nome repository lizmap su cui risiede il progetto QGIS da visualizzare</li>
        <li>project: nome progetto QGIS</li>
        <li>crs: codice EPSG</li>
        <li>bbox: boundary box su cui centrare la mappa</li>
        <li>filter: filtro da applicare</li>
            </ul>
          </div>
        </div>
      </div>


  </div>


<br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>



<!-- TOKEN -->
<h3 id="token">Recupero access token</h3>
    (attivi solo su rete interna o da specifici indirizzi IP)
    <div class="accordion" id="accordionToken">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="h_token">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneToken" aria-expanded="false" 
          aria-controls="collapseOneToken">
          WS pr recuperare il TOKEN di autenticazione
          </button>
        </h2>
          <div id="collapseOneToken" class="accordion-collapse collapse show" aria-labelledby="h_token" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con il TOKEN da usare per le API che lo richiedano
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/create_token.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/create_token.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri</strong>:
          <ul>
          <li> user: nome utente</li> 
          <li> pwd: password</li>
          </ul>
          Il WS risponde con un json con lo user token
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "user=xxxxxx&pwd=yyyyyy" -X POST http://amiugis.amiu.genova.it/ws_amiugis/create_token.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE TOKEN -->    
            </div>

            <br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>
<!-- IDEA --> 
  <h3 id="idea">Interazione con IDEA.</h3>
    (attivi solo su rete interna o da specifici indirizzi IP)
    <div class="accordion" id="accordionToken">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="h_tari">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneTari" aria-expanded="false" 
          aria-controls="collapseOneTari">
          WS con utenze TARI (richiede access token)
          </button>
        </h2>
          <div id="collapseOneTari" class="accordion-collapse collapse show" aria-labelledby="h_tari" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con le utenze TARI  (formato JSON) filtrate sulla base dei parametri 
            (opzionali) che gli passa l'utente. Il massimo numero di utenze passate ad ogni richiesta è di 1000 utenze e 
            si può specificare il parametro <i>row_start</i> per visualizzare progressivamente tutte le utenze. 
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/utenze_tari.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/utenze_tari.php
            </a>
          <br> <strong>Autenticazione: Bearer &lt;TOKEN&gt; </strong>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri</strong>:
          <ul>
          <li> tipo: [<b>UD</b>:Utenze Domestiche / <b>UND</b> titolo della mappa].</li>
          <li> row_start: valore numerico (intero).</li> 
          <!--li> l: livello del filtro. Esistono attualmente 3 livelli:</li-->
          </ul>
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl --header "Authorization: Bearer XXXXXXXXXXXXXX" -d 'tipo=UND&row_start=10000' http://amiugis.amiu.genova.it/ws_amiugis/utenze_tari.php
            </code>
          </pre>


            </div>
            
                
        
            </div>
          </div>



          <div class="accordion-item">
        <h2 class="accordion-header" id="ep">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_ep_tree" aria-expanded="false" 
          aria-controls="collapseOne_ep_tree">
          Elenco dei percorsi bilaterali ad albero
          </button>
        </h2>
          <div id="collapseOne_ep_tree" class="accordion-collapse collapse show" aria-labelledby="ep" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con l'elenco dei percorsi bilaterali (formato JSON)
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali_tree.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali_tree.php
            </a>

            <br><br>Il WS risponde con un json con il seguente formato:
          <ul>
            <li> id_area: </li>
            <li> descrizione : </li>
            <li> id_padre: livello precedente</li>
          </ul> 
          <br> Il 
          <!--br><hr><br>     
          All'ultimo livello il campo <b>descrizione</b> è così definita: <br><br>
          id_percorso;descrizione_percorso (cod. cod_percorso)<br><br>

          <b>id_percorso</b> va poi usato come input (<b>id</b>) per vedere i dettagli del singolo percorso (vedi <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/dettagli_percorso.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/dettagli_percorso.php
            </a>) <br-->
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl http://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali_tree.php
            </code>
          </pre>


            </div>
            
                
        
            </div>
          </div>



          <div class="accordion-item">
        <h2 class="accordion-header" id="ep">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_ep" aria-expanded="false" 
          aria-controls="collapseOne_ep">
          Elenco dei percorsi bilaterali
          </button>
        </h2>
          <div id="collapseOne_ep" class="accordion-collapse collapse show" aria-labelledby="ep" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con l'elenco dei percorsi bilaterali (formato JSON)
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali.php
            </a>

            <br><br>Il WS risponde con un json con l'elenco dei percorsi con i seguenti attributi:
          <ul>
            <li> id_padre: livello padre(vedi WS precedente) </li>
            <li> ut responsabile : rimessa di partenza (è implicito da id_padre)</li>
            <li> id_tipo_rifiuto: descrizione del servizio (è implicito da id_padre)</li>
            <li> tipi_rifiuto: descrizione del servizio (è implicito da id_padre)</li>
            <li> desc_turno: distinzione fra turno  [A: antimeridiano, P: Pomeridiano, N: Notturno, F: Festivo, etc] (è implicito da id_padre)</li>
            <li> id_percorso: da usare per recuperare i dati del percorso ma da tenere nascosto agli autisti </li>
            <li> cod_percorso : codice percorso, insieme alla descrizione del percorso deve essere usato per consentire la scelta all'autista</li>
            <li> descrizione: descrizione del percorso </li>
            <li> frequenza: giorni in cui è previsto il percorso (può essere messo tra parentesi oltre alla descrizione quale ulteriore supporto alla scelta del percorso) </li>
          </ul> 
                    
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl http://amiugis.amiu.genova.it/ws_amiugis/elenco_percorsi_bilaterali.php
            </code>
          </pre>


            </div>
            
                
        
            </div>
          </div>


          


          <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_dp" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Dettagli percorso
          </button>
        </h2>
          <div id="collapseOne_dp" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli del percorso
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/dettagli_percorso.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/dettagli_percorso.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
            <br> <strong>Parametri</strong>:
            <ul>
            <li> id: indicare l'id percorso</li>
            <!--li> l: livello del filtro. Esistono attualmente 3 livelli:</li-->
            </ul>
          Il WS risponde con un json con i dettagli del percorso con i seguenti attributi:
          <ul>
            <li> seq: ordine piazzola </li>
            <li> id_piazzola : id postazione</li>
            <li> via: nome via</li>
            <li> civ: eventuale numero civico</li>
            <li> riferimento: riferimento piazzola </li>
            <li> note_piazzola: eventuali altre note della piazzola </li>
            <li> tipo_elem : tipo elemento</li>
            <li> num: numero elementi </li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "id=XXXXXX" -X POST http://amiugis.amiu.genova.it/ws_amiugis/dettagli_percorso.php
            </code>
          </pre>


            </div>
            
           
            <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_piazzole" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Piazzole
          </button>
        </h2>
          <div id="collapseOne_piazzole" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli delle piazzole
        
          <br> <strong>Endpoint WS</strong>: <a target="piazzole" href="https://amiugis.amiu.genova.it/ws_amiugis/piazzole.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/piazzole.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli delle piazzole con i seguenti attributi:
          <ul>
            <li> id_piazzola : id postazione</li>
            <li> via: nome via</li>
            <li> comune: nome comune</li>
            <li> municipio (solo per Comune di Genova)</li>
            <li> quartiere (solo per Comune di Genova)</li>
            <li> numero civico: eventuale numero civico</li>
            <li> riferimento: riferimento piazzola </li>
            <li> note: eventuali altre note della piazzola </li>
            <li> elementi : eventuali altre note della piazzola </li>
            <li> pap : 1 se Porta a Porta (PAP) - 0 se piazzola normale</li>
            <li> num_elementi: numero elementi presenti in piazzola</li>
            <li> num_elementi_privati: numero elementi privati presenti in piazzola</li>
            <li> lat: latitudine piazzola </li>
            <li> lon: longitudine piazzola </li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/piazzole.php
            </code>
          </pre>


            </div>
          





            <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_poi" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Point Of Interest
          </button>
        </h2>
          <div id="collapseOne_poi" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli dei Punti di Interesse (Rimesse, UT e Scarichi vari)
        
          <br> <strong>Endpoint WS</strong>: <a target="piazzole" href="https://amiugis.amiu.genova.it/ws_amiugis/poi_idea.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/poi_idea.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli dei Punti di Interesse (Point of Interest) che corrispondono a Rimesse, UT e Scarichi vari:
          <ul>
            <li> id : id punto di interesse</li>
            <li> via: nome via</li>
            <!--li> comune: nome comune</li>
            <li> municipio (solo per Comune di Genova)</li>
            <li> quartiere (solo per Comune di Genova)</li-->
            <li> numero civico: eventuale numero civico</li>
            <li> riferimento: riferimento </li>
            <li> note: eventuali altre note  </li>
            <li> lat: latitudine </li>
            <li> lon: longitudine </li>
            <li> tipo: tipologia POI </li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/poi_idea.php
            </code>
          </pre>


            </div>



            <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_ambiti" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Ambiti
          </button>
        </h2>
          <div id="collapseOne_ambiti" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli degli ambiti AMIU (dimensione sovra-comunale usata da AMIU nell'ambito del contratto di servizio)
        
          <br> <strong>Endpoint WS</strong>: <a target="ambiti" href="https://amiugis.amiu.genova.it/ws_amiugis/ambiti.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/ambiti.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli degli ambiti che sono una dimensione sovra-comunale usata da AMIU nell'ambito del contratto di servizio:
          <ul>
            <li> id_ambito : id ambito</li>
            <li> descr_ambito: descrizione ambito</li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/ambiti.php
            </code>
          </pre>
            </div>






            <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_comuni" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Comuni
          </button>
        </h2>
          <div id="collapseOne_comuni" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli dei Comuni
        
          <br> <strong>Endpoint WS</strong>: <a target="ambiti" href="https://amiugis.amiu.genova.it/ws_amiugis/comuni.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/comuni.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli dei Comuni gestiti da AMIU :
          <ul>
            <li> id_comune : id Comune</li>
            <li> descr_comune: nome del Comune</li>
            <li> descr_provincia: nome della Provincia</li>
            <li> prefisso_utenti: prefisso interno usato per il Comune</li>
            <li> id_ambito : id ambito</li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/comuni.php
            </code>
          </pre>
            </div>


    <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_municipi" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Municipi (solo per Genova)
          </button>
        </h2>
          <div id="collapseOne_comuni" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli dei Municipi 
        
          <br> <strong>Endpoint WS</strong>: <a target="ambiti" href="https://amiugis.amiu.genova.it/ws_amiugis/municipi.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/municipi.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli dei Municipi :
          <ul>
            <li> id_municipio : id Municipio</li>
            <li> id_comune : id Comune</li>
            <li> descrizione : nome del Municipio</li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/municipi.php
            </code>
          </pre>
            </div>

        <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_quartieri" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Quartieri
          </button>
        </h2>
          <div id="collapseOne_comuni" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli dei quartieri
        
          <br> <strong>Endpoint WS</strong>: <a target="ambiti" href="https://amiugis.amiu.genova.it/ws_amiugis/quartieri.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/quartieri.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli dei Comuni gestiti da AMIU :
          <ul>
            <li> id_quartiere : id quartiere</li>
            <li> id_municipio: id Municipio</li>
            <li> id_comune : id Comune</li>
            <li> descrizione : descrizione del quartiere</li>
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/qartieri.php
            </code>
          </pre>
            </div>


            <div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_vie" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Vie
          </button>
        </h2>
          <div id="collapseOne_vie" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli delle vie
        
          <br> <strong>Endpoint WS</strong>: <a target="ambiti" href="https://amiugis.amiu.genova.it/ws_amiugis/vie.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/vie.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli delle vie per ogni Comune:
          <ul>
            <li> id_via : id via</li>
            <li> nome : nome via</li>
            <li> id_comune : id Comune</li>
            
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/vie.php
            </code>
          </pre>
            </div>


        
            </div>
          </div>

<div class="accordion-item">
        <h2 class="accordion-header" id="dp">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_civici" aria-expanded="false" 
          aria-controls="collapseOne_dp">
          Civici
          </button>
        </h2>
          <div id="collapseOne_civici" class="accordion-collapse collapse show" aria-labelledby="dp" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli delle civici (per ora solo Genova)
        
          <br> <strong>Endpoint WS</strong>: <a target="civici" href="https://amiugis.amiu.genova.it/ws_amiugis/civici.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/civici.php
            </a>
          
            <br> <strong>Metodo: POST </strong>
          Il WS risponde con un json con i dettagli dei civici per ora solo di Genova:
          <ul>
            <li> cod_civico : id via</li>
            <li> numero </li>
            <li>   lettera</li>
            <li>   colore</li> 
            <li>   testo</li>
            <li>  cod_strada</li>
            <li> id_comune</li> 
            <li>  id_municipio</li> 
            <li>  id_quartiere</li>
            <li>  lat</li>
            <li>  lon</li>
            <li> insert_date</li>
            <li> update_date</li>              
          </ul>   
          
          
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -X POST http://amiugis.amiu.genova.it/ws_amiugis/civici.php
            </code>
          </pre>
            </div>


        
            </div>
          </div>
      <!-- FINE IDEA -->    
      </div>








<br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>

<!-- TELLUS -->
<h3 id="tellus">Interazione con Tellus</h3>
    (attivi solo su rete interna o da specifici indirizzi IP)
    <div class="accordion" id="accordionToken">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="GetPercorsi">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneGetPercorsi" aria-expanded="false" 
          aria-controls="collapseOneGetPercorsi">
          WS per recuperare i Percorsi Posteriori (item D)
          </button>
        </h2>
          <div id="collapseOneGetPercorsi" class="accordion-collapse collapse show" aria-labelledby="h_GetPercorsi" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con l'elenco dei percorsi posteriori
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/GetPercorsiP.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/GetPercorsiP.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri (opzionali)</strong>:
          <ul>
          <li> last_update: ultima data di aggiornamento in formato YYYYMMDD (default <i>none</i>)</li> 
          <li> page_size: (default 1000)</li>
          <li> page_n: numero pagina (default 1)</li>
          </ul>
          Il WS risponde con l'elenco delle informazioni sui percorsi Posteriori
          <ul>
          <li>
          CodPercorso*
          </li><li>
          Descrizione
          </li><li>
          Servizio
          </li><li>
          Id_ut*
          </li><li>
          Ut_rimessa
          </li><li>
          Freq_testata
          </li><li>
          Freq
          </li><li>
          Id_turno
          </li><li>
          Turno
          </li><li>
          Codice cer
          </li><li>
          Data_inizio_validita(inc)
          </li><li>
          Data_fine_Validità(escl)
          </li><li>
          Data_ultima_Modifica
          </li><li>
          Versione_Testata* (int)
            </li></ul>
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "last_update=20240601&page_size=200&page_n=1" -X POST http://amiugis.amiu.genova.it/ws_amiugis/GetPercorsiP.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE GetPercorsi -->    








            </div>

            
            
            <div class="accordion" id="accordionToken">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="GetPiazzole">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneGetPiazzole" aria-expanded="false" 
          aria-controls="collapseOneGetPiazzole">
          WS per recuperare le Piazzole AMIU (o Punti di Raccolta) (item D)
          </button>
        </h2>
          <div id="collapseOneGetPiazzole" class="accordion-collapse collapse show" aria-labelledby="h_GetPiazzole" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con l'elenco dei percorsi posteriori
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/GetPiazzole.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/GetPiazzole.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri (opzionali)</strong>:
          <ul>
          <li> last_update: ultima data di aggiornamento in formato YYYYMMDD (default <i>none</i>)</li> 
          <li> page_size: (default 1000)</li>
          <li> page_n: numero pagina (default 1)</li>
          </ul>
          Il WS risponde con l'elenco delle informazioni sulle piazzole
          <ul>
          <li>
          Id_Piazzola*
          </li><li>
          Via 
          </li><li>
          Numero_civico
          </li><li>
          Riferimento
          </li><li>
          Note
          </li><li>
          Lat
          </li><li>
          Lon
          </li><li>
          Data_eliminazione ('YYYYMMDD') 
          </li><li>
          Data_ultima_modifica ('YYYYMMDD') 
          </li>
         </ul>
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "last_update=20240601&page_size=200&page_n=1" -X POST http://amiugis.amiu.genova.it/ws_amiugis/GetPiazzole.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE GetPiazzole -->  

            <div class="accordion" id="accordionToken">
          
      <div class="accordion-item">
        <h2 class="accordion-header" id="GetElementiP">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneGetElementiP" aria-expanded="false" 
          aria-controls="collapseOneGetElementiP">
          WS per recuperare gli elementi posteriori (item D)
          </button>
        </h2>
          <div id="collapseOneGetElementiP" class="accordion-collapse collapse show" aria-labelledby="h_GetElementiP" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con l'elenco degli elementi Posteriori o ad essi assimilabili
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/GetElementiP.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/GetElementiP.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri (opzionali)</strong>:
          <ul>
          <li> last_update: ultima data di aggiornamento in formato YYYYMMDD (default <i>none</i>)</li> 
          <li> page_size: (default 1000)</li>
          <li> page_n: numero pagina (default 1)</li>
          </ul>
          Il WS risponde con l'elenco delle informazioni sugli elementi
          <ul>
          <li>
          Id_Elemento*
          </li><li>
          Id_Piazzola 
          </li><li>
          id_tipo_elemento 
          </li><li>
          tipo_elemento
          </li><li>
          rifiuto
          </li><li>
          volume_litri
          </li><li>
          Matricola
          </li><li>
          Tag
          </li><li>
          Serratura (0: non presente, NULL: manca informazione, 1: presente)
          </li><li>
          Data_Inserimento ('YYYYMMDD') 
          </li><li>
          Data_eliminazione ('YYYYMMDD') 
          </li><li>
          Data_ultima_modifica ('YYYYMMDD') 
          </li>
         </ul>
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "last_update=20240601&page_size=200&page_n=1" -X POST http://amiugis.amiu.genova.it/ws_amiugis/GetElementiP.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE GetElementiP -->





            <div class="accordion-item">
        <h2 class="accordion-header" id="GetItinerari">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneGetItinerari" aria-expanded="false" 
          aria-controls="collapseOneGetItinerari">
          WS per recuperare gli Itinerari dei percorsi Posteriori (item D)
          </button>
        </h2>
          <div id="collapseOneGetItinerari" class="accordion-collapse collapse show" aria-labelledby="h_GetItinerari" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli degli Itinerari (tappe) dei percorsi posteriori
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/GetItinerariP.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/GetItinerariP.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri (opzionali)</strong>:
          <ul>
          <li> last_update: ultima data di aggiornamento in formato YYYYMMDD (default <i>none</i>)</li> 
          <li> page_size: (default 1000)</li>
          <li> page_n: numero pagina (default 1)</li>
          </ul>
          Il WS risponde con l'elenco delle informazioni sugli Itinerari dei percorsi posteriori
          <ul>
          <li>
          CodPercorso*
          </li><li>
          Ordine
          </li><li>
          Id_elemento*
          </li><li>
          Id_frequenza
          </li><li>
          Descrizione_long (descrizione della frequenza)
          </li><li>
          data_inizio ('YYYYMMDD') inclusa
          </li><li>
          data_fine ('YYYYMMDD') inclusa
          </li><li>
          Id_asta_percorso*
          </li><li>
          data_ultima_modifica ('YYYYMMDD') 
          </li></ul>
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "last_update=20240601&page_size=200&page_n=1" -X POST http://amiugis.amiu.genova.it/ws_amiugis/GetItinerariP.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE GetItinerari -->  



            <div class="accordion-item">
        <h2 class="accordion-header" id="GetDepositi">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneGetDepositi" aria-expanded="false" 
          aria-controls="collapseOneGetDepositi">
          WS per recuperare posizione di Unità territoriali e Rimesse (item D)
          </button>
        </h2>
          <div id="collapseOneGetDepositi" class="accordion-collapse collapse show" aria-labelledby="h_GetDepositi" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Il Webservice risponde con i dettagli di Unità territoriali e Rimesse
        
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/GetDepositi.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/GetDepositi.php
            </a>
          <br> <strong>Metodo: POST </strong>
          <br> <strong>Parametri (opzionali)</strong>:
          <ul>
          <li> last_update: ultima data di aggiornamento in formato YYYYMMDD (default <i>none</i>)</li> 
          <li> page_size: (default 1000)</li>
          <li> page_n: numero pagina (default 1)</li>
          </ul>
          Il WS risponde con l'elenco delle informazioni su Unità territoriali e Rimesse
          <ul>
          <li>
          id*
          </li><li>
          Descizione
          </li><li>
          Long
          </li><li>
          Lat
          </li><li>
          Raggio
          </li><li>
          data_inizio ('YYYYMMDD') inclusa
          </li><li>
          data_fine ('YYYYMMDD') inclusa
          </li><li>
          data_ultima_modifica ('YYYYMMDD') 
          </li></ul>
          <hr>
          <h5>ESEMPIO:</h5>

          <pre class="data-line data-language">
            <code class="language-bash">
curl -d "last_update=20240601&page_size=200&page_n=1" -X POST http://amiugis.amiu.genova.it/ws_amiugis/GetDepositi.php
            </code>
          </pre>

          
            </div>
            
                
        
            </div>
          </div>
            <!-- FINE GetDepositi -->  

            <br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>






  <h3 id="wms_wfs">Geoservizi WMS e WFS.</h3> (attivi su rete interna e per specifici indirizzi IP)
    <div class="accordion" id="accordionExamplebis">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnebis" aria-expanded="false" 
      aria-controls="collapseOnebis">
      Confini zone AMIU per il portale delle segnalazioni
    </button>
    </h2>
    <div id="collapseOnebis" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExamplebis">
      <div class="accordion-body">
        Si tratta in questo caso di WS secondo lo standard OGC (Open Geospatial Consortium) di tipo 
        <a href="https://amiugis.amiu.genova.it/cgi-bin/qgis_mapserv.fcgi?SERVICE=WMS&VERSION=1.3.0&REQUEST=GetCapabilities&MAP=/home/procedure/webgis/only_qgis_server/confini.qgs"
        target="wms">WMS</a> e
        <a href="https://amiugis.amiu.genova.it/cgi-bin/qgis_mapserv.fcgi?SERVICE=WFS&VERSION=1.1.0&REQUEST=GetCapabilities&MAP=/home/procedure/webgis/only_qgis_server/confini.qgs"
        target="wfs">WFS</a>.
        <br>
        Contengono i confini: 
        <ul>
        <li>comuni (confini_comuni_area)</li>
        <li>ambiti (v_ambiti)</li>
        
        <li>per il solo comune di Genova:</li>
            <ul>
            <li>municipi (municipi_area)</li>
            <li>quartieri (quartieri_area)</li>
            <li>confini UT (confini_ut_zona)</li>
            <li>confini zone (confini_zone_amiu)</li>
            </ul>  

        <li>grafo stradale dei comuni serviti da Amiu (mv_nomi_via) filtrabili per id_comune</li>
        </ul>
        </a>
        
         
            
    
      </div>
    </div>
  </div>



  <!--div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
       aria-controls="collapseTwo">
        WS per la formazione dell’url delle mappe dinamiche da inserire sul portale servizi
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      All’interno dello stesso server AMIU ha  creato un WS che serve al portale servizi per costruire 
      l’url delle mappe dinamiche da inserire sul portale servizi.
      <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/layer_filter.php"> 
          https://amiugis.amiu.genova.it/ws_amiugis/layer_filter.php
        </a>
      <br> <strong>Parametri</strong>:
      <ul>
      <li>t: titolo della mappa. Attualmente esiste solo la mappa delle piazzole (piazzole) ma ne saranno progressivamente create altre.</li> 
      <li> l: livello del filtro. Esistono attualmente 3 livelli:</li>
        <ul>    
            <li> ambito</li>
            <li>comune</li>
            <li> municipio</li>
        </ul>
        <li> n: nome da usare nel filtro</li>
       </ul>
Il WS risponde con un json con url e parametri da usare per creare l’url con cui accedere alle mappe. I parametri sono in totale 5:
    <ul>
    <li>url: endpoint pubblico da usare per costruire le mappe</li>
    <li>repository: nome repository lizmap su cui risiede il progetto QGIS da visualizzare</li>
    <li>project: nome progetto QGIS</li>
    <li>crs: codice EPSG</li>
    <li>bbox: boundary box su cui centrare la mappa</li>
    <li>filter: filtro da applicare</li>
        </ul>
      </div>
    </div-->


  </div> <!-- Fine accordion!-->


  <br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>





<h3 id="altro">Altro</h3> (attivi su rete interna e per specifici indirizzi IP)
  <div class="accordion" id="accordionExampletris">
<div class="accordion-item">
  <h2 class="accordion-header" id="headingOne">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnetris" aria-expanded="false" 
    aria-controls="collapseOnetris">
   Localizzazione da punto
  </button>
  </h2>
  <div id="collapseOnetris" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampletris">
    <div class="accordion-body">
      Si tratta in questo caso di un WS creato da AMIU per recuperare la posizione di un punto sulla base delle sue coordinate espresse in gradi decimale (WGS84) 
          <br> <strong>Endpoint WS</strong>: <a target="mappe" href="https://amiugis.amiu.genova.it/ws_amiugis/point2area.php"> 
              https://amiugis.amiu.genova.it/ws_amiugis/point2area.php
            </a>
          <br> <strong>Metodo</strong>: <i>GET</i>
          <br> <strong>Parametri</strong>:
          <ul>
          <li> lat: latitudine del punto espressa in gradi decimali (es.44.536653)</li> 
          <li> lon: longitudine del punto espressa in gradi decimali (es. 8.8753814)</li>
          </ul>
          Il WS risponde con un json con i seguenti valori:
        <ul>
        <li>ambito (confine AMIU)</li>
        <li>comune (confine amministrativo)</li>
        <li>zona (confine AMIU)</li>
        <li>UT (confine AMIU)</li>
        <li>municipio (confine amministrativo)</li>
        <li>quartiere (si tratta di un confine amministrativo, per i comuni fuori Genova corrisponde al Comune)</li>
      
       
          
  
    </div>
  </div>
</div>


<br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>

</div> <!-- Fine accordion!-->









</div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->


    <script src="./vendor/prism.js"></script>


  </div>  


</body>

<div class="b-example-divider"></div>
<hr>

<?php
  require_once('footer.php')
?>


</footer>
</html>