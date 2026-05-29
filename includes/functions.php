
<?php
include_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sanitize($data) {
    return htmlspecialchars(trim($data));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function isStrongPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

if (!function_exists('generateOTP')) {
    function generateOTP($length = 6) {
        return strval(rand(pow(10, $length - 1), pow(10, $length) - 1));
    }
}

function sendEmailOTP($to, $otp, $subject = "OTP Verification") {
    if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        echo "<p style='color:red;'>❌ PHPMailer not found. Check composer autoload.</p>";
        return false;
    }

    try {
        // Load mail configuration
        $mail_config = include __DIR__ . '/../config/mail_config.php';
        
        // Validate configuration
        if (empty($mail_config['username']) || $mail_config['username'] === 'your-email@gmail.com') {
            echo "<p style='color:red;'>❌ Email not configured. Update config/mail_config.php with your Gmail and App Password.</p>";
            return false;
        }

        $mail = new PHPMailer(true);

        // Enable debugging if needed
        if ($mail_config['debug']) {
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function($str, $level) {
                echo '<pre style="color:#333; background:#f4f4f4; padding:8px; border-radius:4px;">' . htmlspecialchars($str) . '</pre>';
            };
        }

        $mail->isSMTP();
        $mail->Host = $mail_config['smtp_host'];
        $mail->SMTPAuth = $mail_config['smtp_auth_enabled'];
        $mail->Username = $mail_config['username'];
        $mail->Password = str_replace(' ', '', $mail_config['password']);
        
        // Set encryption method
        if (strtolower($mail_config['smtp_secure']) === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $mail_config['smtp_port'];
        }

        $mail->setFrom($mail_config['from_email'], $mail_config['from_name']);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>🔐 Email Verification</h3>
            <p>Your One-Time Password (OTP) is:</p>
            <h2 style='color:#0078D4;'>$otp</h2>
            <p><strong>Valid for 10 minutes.</strong></p>
            <p style='font-size: 12px; color: #999;'>If you didn't request this, please ignore this email.</p>
        ";

        $mail->send();
        echo "<p style='color:green;'>✅ OTP sent successfully to {$to}</p>";
        return true;
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Mailer Error: {$e->getMessage()}</p>";
        if (isset($mail)) {
            echo "<p style='color:red;'>Details: {$mail->ErrorInfo}</p>";
        }
        return false;
    }
}
?>
