# PHP Login System

A simple and secure PHP login system with user registration and authentication.

## 🚀 Features

- ✅ User registration with validation
- ✅ Secure password hashing
- ✅ Login authentication
- ✅ Session management
- ✅ Protected pages
- ✅ Logout functionality
- ✅ Responsive design

## 📋 Requirements

- XAMPP (Apache + MySQL + PHP)
- Web browser
- Text editor

## 🛠️ Installation

1. **Download and install XAMPP**
   - Go to https://www.apachefriends.org/
   - Download and install XAMPP
   - Start Apache and MySQL services

2. **Set up the project**
   - Clone this repository to your XAMPP htdocs folder:
     ```
     git clone https://github.com/yourusername/php-login-system.git
     ```
   - Or download and extract the ZIP file

3. **Create the database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `login_system`
   - Run this SQL command:
     ```sql
     CREATE TABLE users (
         id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
         username VARCHAR(50) NOT NULL UNIQUE,
         email VARCHAR(100) NOT NULL UNIQUE,
         password VARCHAR(255) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     );
     ```

4. **Configure database connection**
   - Open `config.php`
   - Update database credentials if needed (default should work with XAMPP)

5. **Access the application**
   - Open your browser
   - Go to `http://localhost/php-login-system/`

## 🎯 Usage

1. **Register a new account:**
   - Go to `register.php`
   - Fill in the registration form
   - Click "Sign Up"

2. **Login:**
   - Go to `login.php`
   - Enter your credentials
   - Click "Login"

3. **Access dashboard:**
   - After login, you'll be redirected to `welcome.php`
   - This page is protected and requires authentication

4. **Logout:**
   - Click "Sign Out" button
   - You'll be redirected to login page

## 📁 File Structure
php-login-system/
├── config.php          # Database configuration
├── register.php        # User registration page
├── login.php           # User login page
├── welcome.php         # Protected dashboard
├── logout.php          # Logout handler
└── README.md           # Documentation

## 🔒 Security Features

- **Password Hashing:** Uses PHP's `password_hash()` function
- **SQL Injection Protection:** Prepared statements
- **Session Management:** Secure session handling
- **Input Validation:** Server-side validation
- **Access Control:** Protected pages require authentication

## 🧪 Testing

Test the following scenarios:

- [ ] Registration with valid data
- [ ] Registration with invalid data (empty fields, short password, etc.)
- [ ] Login with correct credentials
- [ ] Login with incorrect credentials
- [ ] Access protected page without login
- [ ] Logout functionality
- [ ] Session persistence

## 📸 Screenshots

### Registration Page
![Registration Page](screenshots/register.png)

### Login Page
![Login Page](screenshots/login.png)

### Dashboard
![Dashboard](screenshots/welcome.png)

## 🎥 Demo Video

[Watch the demo video](your-video-link-here)

## 📚 Learning Resources

- [PHP Manual](https://www.php.net/manual/en/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Git Documentation](https://git-scm.com/doc)

## 👨‍💻 Author

Your Name - [your.email@example.com](mailto:your.email@example.com)

## 📄 License

This project is for educational purposes.