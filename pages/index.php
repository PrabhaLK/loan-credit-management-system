<?php
ini_set('session.cookie_secure', 1);  // Only send over HTTPS
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access
ini_set('session.cookie_samesite', 'Strict'); // SameSite policy

session_start();
if (!isset($_SESSION['nic'])) {
    header("Location: ../functions/logout_funct.php");
}
include('../functions/login_check.php');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Management System - NITF</title>
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="../asset/css/index/main.css" rel="stylesheet" />
    <link href="../asset/css/index/bootstrap.min.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="../asset/js/sweetalert2@11.js"></script>
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="dropdown.css">

</head>
<?php include('../functions/validate-login.php'); ?>

<body>
    <script>
        console.log("document loaded");

        // Prevent back button navigation
        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function(event) {
            event.preventDefault();
            window.history.pushState(null, null, window.location.href);

            Swal.fire({
                title: 'Are you sure?',
                text: 'Pressing the back button will destroy your session.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, destroy session',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'custom-swal-width-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Synchronous AJAX request to destroy session
                    $.ajax({
                        url: '../functions/handle_navigation.php', // Ensure this PHP exists
                        type: 'POST',
                        async: false,
                        success: function(response) {
                            window.location.href = '../login.php'; // Redirect after destroying session
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'There was a problem destroying the session',
                                icon: 'error',
                                customClass: {
                                    popup: 'custom-swal-width-sm'
                                }
                            });
                        }
                    });
                } else {
                    // Cancel back button navigation
                    event.preventDefault();
                }
            });
        });

        // Prevent forward button navigation (pageshow for back-forward cache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                // Force reload if page is coming from cache
                window.location.reload();
            }
        });
        $(document).ready(function() {
            // Function to handle the click event on each claim type link
            $(document).on('click', '.toggle', function(event) {
                event.preventDefault(); // Prevent default link behavior

                var link = $(this).attr('href'); // Get link's href attribute

                // Ask for the NIC
                Swal.fire({
                    title: 'Enter NIC',
                    input: 'text',
                    inputPlaceholder: 'Enter your NIC',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'custom-swal-width-sm'
                    },
                    preConfirm: (nic) => {
                        if (!nic) {
                            Swal.showValidationMessage('NIC is required');
                            return false;
                        }
                        return nic;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var nic = result.value;

                        // AJAX request to check NIC
                        $.ajax({
                            url: '../functions/check_nic.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                nic: nic
                            },
                            success: function(response) {
                                if (response && response.status === 'success') {
                                    Swal.fire({
                                        title: 'User Found',
                                        text: 'Username: ' + response.username,
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Re-enter',
                                        customClass: {
                                            popup: 'custom-swal-width-sm'
                                        },
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Redirect only if OK is selected
                                            window.location.href = link;
                                        } else {
                                            promptNIC();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'NIC not found',
                                        text: 'Please check and re-enter your NIC.',
                                        icon: 'error',
                                        showCancelButton: true,
                                        confirmButtonText: 'Re-enter',
                                        cancelButtonText: 'Cancel',
                                        customClass: {
                                            popup: 'custom-swal-width-sm'
                                        },
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            promptNIC();
                                        }
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'There was a problem checking the NIC',
                                    icon: 'error',
                                    customClass: {
                                        popup: 'custom-swal-width-sm'
                                    },
                                });
                            }
                        });
                    }
                });

                // Function to prompt for NIC entry again
                function promptNIC() {
                    Swal.fire({
                        title: 'Enter NIC',
                        input: 'text',
                        inputPlaceholder: 'Enter your NIC',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'custom-swal-width-sm'
                        },
                        preConfirm: (nic) => {
                            if (!nic) {
                                Swal.showValidationMessage('NIC is required');
                                return false;
                            }
                            return nic;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var nic = result.value;

                            // AJAX request to check NIC again
                            $.ajax({
                                url: '../functions/check_nic.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    nic: nic
                                },
                                success: function(response) {
                                    if (response && response.status === 'success') {
                                        Swal.fire({
                                            title: 'User Found',
                                            text: 'Username: ' + response.username,
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                            customClass: {
                                                popup: 'custom-swal-width-sm'
                                            },
                                        }).then(() => {
                                            window.location.href = link;
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'NIC not found',
                                            text: 'Please check and re-enter your NIC.',
                                            icon: 'error',
                                            showCancelButton: true,
                                            confirmButtonText: 'Re-enter',
                                            cancelButtonText: 'Cancel',
                                            customClass: {
                                                popup: 'custom-swal-width-sm'
                                            },
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                promptNIC();
                                            }
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'There was a problem checking the NIC',
                                        icon: 'error',
                                        customClass: {
                                            popup: 'custom-swal-width-sm'
                                        },
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <!-- NITF logo added -->
    <div class="logo-container">
        <img class="logo" src="../images/logo.png" alt="Logo">
    </div>

    <h1>Dropdown List</h1>
    <!-- <?php echo $_SESSION["nic"] ?> -->
    <div class="container">
        <nav class="main-dropdown">
            <div id="navbar">
                <ul class="topOne">
                    <!-- Hospitalization dropdown menu -->
                    <li class="first-list">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hospitalization <b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="./govt-hos.php?type=Government Hospitalization">Government Hospitalization</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Government Ayuvedic Hospitalization">Government Ayurvedic Hospitalization</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Private Hospitalization">Private Hospitalization</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Private Ayuvedic Hospitalization">Private Ayurvedic Hospitalization</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery - Dependant">Heart Surgery - Dependent</a></li>
                        </ul>
                    </li>

                    <li class="second-list">
                        <a href="govt-hos.php" class="dropdown-toggle" data-toggle="dropdown">Child Birth * 2<b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="./govt-hos.php?type=Child Birth - Government Hospital">Government Hospital</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Child Birth- Private Hospital (Normal)">Private Hospital-Normal</a></li>
                            <li><a class="toggle" href="./govt-hos.php?type=Child Birth- Private Hospital (Ceaser)">Private Hospital-Ceaser</a></li>
                        </ul>
                    </li>

                    <li class="third-list">
                        <a href="govt-hos.php" class="dropdown-toggle" data-toggle="dropdown">Heart<b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery">Surgery</a></li>
                            <li><a class="toggle" href="govt-hos.php?type=Heart Surgery - Guarantee">Surgery Guarantee</a></li>
                            <li><a class="toggle" href="govt-hos.php?type=RF Ablation">RF Ablation</a></li>
                        </ul>
                    </li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Cancer">Cancer</a></li>

                    <li class="forth-list">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Kidney<b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery">Surgery</a></li>
                            <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery - Guarantee">Surgery Guarantee</a></li>
                        </ul>
                    </li>
                    <li class="fifth-list">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Brain<b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="govt-hos.php?type=Brain Surgery"> Brain Surgery</a></li>
                            <li><a class="toggle" href="govt-hos.php?type=Brain Surgery - Guarantee">Surgery Guarantee</a></li>
                        </ul>
                    </li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Knee">Knee</a></li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Hip">Hip</a></li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Hearing Aid">Hearing Aid</a></li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Spectacles">Spectacles</a></li>

                    <li class="fifth-list">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Death<b class="caret"></b></a>
                        <ul>
                            <li><a class="toggle" href="govt-hos.php?type=Natural Death">Natural Death</a></li>
                            <li><a class="toggle" href="govt-hos.php?type=Accidental Death">Accident Death</a></li>
                        </ul>
                    </li>

                    <li class="active"><a class="toggle" href="govt-hos.php?type=Accident">Accident</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="ft">
        <ul>
            <li> <a href="../functions/logout_funct.php" class="navbar-brand button-login">Log in Page</a></li>
            <br><br>
            <li><a href="../Pages/index_new.php" class="navbar-brand button-newMenu">New Home Page</a></li>
        </ul>
    </div>
</body>
</html>