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
            position: relative;
            /* Important for containing the circles */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
            /* Ensures that circles don't overflow outside */
            z-index: 2;
            /* Ensures the content stays above the circles */
        }

        .menu-box:hover {
            background-color: #6a0dad;
            transform: scale(1.05);
        }

        .menu-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            z-index: 3;
            /* Ensure text is always above the circles */
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            fill: white;
            z-index: 3;
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
            z-index: 4;
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
        }

        /* Circle styles */
        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.3);
            /* Semi-transparent */
            border-radius: 50%;
            z-index: 1;
            /* Ensure circles are below the text */
        }

        .menu-box .circle {
            opacity: 0.2;
        }

        .menu-box .circle-1 {
            width: 100px;
            height: 100px;
            top: -20px;
            right: -20px;
            animation: animation_circle 6s infinite alternate;
        }

        .menu-box .circle-2 {
            width: 150px;
            height: 150px;
            bottom: -30px;
            left: -30px;
            animation: animation_circle 8s infinite alternate 0.5s;
        }

        .menu-box .circle-3 {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" />
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
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/hospital.svg" alt="icon" class="icon" />
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
</body>

</html>