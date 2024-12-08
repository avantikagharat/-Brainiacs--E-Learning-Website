<?php
session_start();
require 'connection.php';
$conn = Connect();
if (!isset($_SESSION['login_user2'])) {
    header("location: loggedin.php");
}
?>

<html>

<head>
    <title> Payment | Brainiacs </title>

</head>

<link rel="stylesheet" type="text/css" href="css/payment.css">
<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> !-->
<!--<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script> !-->

<body>


    <script type="text/javascript">
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Brainiacs</a>
            </div>

            <div class="collapse navbar-collapse " id="myNavbar">
                <ul class="nav navbar-nav">
                    <ul class="list-unstyled footer-links">
                        <li><a href="#home-section" class="nav-link">Home</a></li>
                        <li><a href="#courses-section" class="nav-link">Courses</a></li>
                        <li><a href="#programs-section" class="nav-link">Programs</a></li>
                        <li><a href="#teachers-section" class="nav-link">Teachers</a></li>
                    </ul>

                </ul>

                <?php
                if (isset($_SESSION['login_user1'])) {

                ?>

                <?php
                } else if (isset($_SESSION['login_user2'])) {
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
                        <li><a href="index.php"><span class="glyphicon glyphicon-cutlery"></span> Description </a></li>
                        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                                (<?php
                                    if (isset($_SESSION["cart"])) {
                                        $count = count($_SESSION["cart"]);
                                        echo "$count";
                                    } else
                                        echo "0";
                                    ?>)
                            </a></li>
                        <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
                    </ul>
                <?php
                } else {

                ?>


                    </ul>

                <?php
                }
                ?>
            </div>

        </div>
    </nav>

    <?php
    $gtotal = 0;
    foreach ($_SESSION["cart"] as $keys => $values) {

        $P_ID = $values["product_id"];
        $productname = $values["product_name"];
        $quantity = $values["product_quantity"];
        $price =  $values["product_price"];
        $total = ($values["product_quantity"] * $values["product_price"]);
        $R_ID = $values["R_ID"];
        $username = $_SESSION["login_user2"];
        $order_date = date('Y-m-d');

        $gtotal = $gtotal + $total;


        $query = "INSERT INTO ORDERS (P_ID, productname, price,  quantity, order_date, username, R_ID) 
              VALUES ('" . $F_ID . "','" . $productname . "','" . $price . "','" . $quantity . "','" . $order_date . "','" . $username . "','" . $R_ID . "')";


        $success = $conn->query($query);

        if (!$success) {
    ?>
            <div class="container">
                <div class="jumbotron">
                    <h1>Something went wrong!</h1>
                    <p>Try again later.</p>
                </div>
            </div>

    <?php
        }
    }

    ?>
    <div class="container">
        <div class="jumbotron">
            <h1>Choose your payment option</h1>
        </div>
    </div>
    <br>
    <h1 class="text-center">Grand Total: &#8377;<?php echo "$gtotal"; ?>/-</h1>
    <h5 class="text-center">including all service charges. (no delivery charges applied)</h5>
    <br>
    <h1 class="text-center">
        <a href="cart.php"><button class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span> Go back to cart</button></a>
        <a href="onlinepay.php"><button class="btn btn-success"><span class="glyphicon glyphicon-credit-card"></span> Pay Online</button></a>
        <a href="COD.php"><button class="btn btn-success"><span class="glyphicon glyphicon-"></span> Cash On Delivery</button></a>
    </h1>



    <br><br><br><br><br><br>
</body>

</html>