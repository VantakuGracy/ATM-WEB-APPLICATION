<?php
require_once("configatm.php");
session_start();

if (isset($_POST['save'])) {
    $newpin = $_POST['newpin'];
    $passw = $_POST['passw'];
    $user = $_SESSION['user'];

    if ($newpin === $passw) {
        
        $updateQuery = "UPDATE users SET pin=? WHERE userid=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ss', $newpin, $user);

        if ($stmt->execute()) {
            echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'New PIN Successfully Changed!',
                    icon: 'success',
                }).then(function() {
                    window.location.href='transaction_menu.php';
                });
            }, 500);
          </script>";
        
        } else {
            echo '<script>alert("Error updating PIN. Please try again.");</script>';
        }
    } else {
    
        echo "<script>
        setTimeout(function() {
            Swal.fire({
                title: 'New PIN and confirmed PIN do not match.',
                icon: 'error',
            }).then(function() {
                window.location.href='change_pin.php';
            });
        }, 500);
      </script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            padding: 50px;
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
            margin-top:20px;
        }
        .form-control {
            width: 100%;
            padding: 10px 5px;
            margin-top: 10px;
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
            margin-top:20px;
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
            <h2>Change PIN</h2>
            <form action="change_pin.php" method="POST">
                <div class="mb-3">
                    <label class="form-label" for="password">Enter New Pin</label>
                    <input type="password" class="form-control" id="newpin" name="newpin" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Confirm Pin</label>
                    <input type="password" class="form-control" id="passw" name="passw" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="save" name="save"><strong>Generate</strong></button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>
</html>
