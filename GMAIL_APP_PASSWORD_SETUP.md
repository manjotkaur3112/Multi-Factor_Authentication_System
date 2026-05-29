# 📧 Gmail App Password Setup - Detailed Steps

## What is a Gmail App Password?
A Gmail App Password is a 16-character password that allows third-party applications (like your PHP mailer) to send emails from your Gmail account securely without exposing your actual Gmail password.

---

## Step-by-Step Instructions

### **Step 1: Verify 2-Factor Authentication is Enabled**

1. Open your browser and go to: https://myaccount.google.com/security
2. Sign in with **kourmanjot13@gmail.com**
3. Look for **"2-Step Verification"** in the left sidebar
4. **If already enabled**: Skip to Step 2
5. **If NOT enabled**:
   - Click "2-Step Verification"
   - Click "Get Started"
   - Follow Google's prompts (you'll need your phone)
   - Confirm a verification code sent to your phone
   - Complete the setup

> ⚠️ **Important:** App Passwords only work if 2-Factor Authentication is enabled!

---

### **Step 2: Generate App Password**

1. Go to: https://myaccount.google.com/security
2. Sign in with **kourmanjot13@gmail.com** (if not already signed in)
3. Scroll down and find **"App passwords"**
   - *If you don't see this option, 2FA is not enabled (go back to Step 1)*
4. Click on **"App passwords"**
5. You'll see a dropdown with two options:
   - Select **Device type**: Choose "Windows Computer" (or your device)
   - Select **App type**: Choose "Mail"
6. Click **"Generate"**

---

### **Step 3: Copy the App Password**

1. Google will display a **16-character password** in a popup box
   - Example: `wxyz abcd efgh ijkl`
2. **IMPORTANT**: Copy this password exactly as shown (including spaces)
3. Click **"Done"**

---

### **Step 4: Update the Config File**

1. Open this file: `config/mail_config.php`
2. Find this line:
   ```php
   'password' => 'your-app-password-here', // Use Gmail App Password
   ```
3. Replace `'your-app-password-here'` with your 16-character app password
4. **Example:**
   ```php
   'password' => 'wxyz abcd efgh ijkl', // Paste exactly as provided by Google
   ```
5. **Save the file** (Ctrl+S)

---

### **Step 5: Verify the Setup Works**

1. Open your browser and go to:
   ```
   http://localhost/Multi-Factor_Authentication_System/test_email.php
   ```
2. Enter your test email address
3. Click **"Send Test OTP"**
4. Check your inbox (wait 5-10 seconds)
5. You should receive an email with subject: **"Test OTP - Configuration Verification"**
6. If successful, the test page will show: ✅ **Email sent successfully!**

---

## ✅ Troubleshooting

| Problem | Solution |
|---------|----------|
| **"App passwords" option not showing** | 2-Factor Authentication is not enabled. Go back to Step 1 |
| **"Authentication failed" error** | The app password might be incorrect. Generate a new one and try again |
| **Email still not received** | Check your spam/junk folder. Gmail might have flagged it |
| **"Connection timeout" error** | Check internet connection or your firewall settings |

---

## 🔐 Security Best Practices

✅ **DO:**
- Keep the app password secure
- Use different app passwords for different applications
- Never share your app password with anyone

❌ **DON'T:**
- Commit this file to GitHub with real credentials
- Share your app password via email or chat
- Use your regular Gmail password here (app password is more secure)

---

## After Setup is Complete

Once emails are working:

1. **Delete the test file**: Remove `test_email.php` from your project
2. **Try the system**:
   - Register a new account → Should receive OTP
   - Login → Should receive OTP
   - Forgot Password → Should receive reset link

---

## Additional Notes

- Each app password can be used on multiple devices
- You can revoke any app password from the same Google Account Security page if needed
- App passwords are unique per Google account and application combination

**If you need further help, screenshot the error message and check the test_email.php page for detailed debug information!** 🎉
