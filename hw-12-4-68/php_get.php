<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Single Page Form (GET)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }
        input[type="submit"] {
            background-color: #3498db; /* สีฟ้าสำหรับ GET */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .result-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #eaf2f8;
            border: 1px solid #d6eaf8;
            border-radius: 5px;
            color: #2c3e50;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Form Handling (Self)</h2>
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="fname">Name:</label>
                <input type="text" id="fname" name="fname" placeholder="Enter Name">
            </div>
            
            <div class="form-group">
                <label for="lname">LastName:</label>
                <input type="text" id="lname" name="lname" placeholder="Enter Last Name">
            </div>
            
            <input type="submit" value="Submit Data">
        </form>

        <?php
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            // เช็คว่ามีการส่งค่า fname และ lname มาหรือไม่ เพื่อไม่ให้ Error ตอนเปิดหน้าเว็บครั้งแรก
            if (isset($_GET['fname']) && isset($_GET['lname'])) {
                $name = $_GET['fname'];
                $surname = $_GET['lname'];

                // ตรวจสอบว่าได้กรอกข้อมูลมาหรือไม่ ก่อนแสดงผล
                if (!empty($name) || !empty($surname)) {
                    echo "<div class='result-box'>";
                    if (empty($name)) {
                        echo "<b>Result:</b> Name is empty";
                    } else {
                        echo "<b>Result:</b> " . $name . " " . $surname;
                    }
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
</body>

</html>