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

    <title>Pagine indice webservice</title>
  </head>
  <body>
  <div class="container">
    <h1>WS AMIU GIS</h1>
    <div id='Intro'>
        Da questa pagina si accede ad una serie di WebService creati dal gruppo GETE (Gestione Telecomunicazioni e Territorio) di AMIU 
        (Direzione Sistemi Informativi) per vari scopi:
        <ul>    
            <li> consentire un agevole accesso alle mappe da parte del portale servizi.</li>
            <li> geoservizi WMS e WFS</li>
        </ul>
    
    </div>

    <p>


    <h3>Accesso alle mappe per il portale servizi.</h3>
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
        </div>
      </div>


  </div>


<br><hr><br>

  <h3>Geoservizi WMS e WFS.</h3> (attivi su rete interna e per specifici indirizzi IP)
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


  <br><hr><br>

<h3>Altro</h3> (attivi su rete interna e per specifici indirizzi IP)
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
        <li>quartiere (per fuori Genova corrisponde al Comune e si tratta di un confine amministrativo)</li>
      
       
          
  
    </div>
  </div>
</div>




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
    </div>  
</body>

<div class="b-example-divider"></div>
<hr>

<?php
  require_once('footer.php')
?>


</footer>
</html>