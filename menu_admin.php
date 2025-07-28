<?php
session_start();
include 'cek_login.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin - Al Barkah</title>
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
            line-height: 1.6;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            height: 50px;
            width: auto;
        }
        
        .header-text h1 {
            color: var(--primary-dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .header-text p {
            color: var(--primary);
            font-size: 14px;
            font-weight: 500;
        }
        
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .welcome-message {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .menu-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 20px;
            background-color: white;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text);
            border: 2px solid var(--primary);
            transition: all 0.3s;
            text-align: center;
        }
        
        .menu-button:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .menu-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        
        .menu-text {
            font-weight: 600;
            font-size: 16px;
        }
        
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: var(--danger);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
        }
        
        @media (max-width: 600px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo-container">
        <img src="logo.png" alt="Logo Al Barkah" class="logo">
        <div class="header-text">
            <h1>Pondok Pesantren Al Barkah</h1>
            <p>Menu Admin Pengiriman Beras</p>
        </div>
    </div>
</div>

<div class="admin-container">
    <div class="welcome-message">
        <i class="fas fa-user-shield"></i>
        <span>Halo, <?php echo htmlspecialchars($_SESSION['admin']); ?> 👋</span>
    </div>
    
    <div class="menu-grid">
        <a href="form_input.php" class="menu-button">
            <div class="menu-icon"><i class="fas fa-truck-loading"></i></div>
            <div class="menu-text">Input / Edit Pengiriman Baru</div>
        </a>
        <a href="index.php" class="menu-button">
            <div class="menu-icon"><i class="fas fa-file-alt"></i></div>
            <div class="menu-text">Dashboard Data Beras</div>
        </a>
        
    </div>
    
    <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</div>

</body>
</html>