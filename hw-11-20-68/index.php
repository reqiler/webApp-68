<?php
 $avatar_url = 'https://img2.pic.in.th/pic/F2801914df2b2a1b9f.jpg';
 $university = 'มหาวิทยาลัยราชภัฏอุดรธานี';
 $faculty    = 'คณะวิทยาศาสตร์';
 $major      = 'สาขาเทคโนโลยีสารสนเทศ';
 $fullname   = 'นายสุธีรภัทร์ การสมพรต';
 $intro      = "สวัสดีครับ ผมชื่อ นายสุธีรภัทร์ การสมพรต กำลังศึกษาอยู่ที่มหาวิทยาลัยราชภัฏอุดรธานี คณะวิทยาศาสตร์ สาขาเทคโนโลยีสารสนเทศ ผมมีความสนใจด้านพัฒนาเว็บไซต์ และการวิเคราะห์ข้อมูล มีทักษะพื้นฐาน HTML/CSS และ JavaScript พร้อมเรียนรู้เทคโนโลยีใหม่ๆ";

function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>

<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>โปรไฟล์นักศึกษา — <?php echo e($fullname); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg1:#06060a; --muted:#b8bec6; --radius:18px; --glass-border:rgba(255,255,255,0.08);
      --glass-shadow:0 10px 30px rgba(2,6,23,0.6);
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{
      margin:0; font-family:'Poppins',system-ui,-apple-system,'Segoe UI',Roboto,'Noto Sans',Arial;
      min-height:100vh; display:flex; align-items:center; justify-content:center; padding:48px 20px;
      color:#fff; background:var(--bg1); position:relative; overflow-x:hidden;
    }
    body::before{
      content:''; position:fixed; inset:0; z-index:-4;
      background-image:url('https://img5.pic.in.th/file/secure-sv1/a6bd4db7ee7053689bd971b36cbcd1ef.jpg');
      background-size:cover; background-position:center; filter:brightness(0.75) contrast(1.05) saturate(1.05);
      transform:scale(1.02); pointer-events:none;
    }
    body::after{
      content:''; position:fixed; inset:0; z-index:-3;
      background:linear-gradient(180deg, rgba(2,6,23,0.40), rgba(2,6,23,0.70)); pointer-events:none;
    }
    .glow-layer{position:fixed; inset:-10% -20% auto -20%; height:120%; z-index:-2; pointer-events:none;
      background: radial-gradient(600px 400px at 10% 20%, rgba(22,163,74,0.06), transparent 12%),
                  radial-gradient(500px 350px at 90% 80%, rgba(245,158,11,0.05), transparent 15%);
      mix-blend-mode:screen; filter:blur(26px) saturate(110%); opacity:0.9;
    }

    .container{width:100%; max-width:1100px; display:grid; grid-template-columns:340px 1fr; gap:28px; align-items:start; z-index:0;}

    .card{
      background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:var(--radius); box-shadow:var(--glass-shadow), inset 0 1px 0 rgba(255,255,255,0.02);
      padding:28px; backdrop-filter:blur(12px) saturate(1.05); -webkit-backdrop-filter:blur(12px) saturate(1.05);
      border:1px solid var(--glass-border); position:relative; overflow:visible; transition:transform .22s, box-shadow .22s;
    }
    .card:hover{ transform:translateY(-6px); box-shadow:0 14px 40px rgba(2,6,23,0.65), inset 0 1px 0 rgba(255,255,255,0.015); }

    .profile-card{ display:flex; flex-direction:column; gap:18px; text-align:center; position:relative; }
    .avatar-wrap{width:132px; height:132px; margin:0 auto; position:relative; display:block;}
    .avatar-img{ width:132px; height:132px; border-radius:50%; object-fit:cover; border:3px solid rgba(255,255,255,0.09);
      box-shadow:0 16px 36px rgba(22,163,74,0.12), 0 6px 18px rgba(2,6,23,0.55); background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00)); }

    h1{font-size:20px; margin:6px 0 0; letter-spacing:0.2px}
    p.lead{margin:0; color:var(--muted); font-weight:600}

    .info-list{ display:flex; flex-direction:column; gap:10px; margin-top:6px; text-align:left; }
    .info-item{ display:flex; gap:12px; align-items:flex-start; min-height:28px; }
    .dot{ width:10px; height:10px; border-radius:50%; background:linear-gradient(180deg,#16a34a,#f59e0b);
      box-shadow:0 4px 10px rgba(22,163,74,0.08); flex:0 0 10px; margin-top:6px; }
    .k{ font-size:13px; color:var(--muted); flex:0 0 110px; padding-top:2px; }
    .v{ font-weight:600; flex:1; min-width:0; white-space:normal; word-break:break-word; line-height:1.25; }

    .intro{ line-height:1.72; color:#e8eef1; padding:20px; border-radius:12px;
      background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00));
      box-shadow:inset 0 1px 0 rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.03); margin-top:6px; font-size:15px; }

    .details-card{ padding:28px; position:relative; overflow:visible; }
    .section-title{ font-weight:700; margin:0 0 12px; color:#f7fbfb; }

    .details-card::after{ content:''; position:absolute; right:-48px; top:-40px; width:220px; height:220px; border-radius:50%;
      background: radial-gradient(circle at 40% 40%, rgba(22,163,74,0.025), transparent 25%),
                  radial-gradient(circle at 70% 70%, rgba(245,158,11,0.02), transparent 30%);
      filter:blur(28px); pointer-events:none; z-index:-1; }

    @media (max-width:880px){
      .container{ grid-template-columns:1fr; }
      .profile-card{text-align:center}
      .avatar-wrap{width:120px;height:120px}
      .avatar-img{width:120px;height:120px}
      body{padding:28px 16px}
      .details-card::after{ display:none; }
      .k{ flex:0 0 100px; }
    }

    ul{ color:var(--muted); font-size:14px }
    li{ margin:6px 0 }
    a.avatar-link{ display:block; border-radius:50%; width:132px; height:132px; margin:0 auto; display:grid; place-items:center; text-decoration:none; }
  </style>
</head>
<body>
  <div class="glow-layer" aria-hidden="true"></div>
  <main class="container">
    <aside class="card profile-card">
      <div class="avatar-wrap">
        <?php if(!empty($avatar_url)): ?>
          <a class="avatar-link" href="<?php echo e($avatar_url); ?>" target="_blank" rel="noopener noreferrer">
            <img class="avatar-img" src="<?php echo e($avatar_url); ?>" alt="Avatar of <?php echo e($fullname); ?>">
          </a>
        <?php else: ?>
          <div class="avatar" style="width:120px;height:120px;border-radius:50%;display:grid;place-items:center;font-weight:700;font-size:34px;background:linear-gradient(90deg,#16a34a,#f59e0b);color:#fff;margin:0 auto;">
            <?php echo strtoupper(mb_substr($fullname,0,2,'UTF-8')); ?>
          </div>
        <?php endif; ?>
      </div>

      <div>
        <h1><?php echo e($fullname); ?></h1>
        <p class="lead"><?php echo e($major); ?></p>
      </div>

      <div class="info-list" aria-label="ข้อมูลสถาบัน">
        <div class="info-item">
          <span class="dot" aria-hidden="true"></span>
          <span class="k">มหาวิทยาลัย</span>
          <span class="v" title="<?php echo e($university); ?>"><?php echo e($university); ?></span>
        </div>

        <div class="info-item">
          <span class="dot" aria-hidden="true"></span>
          <span class="k">คณะ</span>
          <span class="v" title="<?php echo e($faculty); ?>"><?php echo e($faculty); ?></span>
        </div>

        <div class="info-item">
          <span class="dot" aria-hidden="true"></span>
          <span class="k">สาขา</span>
          <span class="v" title="<?php echo e($major); ?>"><?php echo e($major); ?></span>
        </div>
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
      </div>

    </section>
  </main>
</body>
</html>
