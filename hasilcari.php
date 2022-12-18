
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
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>LibSong</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!--personal css-->
      <link rel="stylesheet" href="css/style2css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Righteous&display=swap" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      
      <!--font awesome-->
      <link rel="stylesheet" href="fontawesome/css/all.min.css">

   </head>
   <body>

   <?php include 'header.php'; ?>

      <!-- about section start -->
      <div class="about_section layout_padding">
         <div class="container">
            <h1 class="services_taital">Your Song</h1>
            <p class="services_text">Here's a more detailed information about the song you are searching about. It's accompanied with details like artist, year, duration, genre, duration, and you can also check out their music video on youtube.</p>
         </div>
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

         <div class="container-fluid" >
            <div class="row">
               <div class="col-md-6">
                  <div class="about_taital_main">
                     <h1 class="about_taital"><?=$detail['judul']?></h1>
                     <p class="about_text">
                     <div class="mr-4 mb-2">
                            <a href="hasilcari3.php?p=<?=$detail['artist']?>">
                                <span class="tm-text-gray-dark">Artist: </span><span class="tm-text-primary"><?=$detail['artist']?></span>
                            </a>
                            <br>
                            <br>
                                <span class="tm-text-gray-dark">Year: </span><span class="tm-text-primary"><?=$detail['year']?></span>
                            <br>
                            <br>
                              <span class="tm-text-gray-dark"><?=$detail['summary']?><a href="hasilcari2.php?p=<?=$detail['no']?>">.....Read More</a><br><br></span>
                            <div class="readmore_bt"><a href="video-detail.php?p=<?=$detail['no']?>">WATCH MV</a></div>
                        </div>
                  </div>
               </div>
               <div class="col-md-6 padding_right_0">
                  <div><img src="<?=$detail['image']?>"style="width:500px;" alt="Image" class="gmbr"></div>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>

      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="input_btn_main">
               <input type="text" class="mail_text" placeholder="Enter your email" name="Enter your email">
               <div class="subscribe_bt"><a href="#">Subscribe</a></div>
            </div>
            <div class="location_main">
               <div class="call_text"><img src="images/call-icon.png"></div>
               <div class="call_text"><a href="#">Call +61 812345678</a></div>
               <div class="call_text"><img src="images/mail-icon.png"></div>
               <div class="call_text"><a href="#">kelompok8@gmail.com</a></div>
            </div>
            <div class="social_icon">
               <ul>
                  <li><a href="#"><img src="images/fb-icon.png"></a></li>
                  <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                  <li><a href="#"><img src="images/linkedin-icon.png"></a></li>
                  <li><a href="#"><img src="images/instagram-icon.png"></a></li>
               </ul>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>    
   </body>
</html>