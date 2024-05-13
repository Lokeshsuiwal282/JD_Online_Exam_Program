
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JD-Mtop</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="photos\\logo_Home.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            border: none;
            outline: none;
            scroll-behavior: smooth;
            /* font-family: 'Poppins', sans-serif; */
        }
        html {
            /* font-size: 65.5%; */
            overflow-x: hidden;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 6rem;
            /* padding: 2rem 9%; */
            background: rgb(237, 243, 243);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }
        section {
            padding: 8rem 17% 0;
        }
        .footer i{
        font-size: 1.5rem;
        }
    </style>

</head>
<body>

<?php
include 'main.php';

if(isset($_POST['submit'])){
    $studentname = mysqli_real_escape_string($con, $_POST['studentname']);
    $collegeid = mysqli_real_escape_string($con, $_POST['collegeid']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $repass = mysqli_real_escape_string($con, $_POST['repass']);

    // Check if passwords match
    if($password !== $repass){
        echo '<script>alert("Passwords do not match")</script>';
    } else {
        // Hash the password
        $password = password_hash($password, PASSWORD_BCRYPT);
        $hashed_repass = password_hash($repass, PASSWORD_BCRYPT);


        // Check if email already exists
        $emailquery = "SELECT * FROM studentdetails WHERE email='$email'";
        $query = mysqli_query($con, $emailquery);
        $emailcount = mysqli_num_rows($query);

        if($emailcount > 0){
            echo '<script>alert("Email already exists")</script>';
        } else {
            // Insert user details into the database
            $insertquery = "INSERT INTO studentdetails (studentname, collegeid, email, password, repass) VALUES ('$studentname','$collegeid','$email','$password', '$repass')";
            $iquery = mysqli_query($con, $insertquery);

            if($iquery){
                echo '<script>alert("Account has been created successfully")</script>';
            } else {
                echo '<script>alert("Error: Account has not been created")</script>';
            }
        }
    }
}
?>

<?php
include 'main.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data from the database
    $emailquery = "SELECT * FROM studentdetails WHERE email=?";
    $stmt = mysqli_prepare($con, $emailquery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $db_pass = $user['password'];

        // Verify the password
        if(password_verify($password, $db_pass)){
            // Start session and redirect to home page
            session_start();
            $_SESSION['username'] = $user['username']; // Assuming 'username' is a column in your table
            header('location:Home.php');
            exit;
        } else {
            echo '<script>alert("Password Incorrect")</script>';
        }
    } else {
        echo '<script>alert("Invalid Email")</script>';
    }
}
?>


     <!-- header design -->
     <header class="header">
        <!-- <a href="#" class="logo">JD mtop</a> -->
        <!-- <img src="photos\logo_Home.png" alt=""> -->
    </header>

    <section class="login-page" id="login-page">
        <!-- Pills navs -->
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-login" data-toggle="pill" href="#pills-login" role="tab"
                    aria-controls="pills-login" aria-selected="true">Login</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-register" data-toggle="pill" href="#pills-register" role="tab"
                    aria-controls="pills-register" aria-selected="false">Registration</a>
            </li>
        </ul>
        <!-- Pills navs -->
        
        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="POST">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                    <input type="email" id="loginName" class="form-control" name="email" />
                    <label class="form-label" for="loginName">Email or username</label>
                    </div>
            
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                    <input type="password" id="loginPassword" class="form-control" name="password" />
                    <label class="form-label" for="loginPassword">Password</label>
                    </div>
            
                    <!-- 2 column grid layout -->
                    <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-3 mb-md-0">
                        <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked />
                        <label class="form-check-label" for="loginCheck"> Remember me </label>
                        </div>
                    </div>
            
                    <div class="col-md-6 d-flex justify-content-center">
                        <!-- Simple link -->
                        <a href="#!">Forgot password?</a>
                    </div>
                    </div>
            
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4" name="submit"> Login</button>
            
                    <!-- Register buttons -->
                    <div class="text-center">
                    <p>Not a member? <a href="#pills-register">Register</a></p>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                    <input type="text" id="registerName" class="form-control"  name="studentname"/>
                    <label class="form-label" for="registerName">Student Name</label>
                    </div>
            
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                    <input type="text" id="registerUsername" class="form-control" name="collegeid" />
                    <label class="form-label" for="registerUsername">College ID</label>
                    </div>
            
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                    <input type="email" id="registerEmail" class="form-control" name="email"/>
                    <label class="form-label" for="registerEmail">Email</label>
                    </div>
            
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                    <input type="password" id="registerPassword" class="form-control" name="password"/>
                    <label class="form-label" for="registerPassword">Password</label>
                    </div>
            
                    <!-- Repeat Password input -->
                    <div class="form-outline mb-4">
                    <input type="password" id="registerRepeatPassword" class="form-control" name="repass" />
                    <label class="form-label" for="registerRepeatPassword">Repeat password</label>
                    </div>
            
                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                    <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" checked
                        aria-describedby="registerCheckHelpText" />
                    <label class="form-check-label" for="registerCheck">
                        I have read and agree to the terms
                    </label>
                    </div>
            
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-3" name="submit">Sign up</button>

                </form>
            </div>
        </div>
        
    </section>
    <!-- Pills content -->

    <!-- footer design for html code -->
    <!-- Section: Links  -->
    <footer id="footer" class="footer">
        <div class="text-center mb-3">
            <p class="text-center">or:</p>
            <p>Sign in with:</p>
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
 <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  </html> 