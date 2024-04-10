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

// Retrieve recipes from the database
$sql = "SELECT * FROM recipes";
$result = $conn->query($sql);

// Handle search functionality
$search = isset($_GET["search"]) ? $_GET["search"] : "";

// Modify the recipe retrieval query to include the search condition
$sql = "SELECT * FROM recipes";
if (!empty($search)) {
    $sql .= " WHERE title LIKE ? OR description LIKE ?";
    $searchPattern = "%" . $search . "%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $searchPattern, $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Home - Cooking and Recipes</title>
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
    <!-- banner slider -->
    <link rel="stylesheet" type="text/css" href="css/zoomslider.css" />
    <!--gallery -->
    <link type="text/css" rel="stylesheet" href="css/cm-overlay.css" />
    <!-- //gallery -->
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
    .no-recipes {
        text-align: center;
        margin-top: 20px;
        color: #555;
        font-size: 18px;
    }

    .add-recipe-link {
        color: #007bff;
        text-decoration: underline;
    }
     .img-responsive {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto; /* Center the image horizontally */
    }
     .recipe-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s ease-in-out;
    }

    .recipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .recipe-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .recipe-card figcaption {
        padding: 20px;
        background-color: #f9f9f9;
    }

    .recipe-card h4 {
        margin-top: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .recipe-card p {
        margin-bottom: 0;
        color: #555;
    }
</style>
</head>

<body>

    <div class="w3_agilits_banner_bootm">
        <!-- header -->
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
    <!--//banner-bottom-->
    <!---728x90--->

    <!--/banner-section-->
    <div id="demo-1" data-zs-src='["images/banner1.jpg","images/banner2.jpg","images/banner3.jpg","images/banner4.jpg","images/banner5.jpg"]' data-zs-overlay="dots">
        <div class="demo-inner-content">

            <!--/banner-info-->
            <div class="baner-info">
                <h4>The best Recipes for your healthy living </h4>
                <h3>
                    soothing meals </h3>
                <p>This platform serves only the best recipes from all over the world</p>
                <a class="hvr-rectangle-out w3_play_icon1" href="#">Add Recipe</a>
            </div>
            <!--/banner-ingo-->
        </div>
    </div>
    <!--/banner-section-->


   
    <!-- menu -->
    <?php if ($result->num_rows > 0) { ?>
    <div class="w3ls-services section-w3ls">
        <div class="container">
            <h3 class="w3ls-title">
                <span>R</span>ECIPES</h3>
            <div class="grid">
                <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4 col-xs-6 w3l-service-hover">
                     <div class="recipe-card">
                   <a href="view_recipe.php?id=<?php echo $row["id"]; ?>"> <img src="<?php echo $row["image_url"]; ?>" alt="<?php echo $row["title"]; ?>" class="img-responsive" />  </a>
                    <figcaption>
                        <h4><?php echo $row["title"]; ?></h4>
                        <?php
                            // Get the description and split it into words
                            $words = explode(' ', $row["description"]);
                            // Limit the description to 20 words
                            $limited_description = implode(' ', array_slice($words, 0, 7));
                            // Add "..." if the description exceeds 20 words
                            if (count($words) > 10) {
                                $limited_description .= '...';
                            }
                            ?>
                            <p><?php echo $limited_description; ?></p>
                    </figcaption>
                </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- //menu -->
     <?php } else { ?>

           <div class="no-recipes">
    <p>No recipes found. <a href="add_recipe.php" class="add-recipe-link">Add Recipe</a></p>
</div>
        <?php } ?>
    



    <!-- footer -->
    <div class="agile-footer w3ls-section">
        <div class="container">
            
            <div class="agileits_w3layouts-copyright">
                <p>&copy; 2024 Cooking and Recipes. All rights reserved.</p>
            </div>
        </div>
    </div>
    <!-- //footer -->
    <!-- banner slider -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <script src="js/jquery.zoomslider.min.js"></script>
    <!-- //banner slider -->
    <!-- //gallery -->
    <script src="js/jquery.tools.min.js"></script>
    <script src="js/jquery.mobile.custom.min.js"></script>
    <script src="js/jquery.cm-overlay.js"></script>

    <script>
        $(document).ready(function () {
            $('.cm-overlay').cmOverlay();
        });
    </script>
    <!-- //gallery -->
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