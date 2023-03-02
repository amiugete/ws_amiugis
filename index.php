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
            <li> Interazione con IDEA BS (prevedono utente e password, che abilita un access token con durata limitata nel tempo)
            <a href="#idea" class="btn btn-info"><i class="bi bi-link"></i> </a>
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
            
                
        
            </div>
          </div>


      <!-- FINE IDEA -->    
      </div>








<br>
<a href="#intro" class="btn btn-info"> Torna all'indice </a>
<hr>
<br>








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