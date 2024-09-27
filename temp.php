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
            /* Reduced the gap between cards */
            padding: 20px;
            justify-items: center;
            z-index: 1;
        }

        .menu-box {
            width: 240px;
            /* Slightly increased width */
            height: 160px;
            background-color: #4f7df5;
            border-radius: 10px;
            box-shadow: 0px 7px 30px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            /* Reduced font size */
            position: relative;
            transition: transform 0.3s ease;
        }

        .menu-box:hover {
            background-color: #365dba;
            transform: scale(1.05);
        }

        .menu-title {
            font-size: 1.1rem;
            /* Reduced title size */
            font-weight: bold;
            margin-bottom: 8px;
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            fill: white;
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
            z-index: 2;
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
        }

        .dropdown-menu ul li:hover {
            border-left: 5px solid #6992fe;
        }

        .dropdown-menu ul li a {
            text-decoration: none;
            color: #4f7df5;
            font-size: 0.95rem;
            /* Smaller dropdown font size */
        }

        /* Circle animations for the background */
        .circle {
            position: absolute;
            background-color: #fff;
            border-radius: 50%;
            z-index: 0;
            opacity: 0.15;
        }

        .circle-1 {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 5%;
            animation: animation_circle 6s infinite alternate;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            top: 70%;
            left: 70%;
            animation: animation_circle 8s infinite alternate 0.5s;
        }

        .circle-3 {
            width: 300px;
            height: 300px;
            top: 30%;
            left: 80%;
            animation: animation_circle 10s infinite alternate 1s;
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
        function toggleMenu(menuId) {
            const menuBox = document.getElementById(menuId);
            menuBox.classList.toggle('active');
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="menu-box" id="menu1" onclick="toggleMenu('menu1')">
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" style="filter: invert(1);" />
            <!-- Applied filter to make SVG white if not inline -->
            <div class="menu-title">HOSPITALIZATION</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="#">Government Hospitalization</a></li>
                    <li><a href="#">Private Hospitalization</a></li>
                    <li><a href="#">Ayurvedic Hospitalization</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" id="menu2" onclick="toggleMenu('menu2')">
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" style="filter: invert(1);" />
            <div class="menu-title">NOTIFICATIONS</div>

            <div class="dropdown-menu">
                <ul>
                    <li><a href="#">Notification Settings</a></li>
                    <li><a href="#">View Notifications</a></li>
                </ul>
            </div>
        </div>

        <!-- Add more menu items similarly -->
    </div>

    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
</body>

</html>