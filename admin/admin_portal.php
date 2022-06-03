<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<?php
include_once("../php_scripts/_initialize.php");

// if the user is not signed in, he/she cannot access this page
if (!isset($_SESSION['User_Id'])) {
    ?>
    <script> window.location = "../"; </script>
    <?php
    die();
}
$user_id = $_SESSION['User_Id'];
$username = $_SESSION['Username'];
$rank = $_SESSION['Rank'];
if ($rank == "Administrator") {
    $station_id = "Administrator";
} else {
    $station_id = $_SESSION['Station_Id'];
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gas Top-up &mdash; Admin portal. </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Know where petroleum products are available and cheaper."/>
    <meta name="keywords" content="Fuel, Kerosene, Gas, Diesel, product"/>
    <meta name="author" content="LOVE"/>

    <script src="../core_files/js/jquery/jquery-3.2.1.js"></script>
    <!-- Main JS -->
    <script src="../core_files/js/my_own/main_site.js"></script>


    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Animate.css -->
    <link rel="stylesheet" href="../core_files/css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="../core_files/css/icomoon.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="../core_files/css/bootstrap.css">
    <!-- Superfish -->
    <link rel="stylesheet" href="../core_files/css/superfish.css">
    <link rel="stylesheet" href="../core_files/css/style.css">


    <!-- Modernizr JS -->
    <script src="../core_files/js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 text-left fh5co-link">
                <a href="#">FAQ</a>
                <a href="#">Forum</a>
                <a href="#">Contact</a>
            </div>
            <div class="col-md-6 col-sm-6 text-right fh5co-social">
                <a href="#" class="grow"><i class="icon-user">
                    </i>
                    Welcome <b style="text-transform: capitalize;"><?php echo $username; ?>!
                        (<?php echo station_id_to_station_name($station_id, $conn); ?>)</b>
                </a>

                <a href="../php_scripts/logout.php" class="grow"><i class="icon-large icon-exit"></i></a>
            </div>
        </div>
    </div>
</div>
<header id="fh5co-header-section" class="sticky-banner">
    <div class="container">
        <div class="nav-header">
            <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark"><i></i></a>

            <h1 id="fh5co-logo"><a href="../"><img src="../img/main/gastopup_logo.png"
                                                   style="width: 60px; height: 60px;" alt="GSL logo"/> Gas Top-up</a>
            </h1>
            <!-- START #fh5co-menu-wrap -->


            <nav id="fh5co-menu-wrap" role="navigation">
                <ul class="sf-menu" id="fh5co-primary-menu">
                    <li><a href="../">Home</a></li>
                    <li><a href="../products/">Products</a></li>
                    <li><a href="../stations/">Gas Stations</a></li>
                    <li><a href="../contact/">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="container">
    <div class="our-services">
        <?php
        if (isset($station_id) && ($station_id != "Administrator")) {

            $station_name = mysqli_real_escape_string($conn, $station_id);

            $query = mysqli_query($conn, "SELECT * FROM gas_stations WHERE Station_Id='$station_name'") or mysql_error();
            $count_stations = mysqli_num_rows($query);
            if ($count_stations > 0) {
                $this_row = mysqli_fetch_array($query);

                $station_id = $this_row['Station_Id'];
                $station_name = $this_row['Station_Name'];
                $station_address = $this_row['Station_Address'];
                $station_phone = $this_row['Station_Phone'];
                $station_email = $this_row['Station_Email'];
                $station_website = $this_row['Station_Website'];
                $station_description = $this_row['Short_Description'];

                echo "<br />";
                echo "<br />";
                ?>

                <div class="">
                    <div style="float: left;">
                        <?php
                        if (trim(station_image($station_id, $conn)) != "no_image") {
                            ?>
                            <img class="box-shadow-light img img-thumbnail img-responsive col-xs-12"
                                 src="<?php echo station_image($station_id, $conn); ?>"
                                 style="max-width: 700px; max-height: 400px; border-radius: 8px;" alt=""/>
                            <?php
                        } else {
                            ?>
                            <img class="box-shadow-light img img-thumbnail img-responsive col-xs-12"
                                 src="../img/gas_station_images/general_station.jpg"
                                 style="max-width: 700px; max-height: 400px; border-radius: 8px;" alt=""/>
                            <?php
                        } ?>
                    </div>
                    <div class="col-md-4 border-left-fuel box-shadow-light radius_box"
                         style="padding:20px; float: left; min-height: 400px;">
                        <h3 class=""><b> <?php echo $station_name; ?></b></h3>

                        <div class="single-element-style"><i
                                class="icon-map-marker"></i> <?php echo $station_address; ?></div>
                        <div class="single-element-style"><i class="icon-phone"></i> <?php echo $station_phone; ?></div>
                        <div class="single-element-style"><i class="icon-envelope"></i> <?php echo $station_email; ?>
                        </div>
                        <hr class="hr-fuel"/>

                        <div class="well single-element-style"><i
                                class="icon-globe2"></i> <?php echo $station_website; ?></div>

                    </div>

                    <div class="" style="padding:20px; float: left;">
                        <h4 class=""> Products / Prices</h4>
                        <table class="table table-responsive table-hover">
                            <form method="post" action="javascript:void(0);">
                                <tr>
                                    <td>
                                        <input type="button" value="Change status" class="btn btn-info"
                                               onclick="update_product_status('fuel', 'fuel_status_checkbox', '<?php echo $station_id; ?>');"/>
                                    </td>
                                    <td> FUEL
                                    </td>
                                    <td>
                                        <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('fuel', $conn), $conn)) != "unavailable") {
                                            echo 'class="alert alert-success"';
                                        } else {
                                            echo 'class="alert alert-danger"';
                                        } ?> type="text"
                                             value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('fuel', $conn), $conn); ?>"
                                             id="fuel_price_input"/>
                                    </td>
                                    <td>
                                        <input
                                            onclick="update_fuel_price('<?php echo 'fuel'; ?>', '<?php echo 'fuel_price_input'; ?>', '<?php echo $station_id; ?>')"
                                            class="btn btn-primary well" type="button" value="update"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="button" value="Change status" class="btn btn-info"
                                               onclick="update_product_status('kerosene', 'kerosene_status_checkbox', '<?php echo $station_id; ?>');"/>
                                    </td>
                                    <td> KEROSENE
                                    </td>
                                    <td>
                                        <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('kerosene', $conn), $conn)) != "unavailable") {
                                            echo 'class="alert alert-success"';
                                        } else {
                                            echo 'class="alert alert-danger"';
                                        } ?> type="text"
                                             value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('kerosene', $conn), $conn); ?>"
                                             id="kerosene_price_input"/>
                                    </td>
                                    <td>
                                        <input
                                            onclick="update_fuel_price('<?php echo 'kerosene'; ?>', '<?php echo 'kerosene_price_input'; ?>', '<?php echo $station_id; ?>')"
                                            class="btn btn-primary well" type="button" value="update"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="button" value="Change status" class="btn btn-info"
                                               onclick="update_product_status('diesel', 'diesel_status_checkbox', '<?php echo $station_id; ?>');"/>
                                    </td>
                                    <td> DIESEL
                                    </td>
                                    <td>
                                        <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('diesel', $conn), $conn)) != "unavailable") {
                                            echo 'class="alert alert-success"';
                                        } else {
                                            echo 'class="alert alert-danger"';
                                        } ?> type="text"
                                             value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('diesel', $conn), $conn); ?>"
                                             id="diesel_price_input"/>
                                    </td>
                                    <td>
                                        <input
                                            onclick="update_fuel_price('<?php echo 'diesel'; ?>', '<?php echo 'diesel_price_input'; ?>', '<?php echo $station_id; ?>')"
                                            class="btn btn-primary well" type="button" value="update"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="button" value="Change status" class="btn btn-info"
                                               onclick="update_product_status('gas', 'gas_status_checkbox', '<?php echo $station_id; ?>');"/>
                                    </td>
                                    <td> COOKING GAS
                                    </td>
                                    <td>
                                        <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('gas', $conn), $conn)) != "unavailable") {
                                            echo 'class="alert alert-success"';
                                        } else {
                                            echo 'class="alert alert-danger"';
                                        } ?> type="text"
                                             value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('gas', $conn), $conn); ?>"
                                             id="gas_price_input"/>
                                    </td>
                                    <td>
                                        <input
                                            onclick="update_fuel_price('<?php echo 'gas'; ?>', '<?php echo 'gas_price_input'; ?>', '<?php echo $station_id; ?>')"
                                            class="btn btn-primary well" type="button" value="update"/>
                                    </td>
                                </tr>
                    </div>

                    </form>
                    </table>
                    <div class="col-md-8" style="padding:20px;">
                        <h4>Short description </h4>

                        <p style="text-align:justify;"> <?php echo $station_description; ?></p>
                    </div>
                </div>
                <div style="clear:both;"></div>

                <?php

            }
            ?>

        <?php } elseif (isset($station_id) && ($station_id == "Administrator")) {

            $query = mysqli_query($conn, "SELECT * FROM gas_stations") or mysql_error();
            $count_stations = mysqli_num_rows($query);
            if ($count_stations > 0) {
                while ($this_row = mysqli_fetch_array($query)) {

                    $station_id = $this_row['Station_Id'];
                    $station_name = $this_row['Station_Name'];
                    $station_address = $this_row['Station_Address'];
                    $station_phone = $this_row['Station_Phone'];
                    $station_email = $this_row['Station_Email'];
                    $station_website = $this_row['Station_Website'];
                    $station_description = $this_row['Short_Description'];

                    echo "<br />";
                    echo "<br />";
                    ?>

                    <div class="">
                        <div style="float: left;">
                            <?php
                            if (trim(station_image($station_id, $conn)) != "no_image") {
                                ?>
                                <img class="box-shadow-light img img-thumbnail img-responsive col-xs-12"
                                     src="<?php echo station_image($station_id, $conn); ?>"
                                     style="max-width: 700px; max-height: 400px; border-radius: 8px;" alt=""/>
                                <?php
                            } else {
                                ?>
                                <img class="box-shadow-light img img-thumbnail img-responsive col-xs-12"
                                     src="../img/gas_station_images/general_station.jpg"
                                     style="max-width: 700px; max-height: 400px; border-radius: 8px;" alt=""/>
                                <?php
                            } ?>
                        </div>
                        <div class="col-md-4 border-left-fuel box-shadow-light radius_box"
                             style="padding:20px; float: left; min-height: 400px;">
                            <h3 class=""><b> <?php echo $station_name; ?></b></h3>

                            <div class="single-element-style"><i
                                    class="icon-map-marker"></i> <?php echo $station_address; ?></div>
                            <div class="single-element-style"><i class="icon-phone"></i> <?php echo $station_phone; ?>
                            </div>
                            <div class="single-element-style"><i
                                    class="icon-envelope"></i> <?php echo $station_email; ?></div>
                            <hr class="hr-fuel"/>

                            <div class="well single-element-style"><i
                                    class="icon-globe2"></i> <?php echo $station_website; ?></div>

                        </div>

                        <div class="" style="padding:20px; float: left;">
                            <h4 class=""> Products / Prices</h4>
                            <table>
                                <form method="post" action="javascript:void(0);">
                                    <tr>
                                        <td>
                                            <input type="button" value="Change status" class="btn btn-info"
                                                   onclick="update_product_status('fuel', 'fuel_status_checkbox', '<?php echo $station_id; ?>');"/>
                                        </td>
                                        <td> FUEL
                                        </td>
                                        <td>
                                            <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('fuel', $conn), $conn)) != "unavailable") {
                                                echo 'class="alert alert-success"';
                                            } else {
                                                echo 'class="alert alert-danger"';
                                            } ?> type="text"
                                                 value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('fuel', $conn), $conn); ?>"
                                                 id="fuel_price_input<?php echo $station_id; ?>"/>
                                        </td>
                                        <td>
                                            <input
                                                onclick="update_fuel_price('<?php echo 'fuel'; ?>', 'fuel_price_input<?php echo $station_id; ?>', '<?php echo $station_id; ?>')"
                                                class="btn btn-primary well" type="button" value="update"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="button" value="Change status" class="btn btn-info"
                                                   onclick="update_product_status('kerosene', 'kerosene_status_checkbox', '<?php echo $station_id; ?>');"/>
                                        </td>
                                        <td> KEROSENE
                                        </td>
                                        <td>
                                            <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('kerosene', $conn), $conn)) != "unavailable") {
                                                echo 'class="alert alert-success"';
                                            } else {
                                                echo 'class="alert alert-danger"';
                                            } ?> type="text"
                                                 value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('kerosene', $conn), $conn); ?>"
                                                 id="kerosene_price_input<?php echo $station_id; ?>"/>
                                        </td>
                                        <td>
                                            <input
                                                onclick="update_fuel_price('<?php echo 'kerosene'; ?>', 'kerosene_price_input<?php echo $station_id; ?>', '<?php echo $station_id; ?>')"
                                                class="btn btn-primary well" type="button" value="update"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="button" value="Change status" class="btn btn-info"
                                                   onclick="update_product_status('diesel', 'diesel_status_checkbox', '<?php echo $station_id; ?>');"/>
                                        </td>
                                        <td> DIESEL
                                        </td>
                                        <td>
                                            <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('diesel', $conn), $conn)) != "unavailable") {
                                                echo 'class="alert alert-success"';
                                            } else {
                                                echo 'class="alert alert-danger"';
                                            } ?> type="text"
                                                 value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('diesel', $conn), $conn); ?>"
                                                 id="diesel_price_input<?php echo $station_id; ?>"/>
                                        </td>
                                        <td>
                                            <input
                                                onclick="update_fuel_price('<?php echo 'diesel'; ?>', 'diesel_price_input<?php echo $station_id; ?>', '<?php echo $station_id; ?>')"
                                                class="btn btn-primary well" type="button" value="update"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="button" value="Change status" class="btn btn-info"
                                                   onclick="update_product_status('gas', 'gas_status_checkbox', '<?php echo $station_id; ?>');"/>
                                        </td>
                                        <td> COOKING GAS
                                        </td>
                                        <td>
                                            <input <?php if ((fetch_product_price($station_id, prod_name_to_prod_id('gas', $conn), $conn)) != "unavailable") {
                                                echo 'class="alert alert-success"';
                                            } else {
                                                echo 'class="alert alert-danger"';
                                            } ?> type="text"
                                                 value="<?php echo fetch_product_price($station_id, prod_name_to_prod_id('gas', $conn), $conn); ?>"
                                                 id="gas_price_input<?php echo $station_id; ?>"/>
                                        </td>
                                        <td>
                                            <input
                                                onclick="update_fuel_price('<?php echo 'gas'; ?>', 'gas_price_input<?php echo $station_id; ?>', '<?php echo $station_id; ?>')"
                                                class="btn btn-primary well" type="button" value="update"/>
                                        </td>
                                    </tr>
                        </div>

                        </form>
                        </table>
                        <div class="col-md-8" style="padding:20px;">
                            <h4>Short description </h4>

                            <p style="text-align:justify;"> <?php echo $station_description; ?></p>
                        </div>
                    </div>
                    <div style="clear:both;"></div>

                    <?php
                }
            }
            ?>

        <?php }
        ?>

    </div>
