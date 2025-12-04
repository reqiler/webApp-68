<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Global & Server Variables</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.8em;
        }
        .container {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 700px;
            margin-bottom: 20px;
        }
        .section-header {
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #34495e;
            font-weight: 600;
        }
        /* Style สำหรับส่วนผลลัพธ์การคำนวณ */
        .result-box {
            background-color: #eafaf1;
            border-left: 5px solid #2ecc71;
            padding: 15px;
            font-size: 1.5em;
            color: #27ae60;
            font-weight: bold;
            border-radius: 4px;
        }
        /* Style สำหรับข้อมูล Server */
        .server-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .server-info-item:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #7f8c8d;
            font-size: 0.9em;
            background-color: #f0f3f4;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .value {
            font-family: 'Courier New', Courier, monospace;
            color: #c0392b;
            word-break: break-all; /* ป้องกันข้อความยาวเกินกรอบ */
            text-align: right;
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <h1>การใช้ $GLOBALS และ $_SERVER</h1>

    <div class="container">
        <div class="section-header">Calculation Result ($GLOBALS)</div>
        <div class="result-box">
            <?php
            $x = 75;
            $y = 25;

            function addition() {
                $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
            }

            addition();
            echo "Z = " . $z;
            ?>
        </div>
    </div>

    <div class="container">
        <div class="section-header">Server Information</div>
        
        <?php
        // สร้างฟังก์ชันเล็กๆ เพื่อช่วยแสดงผลให้สวยงาม (Helper function for formatting)
        function displayServerInfo($label, $value) {
            echo "<div class='server-info-item'>";
            echo "<span class='label'>$label</span>";
            echo "<span class='value'>$value</span>";
            echo "</div>";
        }

        displayServerInfo("PHP_SELF", $_SERVER['PHP_SELF']);
        displayServerInfo("SERVER_NAME", $_SERVER['SERVER_NAME']);
        displayServerInfo("HTTP_HOST", $_SERVER['HTTP_HOST']);
        displayServerInfo("HTTP_USER_AGENT", $_SERVER['HTTP_USER_AGENT']);
        displayServerInfo("SCRIPT_NAME", $_SERVER['SCRIPT_NAME']);
        ?>
        
    </div>

</body>
</html>