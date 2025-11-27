<?php
// student_profile.php
// ปรับค่าให้ตรงตามที่ผู้ใช้ระบุ: รูปโปรไฟล์เป็นลิงก์, ข้อมูลมหาลัย/คณะ/สาขา/ชื่อ
// ข้อมูลด้านล่างไม่ถูกแก้ไข (ตามคำสั่งผู้ใช้)

// ----- ปรับค่าตัวแปรที่นี่ -----
$avatar_url = 'https://img2.pic.in.th/pic/F2801914df2b2a1b9f.jpg';
$university = 'มหาวิทยาลัยราชภัฏอุดรธานี';
$faculty    = 'คณะวิทยาศาสตร์';
$major      = 'สาขาเทคโนโลยีสารสนเทศ';
$fullname   = 'นายสุธีรภัทร์ การสมพรต';
$intro      = "สวัสดีครับ ผมชื่อ นายสุธีรภัทร์ การสมพรต กำลังศึกษาอยู่ที่มหาวิทยาลัยราชภัฏอุดรธานี คณะวิทยาศาสตร์ สาขาเทคโนโลยีสารสนเทศ ผมมีความสนใจด้านพัฒนาเว็บไซต์ และการวิเคราะห์ข้อมูล มีทักษะพื้นฐาน HTML/CSS และ JavaScript พร้อมเรียนรู้เทคโนโลยีใหม่ๆ";
// -------------------------------

function e($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

?>

<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>โปรไฟล์นักศึกษา — <?php echo e($fullname); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg1: #f6fff7;
      --card-bg: #ffffff;
      --green: 22,163,74; /* RGB */
      --yellow: 245,158,11; /* RGB */
      --accent1: #16a34a; /* green */
      --accent2: #f59e0b; /* yellow */
      --muted: #53606a;
      --radius: 14px;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Noto Sans', 'Helvetica Neue', Arial;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:40px 20px;
      color:#0f172a;
      background: var(--bg1);
      position:relative;
      overflow-x:hidden;
    }

    /* เบลอพื้นหลังแบบ Green(70%)/Yellow(30%) โดยใช้ radial gradients ที่เบลอและอิ่มตัว */
    body::before{
      content: '';
      position: fixed;
      inset: -20%; /* ขยายออกนอกวิวเพื่อให้เบลอขอบ */
      z-index: -2;
      background:
        radial-gradient(40% 40% at 12% 30%, rgba(var(--green), 0.88) 0%, rgba(var(--green), 0.70) 25%, rgba(var(--green), 0.20) 55%, transparent 70%),
        radial-gradient(28% 28% at 84% 70%, rgba(var(--yellow), 0.42) 0%, rgba(var(--yellow), 0.28) 25%, rgba(var(--yellow), 0.06) 55%, transparent 70%);
      filter: blur(60px) saturate(120%);
      transform: scale(1.02);
      pointer-events: none;
    }

    /* ออบเจ็กต์ทับเลเยอร์โปร่งแสง เพิ่มความนวลของพื้นหลัง */
    body::after{
      content: '';
      position: fixed;
      inset:0;
      z-index:-1;
      background: linear-gradient(180deg, rgba(255,255,255,0.42), rgba(255,255,255,0.12));
      mix-blend-mode: overlay;
      pointer-events:none;
    }

    .container{
      width:100%;
      max-width:980px;
      display:grid;
      grid-template-columns: 320px 1fr;
      gap:28px;
      align-items:start;
      z-index:0; /* อยู่บนพื้นหลัง */
    }

    .card{
      background:var(--card-bg);
      border-radius:var(--radius);
      box-shadow: 0 8px 30px rgba(16,24,40,0.06);
      padding:28px;
      backdrop-filter: blur(6px);
    }

    .profile-card{
      display:flex;
      flex-direction:column;
      gap:18px;
      text-align:center;
    }

    .avatar-wrap{width:120px;height:120px;margin:0 auto;position:relative}
    .avatar-img{
      width:120px;height:120px;border-radius:50%;object-fit:cover;display:block;border:4px solid rgba(255,255,255,0.9);
      box-shadow: 0 12px 34px rgba(22,163,74,0.14);
    }

    h1{font-size:20px;margin:6px 0 0}
    p.lead{margin:0;color:var(--muted);font-weight:600}

    .info-list{display:flex;flex-direction:column;gap:12px;margin-top:6px;text-align:left}
    .info-item{display:flex;gap:12px;align-items:center}
    .dot{width:10px;height:10px;border-radius:50%;background:linear-gradient(180deg,var(--accent1) 0%, var(--accent2) 100%);flex:0 0 10px}
    .k{font-size:13px;color:var(--muted);min-width:120px}
    .v{font-weight:600}

    .intro{
      line-height:1.6;
      color:#0b1220;
      padding:18px;
      border-radius:10px;
      background: linear-gradient(180deg, rgba(22,163,74,0.03), rgba(245,158,11,0.01));
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .details-card{padding:28px}
    .section-title{font-weight:700;margin:0 0 12px}

    .advice{margin-top:14px;padding:12px;border-radius:10px;background:#f7fff4;color:#06361a}

    /* ปรับให้สวยบนมือถือ */
    @media (max-width:880px){
      .container{grid-template-columns:1fr;}
      .profile-card{text-align:center}
    }

  </style>
</head>
<body>
  <main class="container">
    <aside class="card profile-card">
      <div class="avatar-wrap">
        <?php if(!empty($avatar_url)): ?>
          <img class="avatar-img" src="<?php echo e($avatar_url); ?>" alt="Avatar of <?php echo e($fullname); ?>">
        <?php else: ?>
          <div class="avatar" style="width:120px;height:120px;border-radius:50%;display:grid;place-items:center;font-weight:700;font-size:34px;background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;margin:0 auto;"><?php echo strtoupper(mb_substr($fullname,0,2,'UTF-8')); ?></div>
        <?php endif; ?>
      </div>

      <div>
        <h1><?php echo e($fullname); ?></h1>
        <p class="lead"><?php echo e($major); ?></p>
      </div>

      <div class="info-list">
        <div class="info-item"><span class="dot"></span><span class="k">มหาวิทยาลัย</span><span class="v"><?php echo e($university); ?></span></div>
        <div class="info-item"><span class="dot"></span><span class="k">คณะ</span><span class="v"><?php echo e($faculty); ?></span></div>
        <div class="info-item"><span class="dot"></span><span class="k">สาขา</span><span class="v"><?php echo e($major); ?></span></div>
      </div>
    </aside>

    <section class="card details-card">
      <h2 class="section-title">เกี่ยวกับฉัน</h2>
      <div class="intro"><?php echo nl2br(e($intro)); ?></div>

      <div style="margin-top:18px; display:flex; gap:12px; flex-wrap:wrap">
        <div style="flex:1; min-width:180px">
          <h3 style="margin:0 0 8px; font-size:14px">ทักษะ</h3>
          <ul style="margin:0 0 0 18px;padding:0;color:var(--muted)">
            <li>พัฒนาเว็บไซต์ (HTML/CSS, JavaScript)</li>
            <li>พื้นฐาน JavaScript และการวิเคราะห์ข้อมูล</li>
          </ul>
        </div>

    </section>
  </main>
</body>
</html>