<?php 
include_once '../includes/functions.php';
include('../config/db.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Register | Secure Auth</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg: #eef4ff;
            --card: #ffffff;
            --text: #111827;
            --muted: #475569;
            --border: #dbeafe;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f8ff 0%, #eef6ff 45%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text);
        }

        .page-wrap {
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 28px;
            align-items: center;
        }

        .info-panel {
            padding: 38px 38px 36px;
            border-radius: 32px;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.08);
        }

        .info-panel h1 {
            margin: 0 0 16px;
            font-size: 2.6rem;
        }

        .info-panel p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.8;
            font-size: 1rem;
        }

        .info-panel .feature {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .info-panel .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
            font-weight: 700;
        }

        .info-panel .feature-text {
            font-size: 0.98rem;
            color: var(--text);
        }

        .register-card {
            background: var(--card);
            border-radius: 32px;
            padding: 40px 38px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .register-card h2 {
            margin: 0 0 10px;
            font-size: 2rem;
        }

        .register-card p.subtitle {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.7;
        }

        .input-group {
            display: grid;
            gap: 10px;
            margin-bottom: 18px;
        }

        label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--muted);
        }

        input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 1rem;
            color: var(--text);
            background: #f8fbff;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 16px;
            background: var(--primary);
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .note {
            margin: 12px 0 18px;
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <section class="info-panel">
            <h1>Create your account</h1>
            <p>Join the secure authentication system as a verified user. Your account will be protected with strong password rules and OTP verification during signup.</p>
            <div class="feature">
                <div class="feature-icon">✓</div>
                <div class="feature-text">Secure registration with OTP validation</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🔐</div>
                <div class="feature-text">Password strength enforcement for safer login</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🚀</div>
                <div class="feature-text">Fast access to your user dashboard</div>
            </div>
        </section>

        <section class="register-card">
            <h2>Create account</h2>
            <p class="subtitle">Register with your details and receive an OTP to verify your email address.</p>
            <form method="POST" action="../includes/auth.php" onsubmit="return validatePassword();">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" required>
                </div>
                <input type="hidden" name="role" value="user">
                <p class="note">New registrations are created as <strong>User</strong> accounts only. Admin access is reserved for the fixed admin email.</p>
                <button class="btn-primary" type="submit" name="register">Register</button>
            </form>
            <div class="login-link">
                <p>Already registered? <a href="login.php">Login here</a></p>
            </div>
        </section>
    </div>

    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!pattern.test(password)) {
                alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
                return false;
            }

            if (password !== confirm) {
                alert('Passwords do not match!');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
