<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(224, 232, 245, 1) 100%);
        }

        .container {
            width: 90%;
            margin: 40px auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .menu-box {
            background-color: #4f7df5;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 7px 30px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .menu-box:hover {
            transform: translateY(-10px);
        }

        .menu-title {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .menu-box img {
            width: 50px;
        }

        .menu-circles {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .menu-circle {
            position: absolute;
            background-color: #fff;
            border-radius: 50%;
            z-index: 0;
        }

        .menu-circle.circle-1 {
            width: 64px;
            height: 64px;
            opacity: 0.3;
            animation: pulse 3s infinite alternate;
        }

        .menu-circle.circle-2 {
            width: 128px;
            height: 128px;
            opacity: 0.2;
            animation: pulse 3s infinite alternate 0.5s;
        }

        .menu-circle.circle-3 {
            width: 192px;
            height: 192px;
            opacity: 0.1;
            animation: pulse 3s infinite alternate 1s;
        }

        .menu-circle.circle-4 {
            width: 256px;
            height: 256px;
            opacity: 0.1;
            animation: pulse 3s infinite alternate 1.5s;
        }

        @keyframes pulse {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .dropdown-menu {
            display: none;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 2px 20px -2px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            position: relative;
            z-index: 1;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu ul {
            list-style: none;
            padding: 0;
        }

        .dropdown-menu ul li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 18px;
        }

        .dropdown-menu ul li:hover {
            color: #4f7df5;
        }

        .dropdown-menu ul li a {
            text-decoration: none;
            color: #c4d0de;
            transition: color 0.3s;
        }

        .dropdown-menu ul li a:hover {
            color: #4f7df5;
        }
    </style>
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('active');
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="menu-box" onclick="toggleMenu('menu1')">
            <div class="menu-title">Hospitalization</div>
            <img src="http://danysantos.hol.es/img/planet.png" alt="Hospitalization">
            <div class="menu-circles">
                <div class="menu-circle circle-1"></div>
                <div class="menu-circle circle-2"></div>
                <div class="menu-circle circle-3"></div>
                <div class="menu-circle circle-4"></div>
            </div>
            <div id="menu1" class="dropdown-menu">
                <ul>
                    <li><a href="#">Government Hospitalization</a></li>
                    <li><a href="#">Private Hospitalization</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" onclick="toggleMenu('menu2')">
            <div class="menu-title">Notifications</div>
            <img src="http://danysantos.hol.es/img/planet.png" alt="Notifications">
            <div class="menu-circles">
                <div class="menu-circle circle-1"></div>
                <div class="menu-circle circle-2"></div>
                <div class="menu-circle circle-3"></div>
                <div class="menu-circle circle-4"></div>
            </div>
            <div id="menu2" class="dropdown-menu">
                <ul>
                    <li><a href="#">Notification Settings</a></li>
                    <li><a href="#">View Notifications</a></li>
                </ul>
            </div>
        </div>

        <!-- Additional menu items -->
        <div class="menu-box" onclick="toggleMenu('menu3')">
            <div class="menu-title">Spectacles</div>
            <img src="http://danysantos.hol.es/img/planet.png" alt="Spectacles">
            <div class="menu-circles">
                <div class="menu-circle circle-1"></div>
                <div class="menu-circle circle-2"></div>
                <div class="menu-circle circle-3"></div>
                <div class="menu-circle circle-4"></div>
            </div>
            <div id="menu3" class="dropdown-menu">
                <ul>
                    <li><a href="#">Claim Spectacles</a></li>
                    <li><a href="#">View Spectacles Limit</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" onclick="toggleMenu('menu4')">
            <div class="menu-title">Childbirth</div>
            <img src="http://danysantos.hol.es/img/planet.png" alt="Childbirth">
            <div class="menu-circles">
                <div class="menu-circle circle-1"></div>
                <div class="menu-circle circle-2"></div>
                <div class="menu-circle circle-3"></div>
                <div class="menu-circle circle-4"></div>
            </div>
            <div id="menu4" class="dropdown-menu">
                <ul>
                    <li><a href="#">Claim Childbirth</a></li>
                    <li><a href="#">View Childbirth Claims</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
