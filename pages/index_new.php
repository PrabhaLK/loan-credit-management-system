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
            grid-gap: 25px;
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
            z-index: 2;
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
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            fill: white;
            z-index: 3;
            filter: brightness(0) invert(1);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            width: 100%;
            background-color: white;
            box-shadow: 0px 2px 20px -2px rgba(0, 0, 0, 0.3);
            text-align: left;
            padding: 10px;
            border-radius: 5px;
            z-index: 4;
        }

        .menu-box.active .dropdown-menu {
            display: block;
        }

        .dropdown-menu ul {
            list-style-type: none;
        }

        .dropdown-menu ul li {
            position: relative;
        }

        .dropdown-menu ul li:hover {
            border-left: 5px solid white;
            background-color: #6a0dad;
            text-decoration: none;
        }

        .dropdown-menu ul li a {
            text-decoration: none;
            color: #4f7df5;
            font-size: 0.95rem;
            transition: color 0.3s ease, transform 0.3s ease;
            display: block;
            padding: 10px 15px;
        }

        .dropdown-menu ul li a:hover {
            color: white;
            transform: scale(1.05);
        }

        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            z-index: 1;
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
        // Function to toggle the dropdown menu
        function toggleMenu(menuId) {
            const menuBox = document.getElementById(menuId);
            const allMenus = document.querySelectorAll('.menu-box');
            allMenus.forEach(menu => {
                if (menu !== menuBox) {
                    menu.classList.remove('active'); // Close other menus
                }
            });
            menuBox.classList.toggle('active'); // Toggle the clicked menu
        }

        // Close the dropdown if clicked outside
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.menu-box');
            if (!isClickInside) {
                const allMenus = document.querySelectorAll('.menu-box');
                allMenus.forEach(menu => {
                    menu.classList.remove('active'); // Close all dropdowns
                });
            }
        });
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
                    <li><a class="toggle" href="./govt-hos.php?type=Government Hospitalization">Government Hospitalization</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Government Ayuvedic Hospitalization">Government Ayurvedic Hospitalization</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Private Hospitalization">Private Hospitalization</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Private Ayuvedic Hospitalization">Private Ayurvedic Hospitalization</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery - Dependant">Heart Surgery - Dependent</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" id="menu2" onclick="toggleMenu('menu2')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/childBirth.svg" alt="icon" class="icon" />
            <div class="menu-title">Child Birth x2 </div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="./govt-hos.php?type=Child Birth - Government Hospital">Government Hospital</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Child Birth- Private Hospital (Normal)">Private Hospital-Normal</a></li>
                    <li><a class="toggle" href="./govt-hos.php?type=Child Birth- Private Hospital (Ceaser)">Private Hospital-Ceaser</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu3" onclick="toggleMenu('menu3')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/heart.svg" alt="icon" class="icon" />
            <div class="menu-title">Heart</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery">Surgery</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Heart Surgery - Guarantee">Surgery Guarantee</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=RF Ablation">RF Ablation</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu4" onclick="toggleMenu('menu4')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/cancer.svg" alt="icon" class="icon" />
            <div class="menu-title">Cancer</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery">Surgery</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Heart Surgery - Guarantee">Surgery Guarantee</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=RF Ablation">RF Ablation</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu4" onclick="toggleMenu('menu4')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/kidney.svg" alt="icon" class="icon" />
            <div class="menu-title">Kidney</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="./govt-hos.php?type=Heart Surgery">Surgery</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Heart Surgery - Guarantee">Surgery Guarantee</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=RF Ablation">RF Ablation</a></li>
                </ul>
            </div>
        </div>
        <!-- Add more menu items similarly -->
    </div>
</body>
</html>