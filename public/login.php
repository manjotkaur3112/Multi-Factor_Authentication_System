
<?php 
include_once '../includes/functions.php';
include('../config/db.php');
include('../includes/log_action.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Secure Auth</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg: #eef4ff;
            --card: #ffffff;
            --text: #1f2937;
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
            background: linear-gradient(135deg, #e6f0ff 0%, #f8fbff 45%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text);
        }

        .page-wrap {
            width: 100%;
            max-width: 920px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
            align-items: center;
        }

        .brand-panel {
            padding: 40px 35px;
            border-radius: 32px;
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.18);
        }

        .brand-panel h1 {
            margin: 0 0 16px;
            font-size: 2.8rem;
            line-height: 1.05;
        }

        .brand-panel p {
            margin: 0 0 24px;
            color: rgba(255,255,255,0.86);
            font-size: 1rem;
            line-height: 1.8;
        }

        .brand-panel .feature {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            align-items: flex-start;
        }

        .brand-panel .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: rgba(255,255,255,0.18);
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .brand-panel .feature-text {
            font-size: 0.96rem;
            color: rgba(255,255,255,0.92);
        }

        .login-card {
            background: var(--card);
            border-radius: 32px;
            padding: 42px 36px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .login-card h2 {
            margin: 0 0 10px;
            font-size: 2rem;
            letter-spacing: -0.03em;
        }

        .login-card p.subtitle {
            margin: 0 0 28px;
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

        .login-card .link-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 22px;
            flex-wrap: wrap;
        }

        .login-card a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-card a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .page-wrap {
                grid-template-columns: 1fr;
                gap: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <section class="brand-panel">
            <h1>Secure Authentication</h1>
            <p>Fast login, secure verification, and easy account access. Sign in and get started with your secure session.</p>
            <div class="feature">
                <div class="feature-icon">✓</div>
                <div class="feature-text">OTP verification for all sign-ins</div>
            </div>
            <div class="feature">
                <div class="feature-icon">🔒</div>
                <div class="feature-text">Strong security and safe sessions</div>
            </div>
            <div class="feature">
                <div class="feature-icon">✨</div>
                <div class="feature-text">Modern dashboard experience</div>
            </div>
        </section>

        <section class="login-card">
            <h2>Welcome Back</h2>
            <p class="subtitle">Login with your email and password to continue. A verification OTP will be sent to your inbox.</p>
            <form method="POST" action="../includes/auth.php">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button class="btn-primary" type="submit" name="login">Login</button>
            </form>
            <div class="link-row">
                <a href="forgot_password.php">Forgot Password?</a>
                <a href="register.php">Create new account</a>
            </div>
        </section>
    </div>
</body>
</html>