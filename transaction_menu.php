<?php
require_once("configatm.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["transaction"])) {
    $transactionType = $_POST["transaction"];
    $user = $_SESSION['user'];

    $sql = "INSERT INTO transaction_db (user_id, trans_type)
            VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $transactionType);

    if ($stmt->execute()) {
        $stmt->close();
        switch ($transactionType) {
            case 'withdrawal':
                header("Location: acc_type.php");
                break;
            case 'deposit':
                header("Location: acc_typeD.php");
                break;
            case 'balance_enquiry':
                header("Location: acc_typeBE.php");
                break;
            case 'pin_change':
                header("Location: acc_typePin.php");
                break;
            case 'mini_statement':
                header("Location: acc_typeMs.php");
                break;
            default:
            
                header("Location: default_page.php");
        }
        exit();
    } else {
        
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
        .heading{
            text-align:center;
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
        } 
         #st{color: blueviolet;
            box-shadow:5px 5px 5px green;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            flex-direction: row; 
        }

        .btn1,
        .btn2 {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-primary {
            justify-content: center;
            background-color: #3498db;
            border: none;
            font-size: 20px;
            border-radius: 100px;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
            margin-top: 40px;
        }

        .btn-container .btn-primary {
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
           <div class="heading"><h2 class="mb-4"><strong>Dear Customer, Please <span id="st">Select Transaction<strong></span></h2></div>
           <form action="" method="POST">
               <div class="btn-container">
                   <div class="btn1">
                       <button type="submit" class="btn btn-primary" name="transaction" value="withdrawal"><strong>Withdrawal</strong></button>
                       
                       <button type="submit" class="btn btn-primary dep" name="transaction" value="deposit"><strong>Deposit</strong></button>
                        <button type="submit" class="btn btn-primary" name="transaction" value="balance_enquiry"><strong>Balance Enquiry</strong></button> 
                   </div>
                   <div class="btn2">
                       <button type="submit" class="btn btn-primary" name="transaction" value="pin_change"><strong>PIN Change</strong></button>
                       <button type="submit" class="btn btn-primary" name="transaction" value="mini_statement"><strong>Mini Statement</strong></button>
                   </div>
               </div>
           </form>
       </div>
  </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    
</body>
</html>
