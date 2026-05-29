# 📧 Email Setup Guide for Gmail OTP

## Problem
The OTP emails were not being sent because the Gmail credentials were:
- Hardcoded in the source code (security issue)
- Potentially expired or revoked app password

## Solution: Generate Gmail App Password

Follow these steps to enable OTP emails:

### Step 1: Enable 2-Factor Authentication (if not already enabled)
1. Go to [Google Account Security](https://myaccount.google.com/security)
2. Click "2-Step Verification" on the left menu
3. Follow the prompts to enable 2FA

### Step 2: Generate Gmail App Password
1. Go to [Google Account Security](https://myaccount.google.com/security)
2. Look for "App passwords" (appears only if 2FA is enabled)
3. Select:
   - **App**: Mail
   - **Device**: Windows Computer (or your device)
4. Click "Generate"
5. Copy the **16-character app password** (with spaces)

### Step 3: Update Configuration
1. Open `config/mail_config.php`
2. Replace these values:
   ```php
   'from_email' => 'your-email@gmail.com',    // Your Gmail address
   'username' => 'your-email@gmail.com',      // Your Gmail address
   'password' => 'your-app-password-here',    // Paste the 16-char app password
   ```

**Example:**
```php
'from_email' => 'myaccount@gmail.com',
'username' => 'myaccount@gmail.com',
'password' => 'wxyz abcd efgh ijkl',  // Paste exactly as provided by Google
```

### Step 4: Test the Configuration
1. Try registering with a new account
2. You should receive OTP email within seconds
3. Check spam folder if not in inbox

## ✅ Troubleshooting

| Issue | Solution |
|-------|----------|
| "OTP not sent" | Check if config/mail_config.php has correct Gmail & app password |
| "Connection timeout" | Verify internet connection and SMTP port 587 is not blocked |
| Email in spam | Add your sender email to contacts |
| "App password rejected" | Generate a NEW app password - old one might be expired |

## 🔐 Security Notes
- Never commit `config/mail_config.php` with real credentials to GitHub
- Add it to `.gitignore`: `echo "config/mail_config.php" >> .gitignore`
- For production, use environment variables instead

## ⚙️ Alternative: Other Email Providers

To use Outlook, SendGrid, or other providers, update `config/mail_config.php`:

**Outlook/Office365:**
```php
'smtp_host' => 'smtp-mail.outlook.com',
'smtp_port' => 587,
'smtp_secure' => 'tls',
```

**SendGrid:**
```php
'smtp_host' => 'smtp.sendgrid.net',
'smtp_port' => 587,
'username' => 'apikey',
'password' => 'SG.your_sendgrid_api_key',
```

---
**After updating `config/mail_config.php`, OTP emails should work immediately!** 🎉
