<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Improved Home Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: "Open Sans", sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(224, 232, 245, 1) 100%);
            position: relative;
            overflow: hidden;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 15px;
            padding: 20px;
            justify-items: center;
            z-index: 1;
        }

        .menu-box {
            width: 240px;
            height: 160px;
            background-color: #4f7df5;
            border-radius: 10px;
            box-shadow: 0px 7px 30px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease;
            z-index: 1;
        }

        .menu-box:hover {
            background-color: #365dba;
            transform: scale(1.05);
        }

        .menu-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            z-index: 2;
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            fill: white;
            z-index: 2;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            width: 100%;
            background-color: white;
            box-shadow: 0px 2px 20px -2px rgba(0, 0, 0, 0.3);
            border-radius: 3px;
            text-align: left;
            padding: 10px;
            z-index: 3;
        }

        .menu-box.active .dropdown-menu {
            display: block;
        }

        .dropdown-menu ul {
            list-style-type: none;
        }

        .dropdown-menu ul li {
            margin: 10px 0;
            padding-left: 5px;
            border-left: 5px solid transparent;
            transition: background-color 0.3s ease, color 0.3s ease, border-left 0.3s ease;
        }

        .dropdown-menu ul li:hover {
            background-color: #4f7df5;
            color: white;
            border-left: 5px solid white;
        }

        .dropdown-menu ul li a {
            text-decoration: none;
            color: #4f7df5;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .dropdown-menu ul li:hover a {
            color: white;
        }

        /* Circle animations inside the menu box */
        .menu-box .circle {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            opacity: 0.15;
            z-index: 0; /* Lower z-index so that circles are behind clickable elements */
        }

        .menu-box .circle-1 {
            width: 80px;
            height: 80px;
            top: 10px;
            left: -20px;
            animation: animation_circle 6s infinite alternate;
        }

        .menu-box .circle-2 {
            width: 120px;
            height: 120px;
            top: 60px;
            right: -40px;
            animation: animation_circle 8s infinite alternate 0.5s;
        }

        @keyframes animation_circle {
            from {
                transform: scale(0.8);
            }

            to {
                transform: scale(1.2);
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuBoxes = document.querySelectorAll(".menu-box");

            menuBoxes.forEach(box => {
                box.addEventListener("click", function () {
                    // Remove 'active' class from all other boxes
                    menuBoxes.forEach(otherBox => {
                        if (otherBox !== box) {
                            otherBox.classList.remove("active");
                        }
                    });

                    // Toggle the active class on the clicked box
                    box.classList.toggle("active");
                });
            });

            // Close dropdown if clicking outside of the menu box
            document.addEventListener("click", function (event) {
                menuBoxes.forEach(box => {
                    if (!box.contains(event.target)) {
                        box.classList.remove("active");
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="menu-box" id="menu1">
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" style="filter: invert(1);" />
            <div class="menu-title">HOSPITALIZATION</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="#">Government Hospitalization</a></li>
                    <li><a href="#">Private Hospitalization</a></li>
                    <li><a href="#">Ayurvedic Hospitalization</a></li>
                </ul>
            </div>
            <!-- Add circles inside the menu box -->
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>

        <div class="menu-box" id="menu2">
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" style="filter: invert(1);" />
            <div class="menu-title">NOTIFICATIONS</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="#">Notification Settings</a></li>
                    <li><a href="#">View Notifications</a></li>
                </ul>
            </div>
            <!-- Add circles inside the menu box -->
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
        </div>

        <!-- Add more menu items similarly -->
    </div>
</body>

</html>

