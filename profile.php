<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
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

// Retrieve the user's profile information
$currentUser = $_SESSION["username"];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate input
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match";
        }
    }

    // If no errors, update the user's profile
    if (empty($errors)) {
        $updateFields = [];
        $updateParams = [];

        if ($email !== $user["email"]) {
            $updateFields[] = "email = ?";
            $updateParams[] = $email;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "password = ?";
            $updateParams[] = $hashedPassword;
        }

        if (!empty($updateFields)) {
            $updateQuery = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE username = ?";
            $updateParams[] = $currentUser;

            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param(str_repeat("s", count($updateParams)), ...$updateParams);

            if ($stmt->execute()) {
                $success = "Profile updated successfully.";
            } else {
                $error = "Error updating profile: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $success = "No changes made to the profile.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zxx">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Profile - Cooking and Recipes</title>
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

        .styled-select {
        position: relative;
        display: inline-block;
    }

    .styled-select select {
        display: inline-block;
        padding: 8px 30px 8px 10px;
        margin: 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        font-size: 16px;
        line-height: 1.3;
        appearance: none; /* Remove default arrow on Chrome/Safari */
        -webkit-appearance: none; /* Remove default arrow on newer versions of Chrome/Safari */
        -moz-appearance: none; /* Remove default arrow on Firefox */
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="6" viewBox="0 0 12 6"><path fill="%23363b40" d="M6 5.8L0.2 0H11.8L6 5.8z"/></svg>'); /* Custom arrow */
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    /* Style the arrow icon */
    .styled-select select::-ms-expand {
        display: none; /* Remove default arrow on IE 11 */
    }

    /* Style the arrow icon for Firefox */
    @-moz-document url-prefix() {
        .styled-select select {
            padding-right: 30px; /* Adjust for the custom arrow */
        }
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
                    <a href="index.html">
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
            <li class="m_nav_item menu__item" id="moble_nav_item_1">
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
                <span>UPDATE</span> PROFILEP</h3>
            <div class="contact-right-w3l">
                <?php if (isset($success)) { ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <?php if (!empty($errors)) { ?>
            <ul class="error">
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="contact-input">
                        <input type="text" class="name" name="username" value="<?php echo $user["username"]; ?>" disabled>
                    </div>

                     <div class="contact-input">
                        <input type="text" class="name" name="user_role" value="<?php echo $user["user_role"]; ?>" disabled>
                    </div>

                    <div class="contact-input">
                        <input type="email" name="email" class="name" value="<?php echo $user["email"]; ?>" required="">
                    </div>

                    <div class="contact-input">
                        <input type="text" class="name" name="password" placeholder="New Password">
                    </div>

                    <div class="contact-input">
                        <input type="text" class="name" name="confirm_password" placeholder="Confirm New Password">
                    </div>
                        
                    <input type="submit" value="UPDATE PROFILE"> 
                   
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