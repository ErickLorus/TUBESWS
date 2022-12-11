<?php
require 'vendor/autoload.php';

\EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
\EasyRdf\RdfNamespace::set('www', 'http://www.semanticweb.org/');
\EasyRdf\RdfNamespace::set('xml', 'http://www.w3.org/XML/1998/namespace');
\EasyRdf\RdfNamespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
\EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
\EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
\EasyRdf\RdfNamespace::set('schema', 'https://example.org/schema/');
\EasyRdf\RdfNamespace::set('music', 'https://example.org/schema/music');
\EasyRdf\RdfNamespace::setDefault('og');
$p = $_GET['p'];
$sparql_jena = new \EasyRdf\Sparql\Client('http://localhost:3030/data_musik/sparql');

$sparql_query = '
SELECT ?m ?title ?artist ?link ?no WHERE {
    ?m rdf:type music:song;
       rdfs:label ?title;
       music:artist ?artist;
       foaf:homepage ?link;
       music:number ?no;
  FILTER(?no = "'.$p.'").
} ';
$result = $sparql_jena->query($sparql_query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lib Song Video Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
</head>
<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>

    <?php include 'header.php'; ?>

    <div class="container-fluid tm-container-content tm-mt-60">
    <?php
          foreach($result as $row){
                $music_video = \EasyRdf\Graph::newAndLoad($row->link);

                $detail = [
                  'no' => $row->no,
                  'judul' => $row->title,
                  'artist' =>$row->artist,

                ];
    ?>
        <div class="row">
            <center>
            <h2 class="col-12 text-light"><?= $detail['judul']?> MV </h2>
        </div>
        <center>
        <div class="row tm-mb-90">            
            <div class="col">
            <iframe width="1008" height="567" src="<?=$music_video?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
            </div>
            
        </div>
    <?php } ?>      
        </div> <!-- row -->
    </div> <!-- container-fluid, tm-container-content -->

    <?php include 'footer.php'; ?>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>