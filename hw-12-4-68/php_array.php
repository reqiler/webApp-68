<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Array-04/12/2568</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 30px;
            font-size: 1.5em;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        ul {
            list-style-type: square;
            background-color: #eef2f3;
            padding: 15px 15px 15px 35px;
            border-radius: 5px;
        }
        li {
            margin-bottom: 5px;
        }
        .code-output {
            font-family: 'Courier New', Courier, monospace;
            color: #d35400;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <h1>ทดสอบ Array แบบ Index Array</h1>
        <?php
        $cars = array("Volvo", "BMW", "Toyota");
        echo "I like <span class='code-output'>" . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . "</span>.";
        ?>
    </div>

    <div class="container">
        <h1>ทดสอบ Array แบบ Associative Array</h1>
        <?php
        $age = array("Peter" => "35", "Ben" => "37", "Joe" => "43", "Mon" => "19");
        echo "Peter is " . $age['Peter'] . " years old.<br>\n";
        echo "Ben is " . $age['John'] . " years old.<br>\n";
        echo "Joe is " . $age['Jin'] . " years old.<br>\n";
        echo "Mon is " . $age['Jane'] . " years old.";
        ?>

        <hr>
        <strong>Loop Output:</strong><br>
        <?php
        foreach ($age as $x => $x_value) {
            echo "Key=" . $x . ", Value=" . $x_value;
            echo "<br>\n";
        }
        ?>
    </div>

    <div class="container">
        <h1>ใช้คำสั่ง for loop กับ Index array</h1>
        <?php
        $fruit = array("แอปเปิ้ล", "องุ่น", "มะละกอ", "มะม่วง", "ส้ม");

        echo "<b>For Loop:</b><br>";
        for ($x = 0; $x < count($fruit); $x++) {
            echo $fruit[$x];
            echo "<br>\n";
        }
        ?>
        <br>
        <?php
        echo "<b>Foreach Loop:</b><br>";
        foreach ($fruit as $value) {
            echo $value;
            echo "<br>\n";
        }
        ?>
    </div>

    <div class="container">
        <h1>การใช้ Array 2 มิติ (Two-Dimension Array)</h1>
        <?php
            $cars = array(
                array("Volvo", 22, 18),
                array("BMW",15,13),
                array("Saab",5,2),
                array("Land Rover",17,15)
            )
        ?>

        <?php
            $rows = count($cars);
            for($row = 0; $row < $rows ; $row++){
                echo "<p><b>Row number $row</b></p>";
                echo "<ul>";
                $cols = count($cars[$row]);
                for($col = 0; $col < $cols ; $col++){
                    echo "<li>".$cars[$row][$col]."</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>

</body>
</html>