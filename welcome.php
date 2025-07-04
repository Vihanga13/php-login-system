<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F4F6F8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .wrapper {
            max-width: 600px;
            width: 100%;
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wrapper:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .header {
            background: #1A73E8;
            color: #FFFFFF;
            padding: 32px;
            text-align: center;
            position: relative;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 12px;
            color: #FFFFFF;
        }

        .header p {
            font-size: 16px;
            opacity: 0.95;
            margin: 0;
        }

        .content {
            padding: 32px;
        }

        .welcome-message {
            text-align: center;
            color: #4B4B4B;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .user-info {
            background: #FAFAFA;
            border: 1px solid #D1D5DB;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .user-info h3 {
            color: #2E2E2E;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 12px;
            background: #FFFFFF;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item i {
            color: #1A73E8;
            font-size: 18px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .info-item strong {
            color: #2E2E2E;
            margin-right: 8px;
        }

        .info-item span {
            color: #4B4B4B;
        }

        .btn-container {
            text-align: center;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #1A73E8;
            color: #FFFFFF;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: #1669C1;
        }

        .logout-btn i {
            margin-right: 8px;
        }

        @media (max-width: 480px) {
            .wrapper {
                margin: 10px;
                border-radius: 12px;
            }

            .content {
                padding: 24px;
            }

            .header {
                padding: 24px;
            }

            .header h1 {
                font-size: 24px;
            }

            .user-info {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p>You've successfully logged into your account</p>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <p>It's great to have you here! Your account is now active and ready to use.</p>
            </div>
            
            <div class="user-info">
                <h3>Account Information</h3>
                <div class="info-item">
                    <i class="fas fa-fingerprint"></i>
                    <strong>User ID:</strong>
                    <span><?php echo $_SESSION["id"]; ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user"></i>
                    <strong>Username:</strong>
                    <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                </div>
            </div>
            
            <div class="btn-container">
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Sign Out
                </a>
            </div>
        </div>
    </div>
</body>
</html>