<?php include 'db.php'; ?>
<?php
// Ambil parameter filter
$bulan_aktif = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_aktif = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$jenis_kelamin = isset($_GET['jenis_kelamin']) ? $_GET['jenis_kelamin'] : 'semua';
$jenis_beras = isset($_GET['jenis_beras']) ? $_GET['jenis_beras'] : 'semua';

// Query data statistik dengan filter
$sql_condition = "WHERE MONTH(tanggal) = '$bulan_aktif' AND YEAR(tanggal) = '$tahun_aktif'";
if($jenis_kelamin != 'semua') {
    $sql_condition .= " AND jenis_kelamin = '$jenis_kelamin'";
}
if($jenis_beras != 'semua') {
    $sql_condition .= " AND jenis = '$jenis_beras'";
}

$sql_total = "SELECT COUNT(*) as total FROM pengiriman_beras $sql_condition";
$result_total = $koneksi->query($sql_total);
$total_pengiriman = $result_total->fetch_assoc()['total'];

$sql_lunas = "SELECT COUNT(*) as lunas FROM pengiriman_beras $sql_condition AND progres >= 150000";
$result_lunas = $koneksi->query($sql_lunas);
$total_lunas = $result_lunas->fetch_assoc()['lunas'];

$sql_proses = "SELECT COUNT(*) as proses FROM pengiriman_beras $sql_condition AND progres > 0 AND progres < 150000";
$result_proses = $koneksi->query($sql_proses);
$total_proses = $result_proses->fetch_assoc()['proses'];

$total_belum_bayar = $total_pengiriman - $total_lunas - $total_proses;
$persentase_lunas = ($total_pengiriman > 0) ? round(($total_lunas/$total_pengiriman)*100) : 0;

// Query untuk chart jenis kelamin
$sql_gender = "SELECT jenis_kelamin, COUNT(*) as jumlah FROM pengiriman_beras $sql_condition GROUP BY jenis_kelamin";
$result_gender = $koneksi->query($sql_gender);
$gender_data = [];
while($row = $result_gender->fetch_assoc()) {
    $gender_data[$row['jenis_kelamin']] = $row['jumlah'];
}

