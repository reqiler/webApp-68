<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Request Variable</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3e5f5; /* พื้นหลังสีม่วงอ่อน */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
            border-top: 5px solid #9c27b0; /* ขอบบนสีม่วงเข้ม */
        }
        h2 {
            color: #6a1b9a;
            margin-top: 0;
            margin-bottom: 25px;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #4a148c;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1bee7;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus {
            border-color: #9c27b0;
            outline: none;
            box-shadow: 0 0 5px rgba(156, 39, 176, 0.3);
        }
        input[type="submit"] {
            background-color: #9c27b0;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #7b1fa2;
        }
        .result-display {
            margin-top: 25px;
            padding: 15px;
            background-color: #f3e5f5;
            border-radius: 8px;
            border-left: 5px solid #8e24aa;
            text-align: left;
            color: #4a148c;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>$_REQUEST Handling</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" placeholder="Enter your name...">
            </div>
            
            <div class="input-group">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" placeholder="Enter your lastname...">
            </div>
            
            <input type="submit" value="Send Request">
        </form>

        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_REQUEST['fname'];
            $surname = $_REQUEST['lname'];

            // ตรวจสอบว่ามีข้อมูลส่งมาหรือไม่ เพื่อแสดงกล่องผลลัพธ์
            if (!empty($name) || !empty($surname)) {
                echo "<div class='result-display'>";
                if (empty($name)) {
                    echo "<strong>Status:</strong> Name is empty";
                } else {
                    echo "<strong>Full Name:</strong> " . $name . " " . $surname;
                }
                echo "</div>";
            }
        }
        ?>
    </div>
</body>

</html>