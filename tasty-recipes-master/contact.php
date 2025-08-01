<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Recettes Délicieuses</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS here -->
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
</head>

<body>
    <!-- header-start -->
    <header>
        <div class="header-area">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-2"></div>
                        <div class="col-xl-6 col-lg-7">
                            <div class="main-menu white_text d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">Accueil</a></li>
                                        <li><a href="about.php">À propos</a></li>
                                        <li><a href="Recipes.php">Recettes</a></li>
                                        
                                        <li class="active"><a href="contact.php">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- bradcam_zone -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Nous Contacter</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /bradcam_zone -->

    <!-- Section de contact -->
    <?php
    // Connexion à la base de données
    include('db.php');  // Inclure le fichier de connexion


    

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['form_type']) && $_POST['form_type'] == 'contact_form') {
            // Traitement du formulaire de contact
            $name = isset($_POST['NOM']) ? trim($_POST['NOM']) : '';
            $prenom = isset($_POST['PRENOM']) ? trim($_POST['PRENOM']) : '';
            $date = isset($_POST['date_naissance']) ? trim($_POST['date_naissance']) : '';
            $email = isset($_POST['e_mail']) ? trim($_POST['e_mail']) : '';
            $profession = isset($_POST['profession']) ? trim($_POST['profession']) : '';
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';
            $sujet = isset($_POST['sujet']) ? trim($_POST['sujet']) : '';

            // Validation des champs
            if (empty($name)) {
                $errors['NOM'] = "Le nom est obligatoire.";
            }
            if (empty($prenom)) {
                $errors['PRENOM'] = "Le prénom est obligatoire.";
            }
            if (empty($date)) {
                $errors['date_naissance'] = "La date de naissance est obligatoire.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['e_mail'] = "Une adresse électronique valide est obligatoire.";
            }
            if (empty($profession)) {
                $errors['profession'] = "La profession est obligatoire.";
            }
            if (empty($sujet)) {
                $errors['sujet'] = "Le sujet est obligatoire.";
            }
            if (empty($message)) {
                $errors['message'] = "Le message est obligatoire.";
            }

            if (empty($errors)) {
                try {
                    $conn->beginTransaction();
                    $stmt = $conn->prepare("INSERT INTO UTILISATEURS (NOM, PRENOM, date_naissance, e_mail, profession) VALUES (:NOM, :PRENOM, :date_naissance, :e_mail, :profession)");
                    $stmt->execute([
                        ':NOM' => $name,
                        ':PRENOM' => $prenom,
                        ':date_naissance' => $date,
                        ':e_mail' => $email,
                        ':profession' => $profession
                    ]);

                    $id_utilisateur = $conn->lastInsertId();

                    $stmt = $conn->prepare("INSERT INTO MESSAGE (objet, message, id_utilisateur) VALUES (:objet, :message, :id_utilisateur)");
                    $stmt->execute([
                        ':objet' => $sujet,
                        ':message' => $message,
                        ':id_utilisateur' => $id_utilisateur
                    ]);

                    $conn->commit();
                    $_POST = [];
                    echo "<p class='text-success'>Formulaire soumis avec succès !</p>";
                } catch (PDOException $e) {
                    $conn->rollBack();
                    echo "<p class='text-danger'>Erreur lors de l'insertion : " . $e->getMessage() . "</p>";
                }
            }
        } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'newsletter_form') {
            // Traitement du formulaire de la newsletter
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='text-danger'>Adresse email invalide.</p>";
            } else {
                try {
                    $stmt = $conn->prepare("SELECT * FROM news_letters WHERE e_mail_new = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        echo "<p class='text-danger'>Cet e-mail est déjà enregistré.</p>";
                    } else {
                        $stmt = $conn->prepare("INSERT INTO news_letters (e_mail_new) VALUES (:email)");
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();
                        echo "<p class='text-success'>Merci de vous être abonné à notre newsletter !</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-danger'>Erreur lors de l'abonnement : " . $e->getMessage() . "</p>";
                }
            }
        }
    }

    ?>
    <section class="contact-section section_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Prendre contact avec nous</h2>
                </div>

                <!-- Formulaire combiné -->
                <div class="container mt-5">
                    <h2>Formulaire combiné</h2>
                    <?php
                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger'><ul>";
                        foreach ($errors as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul></div>";
                    }
                    ?>

                    <form action="" method="POST">
                    <input type="hidden" name="form_type" value="contact_form">

                        <h3>Informations utilisateur</h3>
                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="NOM" id="NOM" type="text" placeholder="Nom"
                                           value="<?= htmlspecialchars(isset($_POST['NOM']) ? $_POST['NOM'] : '') ?>" required>
                                    <?php if (isset($errors['NOM'])): ?>
                                        <span class="text-danger"><?= htmlspecialchars($errors['NOM']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="PRENOM" id="PRENOM" type="text" placeholder="Prénom"
                                           value="<?= htmlspecialchars(isset($_POST['PRENOM']) ? $_POST['PRENOM'] : '') ?>" required>
                                    <?php if (isset($errors['PRENOM'])): ?>
                                        <span class="text-danger"><?= htmlspecialchars($errors['PRENOM']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="date_naissance" id="date_naissance" type="date"
                                           value="<?= htmlspecialchars(isset($_POST['date_naissance']) ? $_POST['date_naissance'] : '') ?>" required>
                                    <?php if (isset($errors['date_naissance'])): ?>
                                        <span class="text-danger"><?= htmlspecialchars($errors['date_naissance']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="e_mail" id="e_mail" type="email" placeholder="Email"
                                           value="<?= htmlspecialchars(isset($_POST['e_mail']) ? $_POST['e_mail'] : '') ?>" required>
                                    <?php if (isset($errors['e_mail'])): ?>
                                        <span class="text-danger"><?= htmlspecialchars($errors['e_mail']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Profession</label><br>
                                    <input type="radio" name="profession" value="Professeur" <?= (isset($_POST['profession']) && $_POST['profession'] === 'Professeur') ? 'checked' : '' ?> required> Professeur
                                    <input type="radio" name="profession" value="Etudiant" <?= (isset($_POST['profession']) && $_POST['profession'] === 'Etudiant') ? 'checked' : '' ?> required> Étudiant
                                    <input type="radio" name="profession" value="Autre" <?= (isset($_POST['profession']) && $_POST['profession'] === 'Autre') ? 'checked' : '' ?> required> Autre
                                    <?php if (isset($errors['profession'])): ?>
                                        <span class="text-danger"><?= htmlspecialchars($errors['profession']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <h3>Formulaire de contact</h3>
                        <div class="form-group">
                            <input class="form-control" name="sujet" id="sujet" type="text" placeholder="Sujet"
                                   value="<?= htmlspecialchars(isset($_POST['sujet']) ? $_POST['sujet'] : '') ?>" required>
                            <?php if (isset($errors['sujet'])): ?>
                                <span class="text-danger"><?= htmlspecialchars($errors['sujet']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required><?= htmlspecialchars(isset($_POST['message']) ? $_POST['message'] : '') ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <span class="text-danger"><?= htmlspecialchars($errors['message']); ?></span>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Marjane 2, Meknès, Maroc</h3>
                            <p>B.P. 15290 Al-Mansour</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>+212 625-508821</h3>
                            <p>Ouvert du lundi au vendredi 9h à 18h</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>recettes_de_cuisine@gmail.com</h3>
                            <p>Envoyez-nous votre demande à tout moment !</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="d-none d-sm-block mb-5 pb-4">
        <h2 class="contact-title">Nous sommes situés dans les locaux de l'ENSAM Meknès</h2>
        <div id="map" style="height: 480px;">
            <iframe style="height: 480px; width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3183.7917676709867!2d-5.5742398244481715!3d33.85837027323051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda05aaf634bac87%3A0x64bfe117d2e27d7d!2sEcole%20Nationale%20Sup%C3%A9rieure%20des%20Arts%20et%20M%C3%A9tiers!5e1!3m2!1sfr!2sma!4v1734785337391!5m2!1sfr!2sma" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- footer -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">Trouver le nécessaire</h3>
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
                            <h3 class="footer_title">Entreprise</h3>
                            <ul>
                                <li><a href="contact.php">Aide</a></li>
                                <li><a href="about.php">À propos de nous</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <h3 class="footer_title">S'abonner</h3>
                            <p class="newsletter_text">Vous pouvez nous faire confiance. Nous envoyons uniquement des offres promotionnelles.</p>
                            <?php
                            // Gestion du formulaire de newsletter
                            // Gestion du formulaire de newsletter
include('db.php');  // Inclure le fichier de connexion

$conn = new mysqli($host, $username, $password, $dbname);  // Utiliser $host au lieu de $servername

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$message = "";


                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] == 'newsletter_form') {
                                $email = $conn->real_escape_string($_POST['email']);
                            
                                // Validation stricte de l'email
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $message = "Adresse email invalide. Veuillez entrer une adresse correcte.";
                                } else {
                                    $sql_check = "SELECT * FROM news_letters WHERE e_mail_new = '$email'";
                                    $result = $conn->query($sql_check);
                            
                                    if ($result->num_rows > 0) {
                                        $message = "Cet e-mail est déjà enregistré.";
                                    } else {
                                        $stmt = $conn->prepare("INSERT INTO news_letters (e_mail_new) VALUES (:email)");
$stmt->execute([':email' => $email]);

                                        if ($conn->query($sql) === TRUE) {
                                            $message = "Merci de vous être abonné à notre newsletter !";
                                        } else {
                                            $message = "Erreur : " . $conn->error;
                                        }
                                    }
                                }
                            }
                            

                            $conn->close();
                            ?>

                            <form action="" method="POST" class="newsletter_form">
                            <input type="hidden" name="form_type" value="newsletter_form">

                                <input type="email" name="email" placeholder="Entrez votre email" required>
                                <button type="submit"><i class="ti-arrow-right"></i></button>
                            </form>

                            <?php if (!empty($message)) : ?>
                                <p style="color: green; font-size: 14px; margin-top: 10px;"> <?= htmlspecialchars($message); ?> </p>
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
                        <p class="copy_right">Copyright &copy; <script>document.write(new Date().getFullYear());</script> Tous droits réservés.</p>
                    </div>
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
    </footer>
    <!-- JS here -->
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

    <!-- Contact js -->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="js/main.js"></script>
</body>

</html>
