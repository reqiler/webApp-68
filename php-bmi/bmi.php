<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรแกรมคำนวณ BMI</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f8ff;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #3498db;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 { text-align: center; color: #2980b9; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* สำคัญเพื่อให้ padding ไม่ดัน box แตก */
        }
        .btn-group { text-align: center; margin-top: 20px; }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 5px;
        }
        .btn-submit { background-color: #3498db; color: white; }
        .btn-clear { background-color: #e74c3c; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <h2>ประมวลผลดัชนีมวลกาย BMI</h2>
        <form action="process.php" method="POST">
            <div class="form-group">
                <label>ชื่อ - นามสกุล</label>
                <input type="text" name="fullname" required placeholder="ระบุชื่อและนามสกุล">
            </div>
            
            <div class="form-group">
                <label>วันเกิด</label>
                <input type="date" name="birthdate" required>
            </div>

            <div class="form-group">
                <label>น้ำหนัก (กก.)</label>
                <input type="number" step="0.01" name="weight" required placeholder="เช่น 65.5">
            </div>

            <div class="form-group">
                <label>ส่วนสูง (ซม.)</label>
                <input type="number" step="0.01" name="height" required placeholder="เช่น 170">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">Submit</button>
                <button type="reset" class="btn-clear">Clear</button>
            </div>
        </form>
    </div>

</body>
</html>