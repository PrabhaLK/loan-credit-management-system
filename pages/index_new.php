<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Improved Home Page with Sliding Dropdown</title>
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
            overflow-x: hidden;
        }

        .container-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 40px;
            padding: 20px;
            justify-items: center;
            transition: transform 0.4s ease;
            /* Smooth sliding transition */
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
            z-index: 1;
        }

        .menu-box:hover {
            background-color: #6a0dad;
            transform: scale(1.05);
        }

        .menu-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            /* fill: white;
            filter: brightness(0) invert(1); */
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
            z-index: 10;
            transition: opacity 0.3s ease;
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
        }

        .dropdown-menu ul li a {
            text-decoration: none;
            color: #4f7df5;
            font-size: 0.95rem;
            display: block;
            padding: 10px 15px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .dropdown-menu ul li a:hover {
            color: white;
            transform: scale(1.05);
        }

        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
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
        // Function to toggle the dropdown menu and slide the below container
        function toggleMenu(menuId, belowContainerId, belowContainer2Id, type) {
            const menuBox = document.getElementById(menuId);
            const belowContainer = document.getElementById(belowContainerId);
            const belowContainer2 = document.getElementById(belowContainer2Id);
            const dropdownMenu = menuBox.querySelector('.dropdown-menu');

            const isOpen = menuBox.classList.contains('active');

            if (isOpen) {
                menuBox.classList.remove('active');
                belowContainer.style.transform = 'translateY(0)';
                belowContainer2.style.transform = 'translateY(0)';
            } else {
                closeAllMenus(); // Close all open menus
                menuBox.classList.add('active');

                // Check if there's a dropdown menu
                if (dropdownMenu) {
                    // Calculate height of the dropdown menu
                    const dropdownHeight = dropdownMenu.offsetHeight;

                    // Slide the below container down by the height of the dropdown
                    belowContainer.style.transform = `translateY(${dropdownHeight}px)`;
                    belowContainer2.style.transform = `translateY(${dropdownHeight}px)`;
                } else {
                    // Redirect if there's no dropdown
                    window.location.href = `govt-hos.php?type=${type}`;
                }
            }
        }

        // Close all menus and reset containers
        function closeAllMenus() {
            const allMenus = document.querySelectorAll('.menu-box');
            const allContainers = document.querySelectorAll('.container-row');
            allMenus.forEach(menu => {
                menu.classList.remove('active');
            });
            allContainers.forEach(container => {
                container.style.transform = 'translateY(0)';
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.menu-box');
            if (!isClickInside) {
                closeAllMenus();
            }
        });
    </script>
</head>


<body>
    <!-- First row of menu items -->
    <div id="row1" class="container-row">
        <div class="menu-box" id="menu1" onclick="toggleMenu('menu1', 'row2', 'row3')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/hospital.png" alt="icon" class="icon" />
            <div class="menu-title">HOSPITALIZATION</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="./govt-hos.php?type=Government Hospitalization">Government Hospitalization</a></li>
                    <li><a href="./govt-hos.php?type=Government Ayurvedic Hospitalization">Government Ayurvedic Hospitalization</a></li>
                    <li><a href="./govt-hos.php?type=Private Hospitalization">Private Hospitalization</a></li>
                    <li><a href="./govt-hos.php?type=Private Ayurvedic Hospitalization">Private Ayurvedic Hospitalization</a></li>
                    <li><a href="./govt-hos.php?type=Heart Surgery - Dependant">Heart Surgery - Dependent</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" id="menu2" onclick="toggleMenu('menu2', 'row2', 'row3')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/ChildBirth.svg" alt="icon" class="icon" />
            <div class="menu-title">CHILD BIRTH x2</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="./govt-hos.php?type=Child Birth - Government Hospital">Government Hospital</a></li>
                    <li><a href="./govt-hos.php?type=Child Birth- Private Hospital (Normal)">Private Hospital - Normal</a></li>
                    <li><a href="./govt-hos.php?type=Child Birth- Private Hospital (Ceaser)">Private Hospital - Ceaser</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" id="menu3" onclick="toggleMenu('menu3', 'row2', 'row3')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/heart.svg" alt="icon" class="icon" />
            <div class="menu-title">HEART</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a href="./govt-hos.php?type=Heart Surgery - Government">Government</a></li>
                    <li><a href="./govt-hos.php?type=Heart Surgery - Private">Private</a></li>
                </ul>
            </div>
        </div>

        <div class="menu-box" id="menu4" onclick="toggleMenu('menu4', 'row2', 'row3', 'Cancer')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/cancer.svg" alt="icon" class="icon" />
            <div class="menu-title">CANCER</div>
        </div>
    </div>
    <!-- Second row of menu items -->
    <div id="row2" class="container-row">
        <div class="menu-box" id="menu5" onclick="toggleMenu('menu5', 'row3','row4')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/kidney.svg" alt="icon" class="icon" />
            <div class="menu-title">KIDNEY</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery">Surgery</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery - Guarantee">Surgery Guarantee</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu7" onclick="toggleMenu('menu7', 'row3','row4')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/brain.svg" alt="icon" class="icon" />
            <div class="menu-title">BRAIN</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery">Surgery</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Kidney Surgery - Guarantee">Surgery Guarantee</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu8" onclick="toggleMenu('menu8', 'row3','row4','Knee')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/knee.svg" alt="icon" class="icon" />
            <div class="menu-title">KNEE</div>
        </div>
        <div class="menu-box" id="menu9" onclick="toggleMenu('menu9', 'row3','row4', 'Hip')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/hip.png" alt="icon" class="icon" />
            <div class="menu-title">HIP</div>
        </div>
    </div>
    <div id="row3" class="container-row">
        <div class="menu-box" id="menu10" onclick="toggleMenu('menu10', 'row4','row5', 'Hearing Aid')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/hearingAid.svg" alt="icon" class="icon" />
            <div class="menu-title">HEARING AID</div>
        </div>
        <div class="menu-box" id="menu11" onclick="toggleMenu('menu11', 'row4','row5',  'Spectacles')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/Spectacles.svg" alt="icon" class="icon" />
            <div class="menu-title">SPECTACLES</div>
        </div>
        <div class="menu-box" id="menu12" onclick="toggleMenu('menu12', 'row4','row5')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/death.svg" alt="icon" class="icon" />
            <div class="menu-title">DEATH</div>
            <div class="dropdown-menu">
                <ul>
                    <li><a class="toggle" href="govt-hos.php?type=Natural Death">Natural Death</a></li>
                    <li><a class="toggle" href="govt-hos.php?type=Accidental Death">Accident Death</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-box" id="menu13" onclick="toggleMenu('menu11', 'row4','row5',  'Accident')">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
            <img src="../asset/icons/accident.svg" alt="icon" class="icon" />
            <div class="menu-title">ACCIDENT</div>
        </div>
    </div>
    <!-- dummy div for the function validation -->
    <div id="row4" class="container-row"></div>
    <div id="row5" class="container-row"></div>
</body>

</html>