// Query untuk jenis beras yang tersedia
$sql_jenis_beras = "SELECT DISTINCT jenis FROM pengiriman_beras ORDER BY jenis";
$result_jenis_beras = $koneksi->query($sql_jenis_beras);
$jenis_beras_options = [];
while($row = $result_jenis_beras->fetch_assoc()) {
    $jenis_beras_options[] = $row['jenis'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengiriman Beras - Al Barkah</title>
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
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
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
            height: 60px;
            width: auto;
            object-fit: contain;
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
        
        .period {
            font-size: 15px;
            color: var(--primary-dark);
            background: var(--light);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid var(--primary);
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--primary);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .card-header .icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            background: var(--primary-light);
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-body .value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary-dark);
        }
        
        .card-body .description {
            font-size: 13px;
            color: var(--text-light);
        }
        
        /* Progress Card */
        .progress-card {
            grid-column: span 4;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .progress-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .progress-container {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .progress-bar {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: white;
            transition: width 0.6s ease;
            background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
        }
        
        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-light);
        }
        
        /* Chart Container */
        .chart-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .chart-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .chart-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chart {
            height: 200px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 30px;
            padding-top: 20px;
        }
        
        .chart-bar {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40px;
        }
        
        .bar {
            width: 100%;
            background: var(--primary);
            border-radius: 5px 5px 0 0;
            transition: height 1s ease;
            position: relative;
        }
        
        .bar-label {
            margin-top: 10px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text);
        }
        
        .bar-value {
            position: absolute;
            top: -25px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .filter-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-form {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-form label {
            font-weight: 500;
            color: var(--text);
            font-size: 14px;
            min-width: 80px;
        }
        
        .filter-form select, 
        .filter-form input {
            padding: 8px 15px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: white;
            cursor: pointer;
            font-size: 14px;
            min-width: 150px;
        }
        
        .filter-form button {
            padding: 10px 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-form button:hover {
            background-color: var(--primary-dark);
        }
        
        /* Data Table */
        .data-section {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .section-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--light);
        }
        
        .section-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .export-btn {
            padding: 8px 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
        }
        
        .export-btn:hover {
            background: var(--primary-dark);
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
            position: sticky;
            top: 0;
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
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: var(--primary-light);
            color: white;
        }
        
        .badge-warning {
            background-color: var(--warning);
            color: #333;
        }
        
        .badge-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .gender-icon {
            margin-right: 5px;
        }
        
        .male {
            color: #2196F3;
        }
        
        .female {
            color: #E91E63;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .progress-card {
                grid-column: span 2;
            }
            
            .chart-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
            
            .progress-card {
                grid-column: span 1;
            }
            
            .filter-form {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .filter-group {
                flex-direction: column;
                align-items: stretch;
                gap: 5px;
            }
            
            .filter-form label {
                min-width: auto;
            }
            
            .filter-form select, 
            .filter-form input {
                width: 100%;
                min-width: auto;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header dengan Logo -->
        <div class="header">
            <div class="logo-container">
                <img src="logo.png" alt="Logo Al Barkah" class="logo">
                <div class="header-text">
                    <h1>Pondok Pesantren Al Barkah</h1>
                    <p>Sistem Manajemen Pengiriman Beras</p>
                </div>
            </div>
            <div class="period">
                <i class="fas fa-calendar-alt"></i>
                <span><?php echo date('F Y', mktime(0, 0, 0, $bulan_aktif, 1, $tahun_aktif)); ?></span>
            </div>
        </div>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <h3>Total Pengiriman</h3>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="value"><?php echo $total_pengiriman; ?></div>
                    <div class="description">Total pengiriman bulan ini</div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Lunas</h3>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="value"><?php echo $total_lunas; ?></div>
                    <div class="description">Pembayaran telah lunas</div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Proses</h3>
                    <div class="icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="value"><?php echo $total_proses; ?></div>
                    <div class="description">Pembayaran dalam proses</div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Belum Bayar</h3>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="value"><?php echo $total_belum_bayar; ?></div>
                    <div class="description">Belum melakukan pembayaran</div>
                </div>
            </div>
            
            
            <!-- Progress Card -->
            <div class="progress-card">
                <div class="progress-title">
                    <i class="fas fa-chart-line"></i>
                    <span>Persentase Pembayaran Lunas</span>
                </div>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?php echo $persentase_lunas; ?>%">
                        <?php echo $persentase_lunas; ?>%
                    </div>
                </div>
                <div class="progress-labels">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i>
                <span>Filter Data</span>
            </div>
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label><i class="fas fa-calendar-month"></i> Bulan:</label>
                    <select name="bulan">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            $val = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $selected = ($val == $bulan_aktif) ? 'selected' : '';
                            echo "<option value='$val' $selected>" . date('F', mktime(0, 0, 0, $i, 1)) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt"></i> Tahun:</label>
                    <select name="tahun">
                        <?php
                        for ($y = 2022; $y <= date('Y') + 2; $y++) {
                            $selected = ($y == $tahun_aktif) ? 'selected' : '';
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label><i class="fas fa-venus-mars"></i> Jenis Kelamin:</label>
                    <select name="jenis_kelamin">
                        <option value="semua" <?php echo $jenis_kelamin == 'semua' ? 'selected' : ''; ?>>Semua</option>
                        <option value="L" <?php echo $jenis_kelamin == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo $jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label><i class="fas fa-wheat-awn"></i> Jenis Beras:</label>
                    <select name="jenis_beras">
                        <option value="semua" <?php echo $jenis_beras == 'semua' ? 'selected' : ''; ?>>Semua Jenis</option>
                        <?php foreach($jenis_beras_options as $jenis): ?>
                            <option value="<?php echo $jenis; ?>" <?php echo $jenis_beras == $jenis ? 'selected' : ''; ?>><?php echo $jenis; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit">
                    <i class="fas fa-search"></i>
                    <span>Tampilkan Data</span>
                </button>
            </form>
        </div>
        
        <!-- Data Table -->
        <div class="data-section">
            <div class="section-header">
                <h2>
                    <i class="fas fa-table"></i>
                    <span>Daftar Pengiriman Beras</span>
                </h2>
                <button class="export-btn" onclick="exportToExcel()">
                    <i class="fas fa-file-export"></i>
                    <span>Export Laporan</span>
                </button>
            </div>
            
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penerima</th>
                        <th>Jenis Kelamin</th>
                        <th>Jenis Beras</th>
                        <th>Tanggal Kirim</th>
                        <th>Jumlah (kg)</th>
                        <th>Status Pembayaran</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM pengiriman_beras $sql_condition ORDER BY tanggal DESC";
                    $result = $koneksi->query($sql);
                    $no = 1;
                    
                    while ($row = $result->fetch_assoc()) {
                        $warna = 'badge-danger';
                        $persen = 0;
                        $label = "Belum Bayar";
                        $status = "Belum Bayar";
                        $gender_icon = ($row['jenis_kelamin'] == 'Laki-laki') ? 
                            '<i class="fas fa-male gender-icon male"></i>' : 
                            '<i class="fas fa-female gender-icon female"></i>';

                        if ($row['progres'] >= 150000) {
                            $warna = 'badge-success';
                            $persen = 100;
                            $label = "Lunas";
                            $status = "Lunas";
                        } elseif ($row['progres'] > 0) {
                            $warna = 'badge-warning';
                            $persen = round(($row['progres'] / 150000) * 100);
                            $label = $persen . "%";
                            $status = "Proses";
                        }

                        echo "<tr>
                            <td>$no</td>
                            <td>{$row['nama']}</td>
                            <td>$gender_icon {$row['jenis_kelamin']}</td>
                            <td>{$row['jenis']}</td>
                            <td>" . date('d M Y', strtotime($row['tanggal'])) . "</td>
                            <td>50</td>
                            <td><span class='status-badge $warna'>$status</span></td>
                            <td>
                                <div class='progress-container' style='width: 100px; margin: 0 auto;'>
                                    <div class='progress-bar' style='width: {$persen}%'></div>
                                </div>
                                <div style='text-align: center; font-size: 12px; margin-top: 3px;'>$label</div>
                            </td>
                        </tr>";
                        $no++;
                    }
                    
                    if($no == 1) {
                        echo "<tr><td colspan='8' style='text-align: center; padding: 20px;'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Animasi progress bar saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi progress bar
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
            
            // Animasi chart bar
            const bars = document.querySelectorAll('.bar');
            bars.forEach(bar => {
                const height = bar.style.height;
                bar.style.height = '0%';
                setTimeout(() => {
                    bar.style.height = height;
                }, 300);
            });
        });

        // Fungsi export ke Excel
        function exportToExcel() {
            const table = document.getElementById('dataTable');
            const html = table.outerHTML;
            
            // Buar blob dari HTML tabel
            const blob = new Blob([html], {type: 'application/vnd.ms-excel'});
            
            // Buat link download
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Pengiriman_Beras_Al_Barkah_<?php echo date('F_Y'); ?>.xls';
            link.click();
            
            // Notifikasi
            alert('Laporan berhasil diunduh');
        }
    </script>
</body>
</html>