<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Handling</title>
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
            width: 300px;
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* ให้ padding ไม่ดันความกว้าง */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            border-radius: 5px;
            color: #2e7d32;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>PHP Form POST</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div style="text-align: left;">Name:</div>
            <input type="text" name="fname" placeholder="Your Name">
            
            <div style="text-align: left;">LastName:</div>
            <input type="text" name="lname" placeholder="Your Lastname">
            
            <input type="submit" value="Submit Data">
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['fname'];
                $surname = $_POST['lname'];

                if (!empty($name) || !empty($surname)) {
                    echo "<div class='result'>";
                    if (empty($name)) {
                        echo "Name is empty";
                    } else {
                        echo "Hello, " . $name . " " . $surname;
                    }
                    echo "</div>";
                }
            }
        ?>
    </div>
</body>

</html>