<?php
require_once("configatm.php");
session_start();
if (!isset($_SESSION['user'])) {

    header("Location: login_page.php");
    exit();
}

$user = $_SESSION['user'];
$queryBalance = mysqli_query($conn, "SELECT holder_name, acc_num, phn_num, balance FROM users WHERE userid='$user'");
$rowBalance = mysqli_fetch_assoc($queryBalance);

$queryTransactions = mysqli_query($conn, "SELECT trans_type, Amount,create_date_time FROM trans_db WHERE user_id='$user' ORDER BY create_date_time DESC LIMIT 10");
$rowsTransactions = mysqli_fetch_all($queryTransactions, MYSQLI_ASSOC);
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            font-size: 14px;
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
            margin-top:-10px;
         }
         #st{color: blueviolet;
            box-shadow:5px 5px 5px green;
        }
        h2 p{
            font-size: 25px;
            color: #333333;
            text-align: center;
        }
        h3{
            text-align:center;
        }
        .table-container {
         max-height: 200px; 
         overflow-y: auto;
        }
        table {
        width: 100%;
       
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
        }

        .btn-primary {
            width: 180px;
            background-color: #3498db;
            border: none;
            margin-left:600px;
            margin-top:-35px;
            font-size: 20px;
            border-radius: 100px;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
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
            <h2 class="mb-4"><strong>Bank<span id="st"> Statement</strong></span></h2>
            <p>Account Holder Name: <?php echo isset($rowBalance['holder_name']) ? $rowBalance['holder_name'] : 'N/A'; ?></p>
            <p>Account Number: <?php echo isset($rowBalance['acc_num']) ? $rowBalance['acc_num'] : 'N/A'; ?></p>
            <p>Phone Number: <?php echo isset($rowBalance['phn_num']) ? $rowBalance['phn_num'] : 'N/A'; ?></p>
            <p>Your current balance: <?php echo isset($rowBalance['balance']) ? 'Rs ' . $rowBalance['balance'] : 'N/A'; ?></p>
            
           
            <h3><strong>Last Transactions:</strong></h3>
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rowsTransactions as $transaction) : ?>
                            <tr >
                                <td><?php echo $transaction['trans_type']; ?></td>
                                <td><?php echo $transaction['Amount']; ?></td>
                                <td><?php echo $transaction['create_date_time']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <div class="d-flex">
                <button type="submit" class="btn btn-primary" id="save" name="save" onclick="redirectToAccTypePage()"><strong>Ok</strong></button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
       <script>
        function redirectToAccTypePage() {
            window.location.href = "transaction_menu.php";
        }
    </script> 
</body>
</html>
