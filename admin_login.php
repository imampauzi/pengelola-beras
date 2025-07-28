<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Al Barkah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2e7d32;
            --primary-light: #4caf50;
            --primary-dark: #1b5e20;
            --secondary: #8bc34a;
            --danger: #c62828;
            --warning: #f9a825;
            --info: #0288d1;
            --light: #f1f8e9;
            --light-gray: #f5f5f5;
            --dark: #2e3a33;
            --border: #e0e0e0;
            --text: #333;
            --text-light: #757575;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            max-width: 500px;
            width: 100%;
        }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
        }
        
        .logo {
            height: 80px;
            width: auto;
        }
        
        .header-text h1 {
            color: var(--primary-dark);
            font-size: 24px;
            font-weight: 700;
        }
        
        .header-text p {
            color: var(--primary);
            font-size: 14px;
            font-weight: 500;
        }
        
        .login-form {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 25px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(46, 125, 50, 0.2);
        }
        
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .error-message {
            color: var(--danger);
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .login-form {
                padding: 25px 20px;
            }
            
            .form-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="logo.png" alt="Logo Al Barkah" class="logo">
            <div class="header-text">
                <h1>Pondok Pesantren Al Barkah</h1>
                <p>Sistem Manajemen Pengiriman Beras</p>
            </div>
        </div>
        
        <form method="POST" action="login_proses.php" class="login-form">
            <h2 class="form-title">
                <i class="fas fa-lock"></i>
                <span>Login Admin</span>
            </h2>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk</span>
            </button>
            
            <?php if(isset($_SESSION['login_error'])): ?>
                <div class="error-message">
                    <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>