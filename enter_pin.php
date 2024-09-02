<?php
require_once("configatm.php");
session_start();

$showAlert = false; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["num"])) {
        $enteredPIN = $_POST["num"];
        $user = $_SESSION['user'];

       
        $query = mysqli_query($conn, "SELECT pin FROM users WHERE pin='$enteredPIN' AND userid='$user'");
        $row = mysqli_fetch_assoc($query);

        if ($row) {
           
            header("Location: withdraw_amount.php");
            exit(); 
        } elseif ($enteredPIN != "") {
            $showAlert = true; 
            
        }
    }
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN</title>
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
        .mb-4{
            font-size: 30px;
            color: #3498db; 
            font-weight:600;
            text-align:center;
         }
         #st{color: blueviolet;
            box-shadow:5px 5px 5px green;
        }
        .form-control {
            width: 50%;
            padding: 10px 5px;
            margin-top: -5px;
            margin-left:195px;
            font-size: 20px;
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
            .btn1{
            padding:50px;
            margin-top:60px;
        }
        .btns{
            float:right;
        }


        .btn-primary {
            justify-content: center;
            background-color: #3498db;
            border: none;
            font-size: 20px;
            border-radius: 100px;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
            margin-top: 40px;
            width: 200px;
            height: 50px;

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
            <div class="heading">
                <h2 class="mb-4"><strong>Please Enter Your<span id="st"> <br>PIN</strong></span></h2>
            </div>
            <form action="" method="POST">
                <div class="btn-container">
                    <div class="btn1">
                        <input type="password" class="form-control" id="num" name="num" pattern="[0-9]{4}" maxlength="4" required>
                        
                    </div>
                    <div class="btn2">
                        <button type="submit" class="btn btn-primary btns" name="save" id="save"><strong>Press Ok</strong></button><br>
                    </div>
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
            title: "Invalid Pin!",
            text: "Please try again",
            icon: "error",
        }).then((value) => {
            window.location.replace("enter_pin.php");
        });
    </script>';
}
?>

</body>
</html>
