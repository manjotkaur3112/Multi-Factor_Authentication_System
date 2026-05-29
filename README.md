Secure Autentication Module For OS

📌 Project Overview :- 
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

🚀 Deploy on Railway
1. Create a new project on [Railway](https://railway.app).
2. Connect your GitHub repository.
3. Add a MySQL database service in Railway.
4. Set the following environment variables:
   - `DB_HOST` → Railway MySQL hostname
   - `DB_DATABASE` → `secure_auth`
   - `DB_USER` → Railway MySQL user
   - `DB_PASSWORD` → Railway MySQL password
   - `SMTP_HOST` → `smtp.gmail.com` (or your provider)
   - `SMTP_PORT` → `587`
   - `SMTP_SECURE` → `tls`
   - `SMTP_AUTH_ENABLED` → `true`
   - `MAIL_FROM_ADDRESS` → Your email
   - `MAIL_FROM_NAME` → `Secure Authentication System`
   - `SMTP_USERNAME` → Your Gmail/SMTP username
   - `SMTP_PASSWORD` → Your Gmail App Password
   - `MAIL_DEBUG` → `false`
5. Railway will auto-detect the `Dockerfile` and deploy automatically.
6. The app will be live at your Railway URL.

🚀 Deploy on Render
1. Create a new Render Web Service from this repository.
2. Use the `php` environment.
3. Set the build command to `composer install`.
4. Set the start command to `php -S 0.0.0.0:$PORT -t public`.
5. Create a managed MySQL database in Render or a separate MySQL service.
6. Add the following environment variables in Render:
   - `DB_HOST`
   - `DB_DATABASE`
   - `DB_USER`
   - `DB_PASSWORD`
   - `SMTP_HOST`
   - `SMTP_PORT`
   - `SMTP_SECURE`
   - `SMTP_AUTH_ENABLED`
   - `MAIL_FROM_ADDRESS`
   - `MAIL_FROM_NAME`
   - `SMTP_USERNAME`
   - `SMTP_PASSWORD`
   - `MAIL_DEBUG`
7. Point Render to the `public` folder as the web root using the start command above.

