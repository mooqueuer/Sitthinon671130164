<?php 
session_start();
include('db.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์: ต้องล็อกอิน และต้องไม่ใช่ Student (Admin หรือ Evaluator เท่านั้น)
if (!isset($_SESSION['username']) || $_SESSION['role'] == 'student') { 
    header("location: login.html"); exit(); 
}

// ดึงรายชื่อผู้ใช้ที่เป็น "student" หรือ "evaluator" (ไม่เอา Admin) มาให้เลือกประเมิน
$result = $conn->query("SELECT * FROM users WHERE role != 'admin'");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายชื่อผู้ให้การประเมิน</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fas fa-users"></i> เลือกผู้ที่ต้องการประเมิน</div>
        <div class="menu">
            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php">กลับหน้าหลัก</a>
            <?php else: ?>
                <a href="member.php">กลับหน้าหลัก</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div style="text-align:center; margin-bottom:30px;">
            <h2><i class="fas fa-search"></i> รายชื่อบุคลากร/นักศึกษา</h2>
            <p style="color:#aaa;">เลือกรายชื่อด้านล่างเพื่อเริ่มทำแบบประเมิน</p>
        </div>

        <div class="grid-menu">
            <?php if ($result->num_rows > 0): ?>
                <?php while($user = $result->fetch_assoc()): ?>
                <div class="menu-card" style="align-items: flex-start; min-height: auto; height: auto;">
                    
                    <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px; width:100%;">
                        <div style="width:50px; height:50px; background: linear-gradient(45deg, #45f3ff, #00ff88); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#000; font-weight:bold; font-size:20px; box-shadow: 0 0 10px rgba(69, 243, 255, 0.5);">
                            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                        </div>
                        <div>
                            <div style="font-size:1.2em; font-weight:bold; color:white;"><?php echo $user['username']; ?></div>
                            
                            <?php 
                                $r = $user['role'];
                                $cls = ($r=='evaluator')?'role-evaluator':'role-student';
                            ?>
                            <span class="badge <?php echo $cls; ?>" style="font-size:0.8em; margin-top:5px; display:inline-block;">
                                <?php echo ucfirst($r); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div style="width:100%; display:flex; gap:10px;">
    <a href="assessment_form.php?target_user=<?php echo $user['username']; ?>" 
       style="flex:2; background:#00b894; color:white; text-align:center; padding:10px; border-radius:8px; text-decoration:none; font-weight:bold; transition:0.3s;">
       <i class="fas fa-pen"></i> ประเมิน
    </a>

    <a href="assessment_history.php?target_user=<?php echo $user['username']; ?>" 
       style="flex:1; background:#0984e3; color:white; text-align:center; padding:10px; border-radius:8px; text-decoration:none; font-weight:bold;">
       <i class="fas fa-history"></i> ประวัติ
    </a>
</div>

                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="width:100%; text-align:center; padding:50px; background:rgba(255,255,255,0.05); border-radius:10px;">
                    <i class="fas fa-user-slash" style="font-size:50px; color:#555; margin-bottom:20px;"></i>
                    <p>ยังไม่มีรายชื่อผู้ใช้งานให้ประเมิน</p>
                    <a href="register.html" style="color:#45f3ff;">เพิ่มผู้ใช้ใหม่</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>