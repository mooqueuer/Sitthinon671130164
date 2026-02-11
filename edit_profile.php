<?php 
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("location: login.html"); exit(); }

if (isset($_POST['update_profile'])) {
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $user = $_SESSION['username'];

    if (!empty($password)) {
        // ถ้ากรอกรหัสใหม่ ให้เปลี่ยนรหัสด้วย
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET fullname='$fullname', password='$hash' WHERE username='$user'");
    } else {
        // ถ้าไม่กรอกรหัส เปลี่ยนแค่ชื่อ
        $conn->query("UPDATE users SET fullname='$fullname' WHERE username='$user'");
    }
    echo "<script>alert('บันทึกข้อมูลเรียบร้อย!'); window.location='member.php';</script>";
}

// ดึงข้อมูลเดิมมาโชว์
$me = $_SESSION['username'];
$user_data = $conn->query("SELECT * FROM users WHERE username='$me'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-user-edit"></i> แก้ไขข้อมูลส่วนตัว</div>
        <div class="menu"><a href="member.php">กลับหน้าหลัก</a></div>
    </nav>

    <div class="container">
        <div class="card" style="max-width:500px; margin:0 auto;">
            <form method="POST">
                <label>ชื่อผู้ใช้ (Username)</label>
                <input type="text" value="<?php echo $user_data['username']; ?>" disabled style="background:#333; cursor:not-allowed;">
                
                <label>ชื่อ-นามสกุล</label>
                <input type="text" name="fullname" value="<?php echo $user_data['fullname']; ?>" required>

                <label>เปลี่ยนรหัสผ่าน (ถ้าไม่เปลี่ยนให้เว้นว่าง)</label>
                <input type="password" name="password" placeholder="ตั้งรหัสผ่านใหม่...">

                <button type="submit" name="update_profile" style="background:#00b894; margin-top:20px;">บันทึกการเปลี่ยนแปลง</button>
            </form>
        </div>
    </div>
</body>
</html>