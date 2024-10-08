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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="../asset/css/index/main.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="dropdown.css">

    <style>
        body {
            overflow: hidden;
        }

        .logo-container {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px;
        }

        .logo {
            width: 300px;
            height: auto;
        }
    </style>

</head>

<body>
    <script>
        console.log("document loaded");

        $(document).ready(function() {
            // Function to handle the click event on each claim type link
            $(document).on('click', '.toggle', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                var link = $(this).attr('href'); // Get the link's href attribute

                // Ask for the NIC
                Swal.fire({
                    title: 'Enter NIC',
                    input: 'text',
                    inputPlaceholder: 'Enter your NIC',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
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

                        // AJAX request to check the NIC in the database
                        $.ajax({
                            url: '../functions/check_nic.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                nic: nic
                            },
                            success: function(response) {
                                console.log('Raw response:', response); // Log raw response
                                console.log('Status:', response.status); // Check the status value

                                // Ensure the response is in the correct format
                                if (response && response.status === 'success') {
                                    Swal.fire({
                                        title: 'User Found',
                                        text: 'Username: ' + response.username,
                                        icon: 'success'
                                    }).then(() => {
                                        // Redirect to the link's href only if NIC is valid
                                        window.location.href = link;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message || 'NIC not found',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'There was a problem checking the NIC',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
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

                    <li class="active"><a href="govt-hos.php?type=Cancer">Cancer</a></li>

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
    <div>
        <a href="../functions/logout_funct.php" class="navbar-brand"><- Log in Page</a>
    </div>
    <!-- SweetAlert2 Notification Framework Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>