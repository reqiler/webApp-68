<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome (GET)</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eaf2f8; /* พื้นหลังสีฟ้าอ่อน */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
            border-top: 5px solid #3498db; /* เส้นขอบบนสีฟ้า */
        }
        h1 {
            color: #2c3e50;
            margin-top: 0;
            font-size: 24px;
        }
        .content {
            margin-top: 20px;
            color: #555;
            line-height: 1.6;
            text-align: left;
        }
        .data-highlight {
            color: #2980b9;
            font-weight: bold;
            font-size: 1.1em;
        }
        .icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon">👋</div>
        <h1>Welcome!</h1>
        
        <div class="content">
            Hello, <span class="data-highlight"><?php echo $_GET["name"]; ?></span>
            <br>
            Your email address is: <span class="data-highlight"><?php echo $_GET["email"]; ?></span>
        </div>

        <a href="javascript:history.back()" class="btn-back">Go Back</a>
    </div>

</body>
</html>