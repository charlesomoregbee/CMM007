<?php
session_start();

// Check if the user is logged in and has the cook role
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "cook") {
    header("Location: login.php");
    exit();
}

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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $ingredients = $_POST["ingredients"];
    $instructions = $_POST["instructions"];
    $imageUrl = "";

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $imageUrl = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imageUrl);
    }

    // Insert the recipe into the database
    $sql = "INSERT INTO recipes (title, description, ingredients, instructions, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $description, $ingredients, $instructions, $imageUrl);

    if ($stmt->execute()) {
        $success = "Recipe added successfully.";
    } else {
        $error = "Error adding recipe: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Add Recipe - Cooking and Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"/>
    <meta name="keywords" />
     <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- web-fonts -->
    <link href="http://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Mukta+Mahee:200,300,400,500,600,700,800" rel="stylesheet">
    <!-- //web-fonts -->
    <style>
    .error {
        padding: 10px;
        background-color: #f44336; /* Red background color */
        color: white; /* White text color */
        border-radius: 5px; /* Rounded corners */
        margin-bottom: 15px; /* Add some space below the error message */
    }

    .success {
        padding: 10px;
        background-color: #4CAF50; /* Green background color */
        color: white; /* White text color */
        border-radius: 5px; /* Rounded corners */
        margin-bottom: 15px; /* Add some space below the success message */
    }
</style>
</head>

<body>
    <!-- banner inner -->
    <!---728x90--->

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
        <li class="m_nav_item menu__item menu__item--current" id="m_nav_item_5">
            <a href="index.php" class="menu__link">Home</a>
        </li>
        <?php if (isset($_SESSION["username"])) {
            // Check if the user role is "cook"
            if ($_SESSION["user_role"] == "cook") { ?>
                <li class="m_nav_item menu__item menu__item--current" id="m_nav_item_1">
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
    
    <!-- contact -->
    <div class="contact-bottom section-w3ls main-pos" id="contact">
        <div class="container">
            <h3 class="w3ls-title">
                <span>ADD</span> RECIPES</h3>
            <div class="contact-right-w3l">
                <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                    <div class="contact-input">
                        <input type="text" class="name" name="title" placeholder="Title of Recipe" required="">
                    </div>

                    <div class="contact-input">
                        <textarea placeholder="Add a Brief Description" name="description" required=""></textarea>
                    </div>

                    <div class="contact-input">
                        <textarea placeholder="Ingredients" name="ingredients" required=""></textarea>
                    </div>

                   <div class="contact-input">
                        <textarea placeholder="Instructions" name="instructions" required=""></textarea>
                    </div>
                   
                  <label for="image">Image:</label>
            <input type="file" id="image" name="image">

                    <input type="submit" value="Add Recipe"> 
                    
                </form>
            </div>
            <div class="clearfix"></div>
       
        </div>
    </div>
   
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