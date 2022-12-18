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
\EasyRdf\RdfNamespace::set('artist', 'https://example.org/schema/artist');
\EasyRdf\RdfNamespace::setDefault('og');
$p = $_GET['p'];
$sparql_jena = new \EasyRdf\Sparql\Client('http://localhost:3030/data_musik/sparql');

$sparql_query = '
SELECT ?m ?title ?image ?name ?year ?genre ?hometown ?abstract ?link WHERE {
    ?m rdf:type artist:profile;
       rdfs:label ?title;
       artist:image ?image;
       artist:name ?name;
       artist:year ?year;
       artist:genre ?genre;
       artist:hometown ?hometown;
       artist:abstract ?abstract;
       foaf:maps ?link;
  FILTER(?title = "'.$p.'").
}LIMIT 1';
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

    <div class="container-fluid tm-container-content tm-mt-60">
            <div class="row tm-mb-70">     
                <?php 
                foreach($result as $row){
                    $text = substr($row->abstract, 0, 300);
                    $music_video = \EasyRdf\Graph::newAndLoad($row->link);

                    $detail = [
                      'm' => $row->m,
                      'title' => $row->title,
                      'image' =>$row->image,
                      'name' =>$row->name,
                      'genre' =>$row->genre,
                      'hometown'=>$row->hometown,
                      'year'=>$row->year,
                      'link'=>$row->link,
                      'abstract'=>$text,
                    ];
                ?>      
                <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                    <h1 class="col-12 text-light"><?=$detail['title']?></h1>
                    <br>
                    <img src="<?=$detail['image']?>" style="width:500px;" alt="Image" class="img-fluid">
                </div>
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <br><br><br>                 
                        <div class="mb-4 d-flex flex-wrap">
                            <div class="mr-4 mb-2">

                                <span class="tm-text-gray-dark">Artist: </span><span class="tm-text-primary"><?=$detail['name']?></span>

                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Start Year: </span><span class="tm-text-primary"><?=$detail['year']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Genre : </span><span class="tm-text-primary"><?=$detail['genre']?></span>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Hometown : </span><span class="tm-text-primary"><?=$detail['hometown']?></span>
                            <br>
                            <br>
                                <h3 class="tm-text-gray-dark mb-3">About</h3>
                                <span class="tm-text-gray-dark"><?=$detail['abstract']?><a href="<?=$detail['link']?>">....Find More</a></span>
                            </div>
                        </div>
                        <div class="mb-4">
                        
                        <iframe src="<?=$music_video ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                     
                </div>  
                <div class="row tm-mb-70">
            
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