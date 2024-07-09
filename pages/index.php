<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="../asset/css/index/main.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
             <!-- Temporary Logout function implemented here  -->
                <a href="../functions/logout_funct.php" class="navbar-brand"><?php echo $_SESSION["nic"] ?>Gold insurance </a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <!-- Hospitalization dropdown menu -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hospitalization <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="./government-hos.php">Government Hospitalization</a></li>
                                <li><a href="./gov-aryuvedic-hos.php">Government Ayurvedic Hospitalization</a></li>
                                <li><a href="./privet-host.php">Private Hospitalization</a></li>
                                <li><a href="#">Private Ayurvedic Hospitalization</a></li>
                                <li><a href="#">Heart Surgery - Dependent</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Child Birth * 2<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Government Hospital</a></li>
                                <li><a href="#">Private Hospital-Normal</a></li>
                                <li><a href="#">Private Hospital-Ceaser</a></li>
                            </ul>
                        </li>


                        <li>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Heart<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Surgery</a></li>
                                <li><a href="#">Surgery Guarantee</a></li>
                                <li><a href="#">RF Ablation</a></li>
                            </ul>
                        </li>

                        <li class="active"><a href="#">Cancer</a></li>

                        <li>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Kidney<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Surgery</a></li>
                                <li><a href="#">Surgery Guarantee</a></li>

                            </ul>
                        </li>

                        <li class="active"><a href="#">Knee</a></li>

                        <li class="active"><a href="#">Hip</a></li>

                        <li class="active"><a href="#">Hearing Aid</a></li>

                        <li class="active"><a href="#">Spectacles</a></li>

                        <li>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Death<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Natural Death</a></li>
                                <li><a href="#">Accident Death</a></li>
                            </ul>
                        </li>

                        <li class="active"><a href="#">Accident</a></li>
                    </ul>
                </div>
        </nav>
    </div>

</body>

</html>