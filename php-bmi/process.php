<?php
    date_default_timezone_set("Asia/Bangkok");

    // 1. Function แปลงวันที่เป็นรูปแบบไทย 
    function DateThai($strDate = "now") {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    // 2. Function คำนวณอายุ 
    function calculateAge($birthDate) {
        $dob = new DateTime($birthDate);
        $now = new DateTime('today');
        return $dob->diff($now); 
    }

    // 3. Function คำนวณค่า BMI
    function calculateBMI($weight, $height_cm) {
        $height_m = $height_cm / 100; // แปลงเป็นเมตร
        if ($height_m > 0) {
            return $weight / ($height_m * $height_m);
        }
        return 0;
    }

    // 4. Function แปลผลและให้คำแนะนำ
    function translateBMI($bmi) {
        if ($bmi < 18.5) {
            return [
                "result" => "น้ำหนักน้อย / ผอม",
                "advice" => "ควรรับประทานอาหารให้เพียงพอ ครบ 5 หมู่ และออกกำลังกายเน้นสร้างกล้ามเนื้อ",
                "color" => "#f1c40f" // เหลือง
            ];
        } elseif ($bmi >= 18.5 && $bmi <= 22.9) {
            return [
                "result" => "ปกติ (สมส่วน)",
                "advice" => "ยอดเยี่ยม! ควรรักษาระดับน้ำหนักนี้ไว้ กินอาหารที่มีประโยชน์และออกกำลังกายสม่ำเสมอ",
                "color" => "#2ecc71" // เขียว
            ];
        } elseif ($bmi >= 23.0 && $bmi <= 24.9) {
            return [
                "result" => "ท้วม / โรคอ้วนระดับ 1",
                "advice" => "เริ่มมีความเสี่ยง ควรลดของหวาน ของมัน ของทอด และเพิ่มการออกกำลังกาย",
                "color" => "#e67e22" // ส้ม
            ];
        } elseif ($bmi >= 25.0 && $bmi <= 29.9) {
            return [
                "result" => "อ้วน / โรคอ้วนระดับ 2",
                "advice" => "ควรควบคุมแคลอรี่อย่างจริงจัง และออกกำลังกายแบบแอโรบิคอย่างน้อย 30 นาที/วัน",
                "color" => "#e74c3c" // แดง
            ];
        } else {
            return [
                "result" => "อ้วนมาก / โรคอ้วนระดับ 3",
                "advice" => "อันตรายต่อสุขภาพ ควรปรึกษาแพทย์หรือนักโภชนาการเพื่อวางแผนลดน้ำหนัก",
                "color" => "#c0392b" // แดงเข้ม
            ];
        }
    }

    // รับค่า
    $fullname = $_POST['fullname'] ?? '';
    $rawBirthDate = $_POST['birthdate'] ?? date('Y-m-d');
    $weight = floatval($_POST['weight'] ?? 0);
    $height = floatval($_POST['height'] ?? 0);

    // เรียกใช้ Function ต่างๆ
    $showDateThai = DateThai($rawBirthDate);       // แปลงวันที่
    $ageInfo      = calculateAge($rawBirthDate);   // คำนวณอายุ
    $bmiValue     = calculateBMI($weight, $height);// คำนวณ BMI
    $bmiResult    = translateBMI($bmiValue);       // แปลผล
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลลัพธ์ BMI</title>
    <style>
        body { font-family: 'Sarabun', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f8ff; margin: 0; }
        .container { background-color: white; padding: 30px; border-radius: 15px; border: 2px solid #3498db; width: 450px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .result-group { margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 10px; }
        .label { font-weight: bold; color: #555; }
        .value { color: #000; margin-left: 10px; }
        .highlight { font-size: 1.2em; font-weight: bold; color: <?php echo $bmiResult['color']; ?>; }
        .btn-home { display: block; width: 100%; padding: 10px; background-color: #3498db; color: white; text-align: center; text-decoration: none; border-radius: 5px; margin-top: 20px; box-sizing: border-box; }
        .btn-home:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <div class="container">
        <h3 style="text-align:center;">ผลการวิเคราะห์สุขภาพ</h3>
        
        <div class="result-group">
            <span class="label">ชื่อ - นามสกุล :</span>
            <span class="value"><?php echo $fullname; ?></span>
        </div>

        <div class="result-group">
            <span class="label">วันเกิด :</span>
            <span class="value"><?php echo $showDateThai; ?></span>
        </div>

        <div class="result-group">
            <span class="label">อายุ :</span>
            <span class="value">
                <?php echo $ageInfo->y . " ปี " . $ageInfo->m . " เดือน " . $ageInfo->d . " วัน"; ?>
            </span>
        </div>

        <div class="result-group">
            <span class="label">น้ำหนัก :</span>
            <span class="value"><?php echo $weight; ?> กก.</span>
        </div>

        <div class="result-group">
            <span class="label">ส่วนสูง :</span>
            <span class="value"><?php echo $height; ?> ซม.</span>
        </div>

        <div class="result-group">
            <span class="label">ค่า BMI :</span>
            <span class="value highlight"><?php echo number_format($bmiValue, 2); ?></span>
        </div>

        <div class="result-group">
            <span class="label">แปลผลค่า BMI :</span> <br>
            <span class="value highlight"><?php echo $bmiResult['result']; ?></span>
        </div>

        <div class="result-group" style="border-bottom: none;">
            <span class="label">คำแนะนำ :</span> <br>
            <span class="value" style="display:block; margin-top:5px; color:#555;">
                <?php echo $bmiResult['advice']; ?>
            </span>
        </div>

        <a href="bmi.php" class="btn-home">กลับหน้าหลัก</a>
    </div>

</body>
</html>