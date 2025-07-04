<?php
require_once "config.php";

// Initialize variables
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Process form when submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Check if username already exists
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter a valid email address.";
    } else{
        // Check if email already exists
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Insert new user into database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
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
    <title>Sign Up - Create Your Account</title>
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
        
        .error-message {
            color: #DC2626;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            background: #FEF2F2;
            border-left: 3px solid #DC2626;
        }
        
        .password-strength {
            margin-top: 12px;
            font-size: 13px;
            color: #4B5563;
        }
        
        .strength-bar {
            height: 4px;
            background: #E5E7EB;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { 
            background: #DC2626;
            width: 33%;
        }
        
        .strength-medium { 
            background: #F59E0B;
            width: 66%;
        }
        
        .strength-strong { 
            background: #10B981;
            width: 100%;
        }
        
        .btn-group {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }
        
        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        
        .btn-primary {
            background: #1A73E8;
            color: #FFFFFF;
        }
        
        .btn-primary:hover {
            background: #1669C1;
        }
        
        .btn-secondary {
            background: #DC2626;
            color: #FFFFFF;
        }
        
        .btn-secondary:hover {
            background: #B91C1C;
        }
        
        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #E5E7EB;
        }
        
        .login-link p {
            color: #4B5563;
            font-size: 15px;
            margin-bottom: 8px;
        }
        
        .login-link a {
            color: #1A73E8;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s ease;
        }
        
        .login-link a:hover {
            color: #1669C1;
        }
        
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                border-radius: 12px;
            }
            
            .form-container {
                padding: 24px;
            }
            
            .btn-group {
                flex-direction: column;
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
            <h2>Create Your Account</h2>
            <p>Join our community today</p>
        </div>
        
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registrationForm">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo htmlspecialchars($username); ?>" placeholder="Enter your username">
                        <i class="fas fa-user"></i>
                    </div>
                    <?php if(!empty($username_err)): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $username_err; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email address">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <?php if(!empty($email_err)): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $email_err; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" 
                               placeholder="Create a strong password" id="password">
                        <i class="fas fa-lock"></i>
                    </div>
                    <?php if(!empty($password_err)): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $password_err; ?>
                        </div>
                    <?php endif; ?>
                    <div class="password-strength" id="passwordStrength" style="display: none;">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span id="strengthText"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" 
                               placeholder="Confirm your password" id="confirmPassword">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <?php if(!empty($confirm_password_err)): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $confirm_password_err; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
            
            <div class="login-link">
                <p>Already have an account?</p>
                <a href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </a>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');
            
            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }
            
            strengthDiv.style.display = 'block';
            
            let strength = 0;
            let text = '';
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthFill.className = 'strength-fill';
            if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
                text = 'Weak - Add more characters';
            } else if (strength <= 4) {
                strengthFill.classList.add('strength-medium');
                text = 'Medium - Add special characters';
            } else {
                strengthFill.classList.add('strength-strong');
                text = 'Strong - Perfect!';
            }
            
            strengthText.textContent = text;
        });
        
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value === password) {
                this.style.borderColor = '#10B981';
            } else {
                this.style.borderColor = '#DC2626';
            }
        });
    </script>
</body>
</html>