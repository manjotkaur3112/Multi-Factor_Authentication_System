<?php
/**
 * Email Configuration Test Script
 * Run this to verify your Gmail setup before using the system
 * Access via: http://localhost/Multi-Factor_Authentication_System/test_email.php
 */

include_once 'config/db.php';
include_once 'config/mail_config.php';
include_once 'includes/functions.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Configuration Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .status { padding: 15px; border-radius: 5px; margin: 10px 0; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        h1 { color: #333; }
        form { background: #f5f5f5; padding: 20px; border-radius: 5px; }
        input { padding: 10px; margin: 10px 0; width: 100%; box-sizing: border-box; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .config-check { margin: 20px 0; }
        code { background: #f5f5f5; padding: 5px 10px; border-radius: 3px; }
    </style>
</head>
<body>

<h1>📧 Email Configuration Test</h1>

<?php
// Check 1: Mail config exists
echo '<div class="config-check">';
echo '<h3>1. Configuration File</h3>';
if (isset($mail_config)) {
    if ($mail_config['username'] === 'your-email@gmail.com') {
        echo '<div class="status warning">⚠️ Configuration not updated yet.</div>';
        echo '<p>Please edit <code>config/mail_config.php</code> with your Gmail credentials.</p>';
    } else {
        echo '<div class="status success">✅ Configuration file found and updated.</div>';
        echo '<p>📧 Email: ' . htmlspecialchars($mail_config['from_email']) . '</p>';
    }
} else {
    echo '<div class="status error">❌ Configuration file not found.</div>';
}
echo '</div>';

// Check 2: PHPMailer installed
echo '<div class="config-check">';
echo '<h3>2. PHPMailer Installation</h3>';
if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
    echo '<div class="status success">✅ PHPMailer is properly installed.</div>';
} else {
    echo '<div class="status error">❌ PHPMailer not found. Run: <code>composer install</code></div>';
}
echo '</div>';

// Check 3: Database connection
echo '<div class="config-check">';
echo '<h3>3. Database Connection</h3>';
if ($conn && !$conn->connect_error) {
    echo '<div class="status success">✅ Database connected successfully.</div>';
} else {
    echo '<div class="status error">❌ Database connection failed.</div>';
}
echo '</div>';

// Test email sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_email'])) {
    $test_email = htmlspecialchars(trim($_POST['email']));
    
    echo '<div class="config-check">';
    echo '<h3>4. Sending Test Email</h3>';
    
    if (filter_var($test_email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="status info">ℹ️ Attempting to send test OTP...</div>';
        
        $test_otp = '123456';
        
        if (sendEmailOTP($test_email, $test_otp, 'Test OTP - Configuration Verification')) {
            echo '<div class="status success">✅ Email sent successfully!</div>';
            echo '<p>📧 Sent to: ' . htmlspecialchars($test_email) . '</p>';
            echo '<p>Check your inbox (and spam folder) within 30 seconds.</p>';
        } else {
            echo '<div class="status error">❌ Failed to send email.</div>';
            echo '<p>Check:</p>';
            echo '<ul>';
            echo '<li>Gmail credentials in <code>config/mail_config.php</code></li>';
            echo '<li>Gmail App Password is correct (16 characters)</li>';
            echo '<li>Internet connection is working</li>';
            echo '<li>Gmail account has 2-Factor Authentication enabled</li>';
            echo '</ul>';
        }
    } else {
        echo '<div class="status error">❌ Invalid email address.</div>';
    }
    echo '</div>';
}
?>

<div class="config-check">
    <h3>4. Send Test Email</h3>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email to test" required>
        <button type="submit" name="test_email">Send Test OTP</button>
    </form>
</div>

<div class="config-check" style="background: #f0f8ff; padding: 15px; border-radius: 5px;">
    <h3>📝 Quick Setup Checklist</h3>
    <ul>
        <li>✓ Gmail 2-Factor Authentication enabled?</li>
        <li>✓ App Password generated from Google Account?</li>
        <li>✓ <code>config/mail_config.php</code> updated with Gmail & App Password?</li>
        <li>✓ <code>composer install</code> run to install PHPMailer?</li>
        <li>✓ Test email received in inbox?</li>
    </ul>
    <p><a href="../EMAIL_SETUP_GUIDE.md" style="color: blue;">📖 Read Full Setup Guide</a></p>
</div>

<hr>
<p style="color: #666; font-size: 12px;">
    <strong>Note:</strong> Delete this test file (<code>test_email.php</code>) after verifying emails work.
</p>

</body>
</html>
