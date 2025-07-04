<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
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
        
        .container {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .container:hover {
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
        
        .header h2 {
            font-size: 28px;
            margin-bottom: 12px;
            font-weight: 600;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.95;
        }
        
        .form-container {
            padding: 35px;
            background: #FFFFFF;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 8px;
        }
        
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #1A73E8;
            font-size: 18px;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
            background: #FAFAFA;
            color: #2E2E2E;
            position: relative;
            z-index: 1;
        }
        
        .form-control::placeholder {
            color: #4B5563;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #1A73E8;
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.12);
        }
        
        .alert {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }
        
        .alert i {
            margin-right: 12px;
            font-size: 16px;
        }
        
        .invalid-feedback {
            color: #DC2626;
            font-size: 13px;
            margin-top: 6px;
            display: block;
            padding-left: 12px;
        }
        
        .btn {
            width: 100%;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            background: #1A73E8;
            color: #FFFFFF;
            margin-top: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn:hover {
            background: #1669C1;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #E5E7EB;
            color: #4B5563;
        }
        
        .register-link a {
            display: inline-flex;
            align-items: center;
            color: #1A73E8;
            text-decoration: none;
            font-weight: 500;
            margin-top: 8px;
            transition: color 0.2s ease;
        }
        
        .register-link a:hover {
            color: #1669C1;
        }
        
        .register-link a i {
            margin-right: 8px;
        }
        
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                border-radius: 12px;
            }
            
            .form-container {
                padding: 24px;
            }
            
            .header {
                padding: 24px;
            }
            
            .header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome Back</h2>
            <p>Sign in to your account</p>
        </div>
        
        <div class="form-container">
            <?php
            if(!empty($login_err)){
                echo '<div class="alert"><i class="fas fa-exclamation-circle"></i>' . $login_err . '</div>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Username">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
                        <i class="fas fa-lock"></i>
                    </div>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>
            
            <div class="register-link">
                <p>Don't have an account?</p>
                <a href="register.php">
                    <i class="fas fa-user-plus"></i>
                    Create an Account
                </a>
            </div>
        </div>
    </div>
</body>
</html>