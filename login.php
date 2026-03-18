<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:      #1e3a5f;
            --navy-dark: #132840;
            --navy-soft: #f0f4f8;
            --border:    #e2e8f0;
            --text:      #1a1a1a;
            --muted:     #94a3b8;
            --radius:    10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #ffffff;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 28px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 17px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }

        .subtitle {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-bottom: 7px;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: #475569;
        }

        input[type="email"],
        input[type="password"] {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 7px 12px;
            color: var(--text);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(30,58,95,0.12);
        }

        .error {
            background: #fff0f0;
            color: #c0392b;
            border: 1px solid #fcd0ce;
            border-radius: var(--radius);
            padding: 7px 12px;
            font-size: 12px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 9px;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 4px;
            transition: background 0.2s, transform 0.15s;
        }

        input[type="submit"]:hover {
            background: var(--navy-dark);
            transform: translateY(-1px);
        }

        input[type="submit"]:active { transform: translateY(0); }

        .signup-link {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            color: var(--muted);
        }

        .signup-link a {
            color: var(--navy-dark);
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="card">

    <h2>Welcome back</h2>
    <p class="subtitle">Log in to your account</p>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Invalid email or password. Please try again.</p>
    <?php endif; ?>

    <form action="login_process.php" method="post">

        <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <input type="submit" name="submit" value="Log In">
    </form>

    <p class="signup-link">Don't have an account? <a href="signup.html">Sign up</a></p>

</div>

</body>
</html>