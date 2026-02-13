<?php 
session_start();
include('db.php'); // เรียกใช้ไฟล์ db.php เพื่อความชัวร์

if (!isset($_SESSION['username'])) { header("location: login.html"); exit(); }
if (isset($_GET['logout'])) { session_destroy(); header("location: login.html"); exit(); }

$my_user = $_SESSION['username'];

// ดึงข้อมูล 5 รายการล่าสุด (จุดที่แก้ไข: ใช้ target_user แทน username)
$sql = "SELECT * FROM assessments WHERE target_user = '$my_user' ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard สมาชิก</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fas fa-user-circle"></i> สมาชิกทั่วไป</div>
        <div class="menu"> <span style="color:#45f3ff; margin-right:15px;">สวัสดี, <?php echo $_SESSION['username']; ?></span>
            <a href="member.php?logout='1'" class="btn-logout">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="card hero" style="border:1px solid rgba(69, 243, 255, 0.3);">
            <div class="hero-icon">🎉</div>
            <div>
                <h2>ยินดีต้อนรับ!</h2>
                <p>คุณเข้าสู่ระบบในฐานะ <strong><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Member'; ?></strong></p>
            </div>
        </div>

        <div class="grid-menu"> 
            
            <a href="assessment_history.php" class="menu-card" style="border-left:3px solid #45f3ff;">
                <i class="fas fa-history c-blue"></i>
                <div>
                    <h3>ประวัติการประเมิน</h3>
                    <p>ดูรายการและดาวน์โหลด PDF</p>
                </div>
            </a>
            
            <a href="edit_profile.php" class="menu-card" style="border-left:3px solid #00ff88;"> <i class="fas fa-user-edit c-green"></i>
                <div>
                    <h3>แก้ไขข้อมูลส่วนตัว</h3>
                    <p>จัดการรหัสผ่านและข้อมูล</p>
                </div>
            </a>

        </div>

        <h3 style="margin: 30px 0 15px 0; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:10px;">
            <i class="fas fa-clock"></i> รายการล่าสุด
        </h3>

        <div class="card" style="padding:0; overflow:hidden;">
            <table>
                <thead>
                    <tr>
                        <th style="padding-left:20px;">วันที่</th>
                        <th>คะแนนรวม</th>
                        <th>ดาวน์โหลด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td style="padding-left:20px;"><?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></td>
                            <td>
                                <span class="badge" style="background:#00b894; color:white;">
                                    <?php echo $row['total_score']; ?> / 100
                                </span>
                            </td>
                            <td>
                                <a href="report_pdf.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn-small btn-red" style="text-decoration:none;">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center; padding:20px; color:#aaa;">ยังไม่มีผลการประเมิน</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>