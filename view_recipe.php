<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chef";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the recipe ID is provided in the URL
if (isset($_GET["id"])) {
    $recipeId = $_GET["id"];

    // Retrieve the recipe from the database based on the provided ID
    $sql = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $recipe = $result->fetch_assoc();
    } else {
        die("Recipe not found.");
    }

    $stmt->close();
} else {
    die("Recipe ID not provided.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title><?php echo $recipe["title"]; ?> - Cooking and Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- numscroller -->
    <script type="text/javascript" src="js/numscroller-1.0.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- web-fonts -->
    <link href="http://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Mukta+Mahee:200,300,400,500,600,700,800" rel="stylesheet">
    <!-- //web-fonts -->

    <style>
        /* Your custom styles */
    .recipe-container {
        background-color: #f8f8f8;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .recipe-title {
        color: #333;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .recipe-description {
        color: #555;
        font-size: 18px;
        margin-bottom: 30px;
    }

    .recipe-details {
        margin-bottom: 30px;
    }

    .recipe-details h3 {
        color: #333;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .recipe-details p {
        color: #555;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .recipe-image {
        border-radius: 10px;
        overflow: hidden;
    }

    .recipe-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    </style>
</head>

<body>
    <!--banner-inner-->
    <div class="w3_agilits_banner_bootm">
        <!-- header -->
        <!---728x90--->

        <div class="container">
            <div class="w3_agile_logo">
                <h1>
                    <a href="index.php">
                        <img src="images/logo.png" alt=""  style="height: 100px; width: 100px;" /></a>
                </h1>
            </div>
            <div class="agileits_w3layouts_nav">
                <div id="toggle_m_nav">
                    <div id="m_nav_menu" class="m_nav">
                        <div class="m_nav_ham w3_agileits_ham" id="m_ham_1"></div>
                        <div class="m_nav_ham" id="m_ham_2"></div>
                        <div class="m_nav_ham" id="m_ham_3"></div>
                    </div>

                </div>
                <div id="m_nav_container" class="m_nav wthree_bg">
             <nav class="menu menu--sebastian">
    <ul id="m_nav_list" class="m_nav menu__list">
        <li class="m_nav_item menu__item menu__item--current" id="m_nav_item_1">
            <a href="index.php" class="menu__link">Home</a>
        </li>
        <?php if (isset($_SESSION["username"])) {
            // Check if the user role is "cook"
            if ($_SESSION["user_role"] == "cook") { ?>
                <li class="m_nav_item menu__item menu__item--current" id="m_nav_item_5">
                    <a href="add_recipe.php" class="menu__link">Add Recipe</a>
                </li>
            <?php } ?>
            <li class="m_nav_item menu__item" id="moble_nav_item_6">
                <a href="search.php" class="menu__link">SEARCH RECIPES</a>
            </li>
            <li class="m_nav_item menu__item" id="moble_nav_item_6">
                <a href="profile.php" class="menu__link">PROFILE</a>
            </li>
            <li class="m_nav_item menu__item" id="moble_nav_item_4">
                <a href="logout.php" class="menu__link">LOGOUT</a>
            </li>
        <?php } else { ?>
            <li class="m_nav_item menu__item" id="moble_nav_item_3">
                <a href="login.php" class="menu__link">LOGIN</a>
            </li>
            <li class="m_nav_item menu__item" id="moble_nav_item_2">
                <a href="signup.php" class="menu__link">SIGN UP</a>
            </li>
        <?php } ?>
    </ul>
</nav>

                </div>
            </div>
        </div>
        <!--// header -->

    </div>

<!-- About section -->
<div class="wthree-about section-w3ls">
    <div class="container">
        <div class="recipe-container">
            <h3 class="recipe-title"><?php echo $recipe["title"]; ?></h3>
            <p class="recipe-description"><?php echo $recipe["description"]; ?></p>

            <div class="row recipe-details">
                <div class="col-md-6">
                    <h3>Ingredients:</h3>
                    <ul>
                        <?php
                        $ingredients = explode("\n", $recipe["ingredients"]);
                        foreach ($ingredients as $ingredient) {
                            echo "<li>$ingredient</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Instructions:</h3>
                    <ul>
                        <?php
                        $instructions = explode("\n", $recipe["instructions"]);
                        foreach ($instructions as $instruction) {
                            echo "<li>$instruction</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="row recipe-image">
                <div class="col-md-6">
                    <img src="<?php echo $recipe["image_url"]; ?>" alt="<?php echo $recipe["title"]; ?>" class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //About section -->
  
    <!-- footer -->
    <div class="agile-footer w3ls-section">
        <div class="container">
            
            <div class="agileits_w3layouts-footer-bottom">
                <div class="w3_agile-footer-grids">
                
               
            <div class="agileits_w3layouts-copyright">
                <p>&copy; 2024 Cooking and Recipes. All rights reserved.</p>
            </div>
        </div>
    </div>
    <!-- //footer -->
    <!-- testimonials -->
    <!-- required-js-files-->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <script src="js/owl.carousel.js"></script>
    <script>
        $(document).ready(function () {
            $("#owl-demo").owlCarousel({
                items: 1,
                lazyLoad: true,
                autoPlay: false,
                navigation: true,
                navigationText: true,
                pagination: true,
            });
        });
    </script>
    <!--//required-js-files-->
    <!-- start-smooth-scrolling -->
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();

                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->

    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function () {
            /*
         var defaults = {
             containerID: 'toTop', // fading element id
             containerHoverID: 'toTopHover', // fading element hover id
             scrollSpeed: 1200,
             easingType: 'linear' 
         };
         */

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- navigation  -->
    <script src="js/main.js"></script>
    <!-- //navigation -->
</body>

</html>