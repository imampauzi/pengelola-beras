<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input & Data Pengiriman Beras - Al Barkah</title>
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
            margin-bottom: 20px;
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
        
        .container {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }
        
        /* Form Styles */
        .form-container {
            flex: 1;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }
        
        .form-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
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
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
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
        }
        
        .submit-btn:hover {
            background-color: var(--primary-dark);
        }
        
        /* Table Styles */
        .table-container {
            flex: 2;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .table-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--light);
        }
        
        .table-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: var(--light);
            color: var(--primary-dark);
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: var(--light);
        }
        
        /* Action Buttons */
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .edit-btn {
            background-color: var(--primary);
            color: white;
        }
        
        .delete-btn {
            background-color: var(--danger);
            color: white;
        }
        
        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 11px;
            transition: width 0.6s ease;
        }
        
        .green {
            background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
        }
        
        .yellow {
            background: linear-gradient(90deg, var(--warning), #ffab00);
        }
        
        .red {
            background: linear-gradient(90deg, var(--danger), #b71c1c);
        }
        
        /* Filter dan Search */
        .filter-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-group label {
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
        }
        
        .search-box {
            flex: 1;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 8px 15px 8px 35px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 14px;
        }
        
        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .container {
                flex-direction: column;
            }
            
            .form-container,
            .table-container {
                width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
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
            <p>Sistem Pengiriman Beras</p>
        </div>
    </div>
    <div class="period">
        <i class="fas fa-calendar-alt"></i>
        <span><?php echo date('d F Y'); ?></span>
    </div>
</div>

<div class="container">
    <!-- Form Section -->
    <div class="form-container">
        <h2 class="form-title"><i class="fas fa-edit"></i> Form Input Pengiriman</h2>
        <form method="POST" action="proses_input.php">
            <div class="form-group">
                <label for="nama">Nama Penerima</label>
                <select name="nama_dropdown" id="nama_dropdown" onchange="document.getElementById('nama_input').value=this.value" class="form-control">
                    <option value="">-- Pilih Nama --</option>
                    <?php
                    $sql_nama = "SELECT DISTINCT nama FROM pengiriman_beras ORDER BY nama";
                    $result_nama = $koneksi->query($sql_nama);
                    while ($row = $result_nama->fetch_assoc()) {
                        echo "<option value='{$row['nama']}'>{$row['nama']}</option>";
                    }
                    ?>
                </select>
                <input type="text" name="nama" id="nama_input" placeholder="Ketik nama baru..." required>
            </div>
            
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="jenis">Jenis Bantuan</label>
                <select name="jenis" id="jenis" required>
                    <option value="">-- Pilih Jenis Bantuan --</option>
                    <option value="Uang">Uang</option>
                    <option value="Beras">Beras</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal Kirim</label>
                <input type="datetime-local" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="progres">Jumlah Bayar</label>
                <select name="progres" id="progres" required>
                    <option value="">-- Pilih Jumlah Bayar --</option>
                    <option value="75000">Setengah 5kg (Rp 75.000)</option>
                    <option value="150000">Lunas 10kg (Rp 150.000)</option>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i> Simpan Data
            </button>
        </form>
    </div>
    
    <!-- Table Section -->
    <div class="table-container">
        <div class="table-header">
            <h2><i class="fas fa-table"></i> Data Pengiriman Beras</h2>
        </div>
        
        <!-- Filter dan Search -->
        <div class="filter-container" style="padding: 0 20px; margin-top: 15px;">
            <div class="filter-group">
                <label for="filter-jk">Filter:</label>
                <select id="filter-jk" onchange="filterTable()">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Cari nama penerima..." onkeyup="searchTable()">
            </div>
        </div>
        
        <table id="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Progress</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM pengiriman_beras ORDER BY tanggal DESC";
                $result = $koneksi->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $warna = 'red';
                        $persen = 0;
                        $label = "Belum Bayar";
                        $gender_icon = ($row['jenis_kelamin'] == 'L') ? 
                            '<i class="fas fa-male" style="color: #2196F3;"></i>' : 
                            '<i class="fas fa-female" style="color: #E91E63;"></i>';

                        if ($row['progres'] >= 150000) {
                            $warna = 'green';
                            $persen = 100;
                            $label = "Lunas";
                        } elseif ($row['progres'] > 0) {
                            $warna = 'yellow';
                            $persen = round(($row['progres'] / 150000) * 100);
                            $label = $persen . "%";
                        }

                        echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>{$gender_icon} {$row['jenis_kelamin']}</td>
                            <td>{$row['jenis']}</td>
                            <td>" . date('d M Y H:i', strtotime($row['tanggal'])) . "</td>
                            <td>
                                <div class='progress-container'>
                                    <div class='progress-bar $warna' style='width: {$persen}%'>{$label}</div>
                                </div>
                            </td>
                            <td>
                                <div class='actions'>
                                    <a href='edit.php?id={$row['id']}' class='action-btn edit-btn'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                    <a href='hapus.php?id={$row['id']}' class='action-btn delete-btn' onclick=\"return confirm('Yakin hapus data ini?')\">
                                        <i class='fas fa-trash'></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center; padding: 20px;'>Tidak ada data ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Animasi progress bar saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    });

    // Fungsi untuk filter tabel berdasarkan jenis kelamin
    function filterTable() {
        const filter = document.getElementById('filter-jk').value.toUpperCase();
        const table = document.getElementById('data-table');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[1];
            if (td) {
                const jk = td.textContent.trim().charAt(0);
                if (filter === '' || jk === filter) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }

    // Fungsi untuk pencarian nama
    function searchTable() {
        const input = document.getElementById('search-input');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('data-table');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[0];
            if (td) {
                const txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
</script>

</body>
</html>