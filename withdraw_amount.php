<?php
require_once("configatm.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST["amount"];
    $user = $_SESSION['user'];

    // Validate amount
    if ($amount == 0 || $amount % 100 == 0 || $amount % 500 == 0 || $amount % 2000 == 0 || $amount % 200 == 0) {
        $atmBalanceQuery = mysqli_query($conn, "SELECT atm_bal FROM atm_blnc WHERE atm_status='1'");
        $atmBalanceRow = mysqli_fetch_assoc($atmBalanceQuery);

        $userBalanceQuery = mysqli_query($conn, "SELECT balance FROM users WHERE userid='$user'");
        $userBalanceRow = mysqli_fetch_assoc($userBalanceQuery);

        if ($atmBalanceRow && $userBalanceRow) {
            $atmBalance = $atmBalanceRow['atm_bal'];
            $userBalance = $userBalanceRow['balance'];

            if ($atmBalance >= $amount && $userBalance >= $amount) {
                $newAtmBalance = $atmBalance - $amount;
                $newUserBalance = $userBalance - $amount;

                mysqli_begin_transaction($conn);

                $updateAtmQuery = mysqli_query($conn, "UPDATE atm_blnc SET atm_bal='$newAtmBalance' WHERE atm_status='1'");

                $updateUserBalanceQuery = mysqli_query($conn, "UPDATE users SET balance='$newUserBalance' WHERE userid='$user'");
                $insertTransactionQuery = mysqli_query($conn, "INSERT INTO trans_db (user_id, trans_type, Amount) VALUES ('$user', 'withdrawal', '$amount')");

                if ($updateAtmQuery && $updateUserBalanceQuery && $insertTransactionQuery) {
                    mysqli_commit($conn);

                    echo "<script>
                            setTimeout(function() {
                                Swal.fire({
                                    title: 'Withdrawal successful!',
                                    icon: 'success',
                                }).then(function() {
                                    window.location.href='available_blnc.php';
                                });
                            }, 500);
                          </script>";
                } 
                else {
                    mysqli_rollback($conn);

                    echo "<script>
                            setTimeout(function() {
                                Swal.fire({
                                    title: 'Transaction failed!',
                                    icon: 'error',
                                });
                            }, 500);
                          </script>";
                }
            } else {
                echo "<script>
                        setTimeout(function() {
                            Swal.fire({
                                title: 'Insufficient ATM balance or user funds!',
                                icon: 'warning',
                            }).then(function() {
                                window.location.href='withdraw_amount.php';
                            });
                        }, 500);
                      </script>";
            }
        } else {
            echo "<script>
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Error retrieving balance!',
                            icon: 'error',
                        });
                    }, 500);
                  </script>";
        }
    } else {
        echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Available notes are 100, 200, 500, 2000!',
                        icon: 'error',
                    });
                }, 500);
              </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
    .note{
        text-align:center;
    }
    .imgdiv{
        margin-top:50px;
            width:300px;
            margin-left:135px;
            background-color:lightgray;
            font-size:25px;


    }
    .form-control {
            width: 50%;
            padding: 10px 5px;
            margin-top: -5px;
            margin-left:195px;
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
            .btn1{
            padding:50px;
            margin-top:-10px;
            float:right;
            }
      


        .btn-primary {
        

            justify-content: center;
            background-color: #3498db;
            border: none;
            font-size: 20px;
            border-radius: 100px;
            box-shadow: 0 10px 20px rgba(77, 199, 255, 0.4);
            margin-top: 30px;
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
                <h2 class="mb-4"><strong>Please Enter<span id="st"> Account<strong></span></h2>
                <p class="note">Cash Available: Rs100, Rs200, Rs500, Rs2000</p>
            </div>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div class="btn-container">
                    <div class="mb-3">
                        <div class="imgdiv"></div>
                        <input type="number" class="form-control" id="amount" name="amount" value="Rs " placeholder="Enter amount" required >
                    </div>
                    <div class="btn1">
                        <button type="submit" class="btn btn-primary btnl" ><strong>Ok</strong></button><br>
                        <button type="button" class="btn btn-primary btns" onclick="redirectToAmountPage()"><strong>Cancel</strong></button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
    function validateForm() {
        var amountInput = document.getElementById("amount").value;
        if (amountInput % 100 !== 0 || amountInput == 0 ) {
        
            Swal.fire('Invalid Amount', 'Please enter a valid amount (in multiples of 100).', 'error');
                return false;
           
        }

        return true;
    }

    function redirectToAmountPage() {
        document.getElementById("amount").value = "";
        window.location.href = "withdraw_amount.php";
    }
</script>
</body>
</html>
