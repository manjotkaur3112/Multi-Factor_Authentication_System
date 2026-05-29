Secure Autentication Module For OS

📌 Project Overview 
The Secure Authentication Module for Operating Systems enhances system security by verifying user identity, managing login sessions, and preventing unauthorized access. It supports password encryption, OTP-based multi-factor authentication, and admin-controlled account management. This module ensures safe authentication, quick recovery in case of compromise, and efficient monitoring of user activity at the OS level.

🎯 Features
- ✅ OTP-based authentication for admin and users
- 🪪 Role-based access management
- 🛡 Strong password rule enforcement
- 🔐 Secure session with multi-device check
- ⚠ Compromise reporting workflow
- 📧 PHPMailer integration for emails
- 🗄 Easy database setup via SQL
- ⚙ Quick deployment (XAMPP/WAMP support)
- 📝 Full documentation in README.txt

⚙ Setup Instructions
1. Place the project folder inside your htdocs directory.
2. Import database.sql using phpMyAdmin.
3. Edit SQL credentials in config/db.php.
4. Change default admin password immediately:  
   admin@example.com / Admin@123
5. For emails, run composer install and update SMTP details in includes/functions.php.


🚀 Usage
- Login as admin or user via the login page.
- If a security issue is detected, click "Report Unauthorized Access."
- Admin receives the report and can block the suspicious account.

 🛠 Technology Used
- PHP (≥7.x)
- MySQL / MariaDB
- PHPMailer
- HTML, CSS, JS
- XAMPP / WAMP
