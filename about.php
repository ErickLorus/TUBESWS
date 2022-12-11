<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About LibSong</title>
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

    <div class="container-fluid tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-12 text-light">
                About LibSong
            </h2>
        </div>
        <div class="row tm-mb-74 tm-row-1640">            
            <div class="col-lg-5 col-md-6 col-12 mb-3">
                <img src="img/about.jpg" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-7 col-md-6 col-12">
                <div class="tm-about-img-text">
                    <p class="mb-4">
                  You may support TemplateMo website by making <a href="https://paypal.me/templatemo" target="_parent" rel="sponsored">a small contribution</a> via PayPal. This will be helpful for us. We hope you like this Catalog-Z photo / video template for your website. We are making new templates regularly for you. Please come back and visit our <a rel="sponsored" href="https://templatemo.com" target="_parent">TemplateMo website</a> again. </p>
                    <p>
                        Credits go to Pexels and Unsplash for photos and video used in this template. Catalog-Z is free <a rel="sponsored" href="https://v5.getbootstrap.com/">Bootstrap 5</a> Alpha 2 HTML Template designed for video and photo websites.</p> 
                    <p>You are <b>allowed</b> to use this template for your commercial or non-commercial websites. You can integrate it with any kind of CMS website. You are <b>NOT allowed</b> to redistribute the downloadable template ZIP file on any template collection website. Please <a rel="nofollow" href="https://templatemo.com/contact" target="_parent">contact us</a> for more information. Thank you.</p>
                </div>                
            </div>
        </div>

    <?php include 'footer.php'; ?>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>