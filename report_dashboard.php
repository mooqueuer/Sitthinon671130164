<?php 
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("location: login.html"); exit(); }

// คำนวณภาพรวม
$stats = $conn->query("SELECT COUNT(*) as total, AVG(total_score) as avg, MAX(total_score) as max FROM assessments")->fetch_assoc();
$result = $conn->query("SELECT * FROM assessments ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานสรุปผล</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-chart-line"></i> รายงานสรุปผล</div>
        <div class="menu"><a href="admin_dashboard.php">กลับหน้าหลัก</a></div>
    </nav>

    <div class="container">
        <div class="grid-menu" style="grid-template-columns: repeat(3, 1fr); margin-bottom:30px;">
            <div class="card" style="text-align:center; padding:20px;">
                <h1 style="color:#45f3ff; font-size:3em;"><?php echo $stats['total']; ?></h1>
                <p>จำนวนการประเมิน</p>
            </div>
            <div class="card" style="text-align:center; padding:20px;">
                <h1 style="color:#00ff88; font-size:3em;"><?php echo number_format($stats['avg'], 1); ?></h1>
                <p>คะแนนเฉลี่ย</p>
            </div>
            <div class="card" style="text-align:center; padding:20px;">
                <h1 style="color:#ff9f43; font-size:3em;"><?php echo $stats['max']; ?></h1>
                <p>คะแนนสูงสุด</p>
            </div>
        </div>

        <div class="card">
            <h3>รายละเอียดการประเมินทั้งหมด</h3>
            <table>
                <thead>
                    <tr>
                        <th>ผู้ถูกประเมิน</th>
                        <th>ผู้ประเมิน</th>
                        <th>คะแนนรวม</th>
                        <th>เกรด</th>
                        <th>วันที่</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): 
                        $s = $row['total_score'];
                        $grade = ($s >= 80) ? 'A' : (($s >= 70) ? 'B' : (($s >= 60) ? 'C' : 'D'));
                        $color = ($s >= 80) ? '#00ff88' : (($s >= 60) ? '#f1c40f' : '#ff5e57');
                    ?>
                    <tr>
                        <td style="color:#45f3ff; font-weight:bold;"><?php echo $row['target_user']; ?></td>
                        <td><?php echo $row['evaluator_name']; ?></td>
                        <td><?php echo $s; ?> / 100</td>
                        <td><span class="badge" style="background:<?php echo $color; ?>; color:black;"><?php echo $grade; ?></span></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>