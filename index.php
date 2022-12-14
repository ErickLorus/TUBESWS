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

$sparql_jena = new \EasyRdf\Sparql\Client('http://localhost:3030/data_musik/sparql');

$sparql_query = '
SELECT ?m ?title ?image ?artist ?year ?no WHERE {
    ?m rdf:type music:song;
       rdfs:label ?title;
       music:image ?image;
       music:artist ?artist;
       music:year ?year;
       music:number ?no.
} ORDER BY DESC(?year)
LIMIT 8';
$result = $sparql_jena->query($sparql_query);


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
    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll">
        <form class="d-flex tm-search-form" id="search-form" method="POST" role="search" action="hasilcari.php">
            <input type="address" name="judul" class="form-control tm-search-input" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success tm-search-btn-outline-primary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-6 text-light">
                Latest Songs
            </h2>
        </div>
        <div class="row tm-mb-90 tm-gallery">
        <?php 
            foreach($result as $row){
                

                $detail = [
                    'no' => $row->no,
                    'image' =>$row->image,
                    'judul' => $row->title,
                    'artist' =>$row->artist,
                    'year' =>$row->year,
                ];
            ?>
        	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">

                    <img src="<?=$detail['image']?>" style="width:500px; height:275px;"  alt="Image" class="img-fluid">
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2><?=$detail['artist']?></h2>
                        <a href="hasilcari2.php?p=<?=$detail['no']?>">View more</a>
                    </figcaption>                    
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-gray-light"><?=$detail['judul']?></span>
                    <span><?=$detail['year']?></span>
                </div>
            </div>
            <?php } ?>       
       </div>
       
        </div> <!-- row -->
    </div> 
    
    <!-- container-fluid, tm-container-content -->
    <?php include 'footer.php'; ?>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>
<!-- 
//https://dbpedia.org/page/Birthday_(Beatles_song) -->