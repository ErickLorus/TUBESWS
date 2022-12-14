
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
SELECT ?m ?title ?image ?artist ?year ?no ?summary WHERE {
    { ?m rdf:type music:song;
        rdfs:label ?title;
        music:image ?image;
        music:artist ?artist;
        music:year ?year;
        music:summary ?summary;
        music:number ?no.
         FILTER REGEX (?title, "'.($_POST['judul']).'", "i").
     } UNION {
         ?m rdf:type music:song;
         rdfs:label ?title;
         music:image ?image;
         music:artist ?artist;
         music:year ?year;
         music:summary ?summary;
         music:number ?no.
         FILTER REGEX (?artist, "'.($_POST['judul']).'", "i").
     }
} ';
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
    <?php 
            foreach($result as $row){
                $text = substr($row->summary, 0, 175);

                $detail = [
                    'no' => $row->no,
                    'image' =>$row->image,
                    'judul' => $row->title,
                    'artist' =>$row->artist,
                    'year' =>$row->year,
                    'summary' =>$text,
                ];
    ?> 
    <div class="container-fluid tm-container-content tm-mt-60">

            <div class="row tm-mb-90">           
                <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                    <h1 class="col-12 text-light"><?=$detail['judul']?></h1>
                    <br>
                    <img src="<?=$detail['image']?>" style="width:500px;" alt="Image" class="img-fluid">
                </div>
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <br><br><br>
                        <div class="text-center mb-5">
                        <form class="d-flex tm-search-form" id="search-form" method="POST" role="search" action="tes.php">
                            <!-- <a href="tes.php" type="address" name="judul" class="btn btn-primary tm-btn-big">Play Here</a> -->
                            <a href="video-detail.php?p=<?=$detail['no']?>" class="btn btn-primary tm-btn-big">Play MV</a>
                        </form>
                        </div>                    
                        <div class="mb-4 d-flex flex-wrap">
                            <div class="mr-4 mb-2">
                                <span class="tm-text-gray-dark">Artist: </span><span class="tm-text-primary"><?=$detail['artist']?></span>
                            </div>
                            <div class="mr-4 mb-2">
                                <span class="tm-text-gray-dark">Year: </span><span class="tm-text-primary"><?=$detail['year']?></span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="tm-text-gray-dark mb-3">About</h3>
                            <span class="tm-text-gray-dark"><?=$detail['summary']?><a href="hasilcari2.php?p=<?=$detail['no']?>">....Find More</a></span>
                        </div>
                    </div>
                </div>        
            </div> <!-- row -->
            
    </div> <!-- container-fluid, tm-container-content -->
    <?php } ?>
    <?php include 'footer.php'; ?>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>