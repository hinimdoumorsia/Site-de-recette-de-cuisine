<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Recettes Savoureuses</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <!-- Placez favicon.ico dans le répertoire racine -->

    <!-- CSS ici -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">Vous utilisez un navigateur <strong>obsolète</strong>. Veuillez <a href="https://browsehappy.com/">mettre à jour votre navigateur</a> pour améliorer votre expérience et votre sécurité.</p>
        <![endif]-->

    <!-- header-start -->

    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area ">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2">
                        </div>
                        <div class="col-xl-6 col-lg-7">
                            <div class="main-menu white_text  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">Accueil</a></li>
                                        <li><a href="about.php">À propos</a></li>
                                        <li><a href="Recipes.php">Recettes</a></li>
                                         
                                         <li><a href="contact.php">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                            <div class="search_icon">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </header>
    
   <!-- header-end -->

<!-- bradcam_area  -->

<div class="bradcam_area bradcam_bg_1">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bradcam_text text-center">
                    <h3>Détails de la recette</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /bradcam_area  -->

<!-- recettes  -->

<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = $conn->prepare("SELECT * FROM RECETTES WHERE id_recettes = ?");
$query->execute([$id]);
$recipe = $query->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    echo "Recette introuvable.";
    exit();
}
?>

<div class="recepie_details_area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-md-6">
                <div class="recepies_thumb">
                <img src="img/recepie/recpie_<?php echo $recipe['id_recettes']; ?>.png" alt="">
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="recepies_info">
                <h3><?php echo htmlspecialchars($recipe['title_recettes']); ?></h3>

                    <div class="resepies_details">
                        <ul>
                            <li><p><strong>Note</strong> : <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> </p></li>
                            <li><p><strong>Catégorie</strong> : Plat principal </p></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="recepies_text">
                    <h3> Pour cette recette vous avez besoins de : </h3>
                    <p><strong>Ingrédients :</strong> <?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
                    <h3> Quantité requise pour chaque ingredient  </h3>
                    <p><strong>Quantités :</strong> <?php echo nl2br(htmlspecialchars($recipe['ingredients_quantity'])); ?></p>
                    <h3> Etapes de la recette  </h3>
                    <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
                
                </div>
            </div>
        </div>
    </div>
</div>


<!-- recettes  -->
<div class="recepie_area inc_padding">

    <div class="container">
        <h3 >Recommandation </h3>
        <div class="row">

        <?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $query = $conn->prepare("SELECT * FROM RECETTES WHERE title_recettes LIKE ?");
    $query->execute(["%$search%"]);
} else {
    $query = $conn->query("SELECT * FROM RECETTES LIMIT 3");
}
$recipes = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="recepie_area plus_padding">
    <div class="container">
        <div class="row">
            <?php foreach ($recipes as $recipe): ?>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="single_recepie text-center">
                    <div class="recepie_thumb">
                        <img src="img/recepie/recpie_<?php echo $recipe['id_recettes']; ?>.png" alt="">
                    </div>
                    <h3><?php echo htmlspecialchars($recipe['title_recettes']); ?></h3>
                    
                    <a href="recipes_details.php?id=<?php echo $recipe['id_recettes']; ?>" class="line_btn">Voir la recette complète</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


    </div>
        </div>
    </div>
</div>

   <!-- /recettes  -->
 <!-- footer  -->
<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Trouver le necessaire
                        </h3>
                        <ul>
                                <li><a href="https://www.marjane.ma/search/l%C3%A9gumes">Produits frais à votre portée</a></li>
                                <li><a href="https://www.marjanemall.ma/maison-cuisine-deco/cuisine/ustensiles-de-cuisine">Ustensiles de cuisine</a></li>
                                <li><a href="https://www.marjanemall.ma/electromenager/cuisine-et-cuisson">Robots de cuisine</a></li>
                                <li><a href="https://mariage-marocain.com/traiteur-au-maroc/">Service traiteur</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">Pour vous par nous</h3>
                            <ul>
                                <li><a href="https://olms.ofppt.ma/course/index.php?categoryid=1802">Cours de cuisine</a></li>
                                <li><a href="https://www.nike.com/fr/ntc-app?msockid=1cc7e23768ea661b0ab1f00c69986707">Sport</a></li>
                                <li><a href="https://www.nu3.fr/blogs/slimming/aliments-pour-maigrir">Conseils minceur</a></li>
                            </ul>

                    </div>
                </div>
                <div class="col-xl-2 col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Entreprise
                        </h3>
                        <ul>
                            <li><a href="contact.html">Help</a></li>
                            <li><a href="about.php">A props de nous</a></li>

                        </ul>

                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                <div class="footer_widget">
    <h3 class="footer_title">
        S'abonner
    </h3>
    <p class="newsletter_text">
        Vous pouvez nous faire confiance. Nous envoyons uniquement des offres promotionnelles.
    </p>
    <?php
    // Connexion à la base de données
    include('db.php');

    // Création de la connexion
    $conn = new mysqli($host, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Message à afficher
    $message = "";

    // Gestion du formulaire lorsqu'il est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string($_POST['email']);

        // Vérifier si l'email est déjà enregistré
        $sql_check = "SELECT * FROM news_letters WHERE e_mail_new = '$email'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            $message = "Cet e-mail est déjà enregistré.";
        } else {
            // Insérer l'email dans la base de données
            $sql = "INSERT INTO news_letters (e_mail_new) VALUES ('$email')";
            if ($conn->query($sql) === TRUE) {
                $message = "Merci de vous être abonné à notre newsletter !";
            } else {
                $message = "Erreur : " . $conn->error;
            }
        }
    }

    // Fermeture de la connexion
    $conn->close();
    ?>

    <form action="" method="POST" class="newsletter_form">
        <input type="email" name="email" placeholder="Entrez votre email" required>
        <button type="submit"> <i class="ti-arrow-right"></i> </button>
    </form>
    
    <?php if (!empty($message)) : ?>
        <p style="color: green; font-size: 14px; margin-top: 10px;"><?php echo $message; ?></p>
    <?php endif; ?>
</div>

                </div>
                
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="footer_border"></div>
            <div class="row align-items-center">
                <div class="col-xl-8 col-md-8">
                    <p class="copy_right">
                         
                    Copyright &copy;
                    <script>document.write(new Date().getFullYear());

                    </script> 
                    Tous droits réservés | Ce modèle est créé avec 
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                    par ces proprietaires
                                            
                    </p>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="socail_links">
                        
                            
<ul>
                            <li>
                                <a href="https://www.facebook.com/share/ursA46xK4kjB7zM6/?mibextid=wwXIfr">
                                    <i class="ti-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/212612345678">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/212625508821">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/ footer  -->
    <!--/ footer  -->

<!-- JS ici -->
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/ajax-form.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/scrollIt.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/nice-select.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/gijgo.min.js"></script>

<!-- JS de contact -->
<script src="js/contact.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/mail-script.js"></script>

<script src="js/main.js"></script>
</body>

</html>
