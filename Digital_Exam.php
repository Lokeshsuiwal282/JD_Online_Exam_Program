
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JD-Mtop/Home.com</title>
    <link rel="icon" type="image/png" href="photos\\logo_Home.png">
     <!-- Include Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Home.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Style for the button */
        .button {
            display: flex;
            justify-content: flex-end; /* Align button to the right */
            margin: -3.5rem 2rem; /* Adjust margin as needed */
        }

        .button a {
            background-color: #007bff; /* Button background color */
            color: #fff; /* Button text color */
            border: none; /* Remove border */
            padding: 8px 21px; /* Padding inside the button */
            cursor: pointer; /* Cursor style on hover */
            border-radius: 5px; /* Rounded border */
            font-size: 17px; /* Font size */
            text-decoration: none; /* Remove default underline */
        }

        .button a:hover {
            background-color: #ef4e22; /* Button background color on hover */
        }

    </style>
</head>
<body>
    <div class="header" id="header">
        <div class="header-name" id="header-name">
            <!-- <div class="header-payroll" id="header-payroll">
            </div> -->
            <div class="detailswithimage" id="detailswithimage">
                <label _ngcontent-erb-c20="" class="imageOfProfile">
                    <i _ngcontent-erb-c20="" class="ng-tns-c20-4">
                        <img _ngcontent-erb-c20="" class="ng-tns-c20-4" alt="Profile Picture" src="photos\default_profile.jpg">
                    </i>
                </label>
                <label _ngcontent-erb-c20="" class="imageOfProfileNames">
                    <span _ngcontent-erb-c20="" class="ng-tns-c20-4"> Welcome </span>
                    <span _ngcontent-erb-c20="" class="ng-tns-c20-4" aria-label="Tap to switch user" role="link" tabindex="0">Lokesh kumar saini</span><!---->
                </label>
                 <!-- Logout button -->
                 <!-- <form action="Home.php" method="post">
                    <button type="submit" name="logout">Home</button>
                </form> -->
                <div class="button">
                    <a href="Home.php" >Home</a>    
                </div>
            </div>
        </div>
    </div>

    <!-- Technology used section design for html code -->
   <section class="technology-used" id="technology-used">
        <h2 class="heading">Digital<span> Exam!</span></h2>

        <div class="technology-contect">

            <div class="technology-box">
                <a href="http://localhost/mtop-project/exampaper/DBMD.php" class="btn"><h3>DBMS(Database Management System)</h3></a>
            </div>
            <div class="technology-box">
                <!-- <i class='bx bxl-java' ></i> -->
                <a href="http://localhost/mtop-project/exampaper/cn.php" class="btn"><h3>CN(Computer Networks)</h3></a>
            </div>
            <div class="technology-box">
                <!-- <i class='bx bx-server'></i> -->
                <a href="http://localhost/mtop-project/exampaper/Python.php" class="btn"><h3>Python</h3></a>
            </div>
            <div class="technology-box">
                <!-- <i class='bx bxl-android'></i> -->
                <a href="http://localhost/mtop-project/exampaper/sql.php" class="btn"><h3>SQL(Structured Query Language)</h3></a>
            </div>
        </div>
    </section>  

<!-- footer design for html code -->
    <!-- Section: Links  -->
    <footer id="footer" class="footer">
        <div class="text-center mb-3">
            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-facebook-f"></i>   
            </button>
    
            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-google"></i>
            </button>
    
            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-twitter"></i>
            </button>
            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-github"></i>
            </button>
            <div class="footer-copyrights">
                <p>Copyright &copy; 2024 by JD Developer | All Rights Reserved</p>
            </div>
        </div>
    </footer>
</body>
</html>