</div>

</div>
</div>

</div>
</div>

</div>
<!-- end:header-top -->

<!-- fh5co-blog-section -->
<footer>
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 animate-box">
                    <ul style="list-style:none;">
                        <h3 class="section-title white-fg">Useful links</h3>
                        <li class="footer_useful_links"><a href="../"> Home</a></li>
                        <li class="footer_useful_links"><a href="../products/"> Products</a></li>
                        <li class="footer_useful_links"><a href="../stations/"> Gas Stations</a></li>
                        <li class="footer_useful_links"><a href="../contact/"> Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-4 animate-box">
                    <ul class="contact-info" style="list-style: none;">
                        <h3 class="section-title  white-fg">Our Address</h3>
                        <li class="footer_useful_links"><i class="icon-map-marker"></i> 48 Isaac Boro Express-Way
                            Yenagoa, Bayelsa State.
                        </li>
                        <li class="footer_useful_links"><i class="icon-phone"></i> +2341230000000</li>
                        <li class="footer_useful_links"><i class="icon-envelope"></i><a href="#"> info@gastopup.com</a>
                        </li>
                        <li class="footer_useful_links"><i class="icon-globe2"></i><a href="#"> www.gastopup.com</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 animate-box">
                    <h3 class="section-title  white-fg">Drop us a line</h3>

                    <p id="success_error" class="alert hidden" style="text-align:center;"></p>

                    <form action="javascript:void(0);" onsubmit="submitContactUs()" id="contactForm" method="post">
                        <div class="form-group">
                            <p class="grey_text_color sr-only"> Name: </p>
                            <input type="text" class="form-control" id="contact_name" placeholder="Your name..."
                                   required/>
                        </div>
                        <div class="form-group">
                            <p class="grey_text_color sr-only"> Email: </p>
                            <input type="email" class="form-control" name="email" id="contact_email"
                                   placeholder="Your Email..." required/>
                        </div>
                        <div class="form-group">
                            <p class="grey_text_color sr-only"> Message: </p>
                            <textarea class="form-control" id="contact_message" rows="5" data-rule="required"
                                      data-msg="Please write something for us" placeholder="Message..."
                                      required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="contact_us_submit" class="btn btn-flat form-control">SUBMIT
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="row copy-right">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <p class="fh5co-social-icons">
                        <a href="#"><i class="icon-twitter2"></i></a>
                        <a href="#"><i class="icon-facebook2"></i></a>
                        <a href="#"><i class="icon-instagram"></i></a>
                        <a href="#"><i class="icon-dribbble2"></i></a>
                        <a href="#"><i class="icon-youtube"></i></a>
                    </p>

                    <p> &copy; Copyright 2018 gastop-up.com </p>
                </div>
            </div>
        </div>
    </div>
</footer>


</div>
<!-- END fh5co-page -->

</div>
<!-- END fh5co-wrapper -->

<!-- jQuery -->


<script src="../core_files/js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="../core_files/js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="../core_files/s/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="../core_files/js/jquery.waypoints.min.js"></script>
<script src="../core_files/js/sticky.js"></script>

<!-- Stellar -->
<script src="../core_files/js/jquery.stellar.min.js"></script>
<!-- Superfish -->
<script src="../core_files/js/hoverIntent.js"></script>
<script src="../core_files/js/superfish.js"></script>

<!-- Main JS -->
<script src="../core_files/js/main.js"></script>

</body>
</html>

