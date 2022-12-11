
<?php
require 'vendor/autoload.php';

\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
\EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
\EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
\EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
\EasyRdf\RdfNamespace::set('dc', 'http://purl.org/dc/terms/');
\EasyRdf\RdfNamespace::set('hewan', 'https://example.org/schema/hewan');
\EasyRdf\RdfNamespace::setDefault('og');

$sparql_jena = new \EasyRdf\Sparql\Client('http://localhost:3030/hewan/sparql');

$sparql_query = '
SELECT ?m ?nama ?kelas ?deskripsi ?diet ?habitat ?id WHERE {
    ?m rdf:type hewan:novel;
       rdfs:label ?title;
       hewan:image ?image;
       hewan:deskripsi ?deskripsi;
       hewan:diet ?diet;
       hewan:id ?id;
       hewan:habitat ?habitat
  FILTER(?nama = "'.($_POST['judul']).'").
} ';
$result = $sparql_jena->query($sparql_query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
                   foreach($result as $row){
                                 

                    $detail = [
                      'id' => $row->id,
                      'kelas' =>$row->kelas,
                      'judul' => $row->nama,
                      'deskripsi' =>$row->deskripsi,
                      'diet' =>$row->diet,
                      'habitat' =>$row->habitat,
                    ];
                  ?>
                
                <h1><?=$detail['id']?></h1>
                <h1><?=$detail['kelas']?></h1>
                <h1><?=$detail['judul']?></h1>
                <h1><?=$detail['deskripsi']?></h1>
                <h1><?=$detail['dietl']?></h1>
                <h1><?=$detail['habitat']?></h1>

<?php } ?>
</body>
</html>