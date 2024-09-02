<?php
require_once("configatm.php");
session_start();

$showAlert = false; 

if (isset($_POST["save"])) {
    $un = $_POST['uname'];
    $pw = $_POST['passw'];
    $query = mysqli_query($conn, "SELECT userid, password FROM users WHERE userid='$un' AND password='$pw'");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $_SESSION['user'] = $un;
        header("Location: language_page.php");
        exit(); 
    } else {
        $showAlert = true; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

    <style>
        .bg{
            height:135px;
            width:70%;
            background-color:gray;
            margin:0 auto;
        }
        .round-div {
            width: 150px; 
            height: 150px; 
            border-radius: 50%;
            overflow: hidden; 
            margin-top: 50px;
        }

        .round-div img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }
        .content1{
            position:absolute;
            margin-top:30px;
            font-size:80px;
            margin-left:110px;
            font-family: 'Roboto', sans-serif;
            color:#F1B657;
	        text-shadow: 2px 2px 10px darkblue;


        }
        .content2{
            position:absolute;
            margin-top:30px;
            font-size:80px;
            margin-left:475px;
            font-family: 'Roboto', sans-serif; 
            color:#F1B657;
            text-shadow: 2px 2px 10px darkblue;

        }
        body {
            background-color: #f2f2f2f2;
            font-family: 'Roboto', 'Open Sans', sans-serif;
            font-weight: 800;
            font-size: 25px;
            
        }
        header {
            text-align: center;
            margin-top: 20px;
        }
        .div1 {
            border: 4px solid #f8fff8;
            height: 600px;
            width: 70%;
            margin: 0 auto;
            background-color: #f8fff8;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-container {
            width: 80%;
            height:80%;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            margin-top: 90px;
            background-color: #fff7f9;
        }
        h2 {
            font-size: 35px;
            text-align: center;
            font-style:bold;
            font-weight:800;
            color: blueviolet;
            box-shadow:5px 5px 5px green;
        }
        .mb-3{
            font-size:18px;
        }
        .form-label {
            color: #3498db;
            margin-top:30px;
        }
        .form-control {
            width: 100%;
            padding: 10px 5px;
            margin-top: -5px;
            font-size: 15px;
            transition: 0.5s;
            background-color: #ecf0f1;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
        }
        .form-control:hover {
            background-color: #d5dbdb;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-primary {
            width: 200px;
            height:50px;
            justify-content: center;
            background-color: #3498db;
            border: none;
            font-size: 20px;
            border-radius: 100px;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
            margin-top:40px;
        }
        .btn-primary:hover {
            background-color: #34dbb1;
            color: #ffffff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn-primary:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

<div class="bg">
    <div class="content1">INDIAN</div>
    <div class="col d-flex justify-content-center">
        <div class="round-div overflow-hidden">
            <img src="bg1.jpeg" alt="Round Image" class="img-fluid">
        </div>
        <div class="content2">BANK</div>
    </div>
</div>

<div class="div1">
    <div class="login-container">
        <h2>LOGIN</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control" id="uname" name="uname" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-control" id="passw" name="passw" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary" id="save" name="save"><strong>LogIn</strong></button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
if ($showAlert) {
    echo '<script>
        swal({
            title: "Invalid User ID or Pin!",
            text: "Please try again",
            icon: "error",
        }).then((value) => {
            window.location.replace("login_page.php");
        });
    </script>';
}
?>


</body>
</html>
