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
$sparql = new \EasyRdf\Sparql\Client('http://dbpedia.org/sparql');

    $sparql_query = $sparql->query(
      'SELECT DISTINCT (COUNT(*) AS ?res)   WHERE {' .
        ' ?artist rdf:type dbo:Band .' .
        ' ?artist dbo:abstract ?desc .' .
        ' ?artist dbp:activeYearsStartYear ?startYear .' .
        ' ?artist dbp:bandMember ?bandMember .' .
        ' ?artist dbp:hometown ?hometown .' .
        '}'
    );

    foreach ($spaqrl_query as $res) {
      $spaqrl_query = $res->res;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibSong</title>
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
            <div class="row tm-mb-70">     
                <?php 
                foreach($result as $row){
                    $text = substr($row->summary, 0, 250);

                    $detail = [
                      'no' => $row->no,
                      'judul' => $row->title,
                      'image' =>$row->image,
                      'artist' =>$row->artist,
                      'summary' =>$row->summary,
                      'duration' =>$row->duration,
                      'genre' =>$row->genre,
                      'producer'=>$row->producer,
                      'year'=>$row->year,
                    ];
                ?>      
                <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                    <h1 class="col-12 text-light"><?=$detail['judul']?></h1>
                    <br>
                    <img src="<?=$detail['image']?>" style="width:500px;" alt="Image" class="img-fluid">
                </div>
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <br><br><br>
                        <div class="text-center mb-5">
                        <form class="d-flex tm-search-form" id="search-form" method="POST" role="search" action="tes.php">
                           <a href="video-detail.php?p=<?=$detail['no']?>" class="btn btn-primary tm-btn-big">Play MV</a>
                        </form>
                     </div>                    
                        <div class="mb-4 d-flex flex-wrap">
                            <div class="mr-4 mb-2">
                                <span class="tm-text-gray-dark">Artist: </span><span class="tm-text-primary"><?=$detail['artist']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Year: </span><span class="tm-text-primary"><?=$detail['year']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Duration : </span><span class="tm-text-primary"><?=$detail['duration']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Genre : </span><span class="tm-text-primary"><?=$detail['genre']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Producer : </span><span class="tm-text-primary"><?=$detail['producer']?></span>
                            </div>
                        </div>
                     </div>
                </div>  
                <div class="row tm-mb-70">
            <div class="mb-4">
                            <h3 class="tm-text-gray-dark mb-3">About</h3>
                            <span class="tm-text-gray-dark"><?=$detail['summary']?></span>
                        </div>
            </div>      
            </div> <!-- row -->
            <?php } ?>
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