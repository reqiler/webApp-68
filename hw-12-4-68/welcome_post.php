<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome (POST)</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f5e9; /* พื้นหลังสีเขียวอ่อน */
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
            border-top: 5px solid #4CAF50; /* เส้นขอบบนสีเขียว */
        }
        h1 {
            color: #2e7d32;
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
            color: #43a047; /* สีตัวอักษรเขียว */
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
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon">✅</div>
        <h1>Submission Success!</h1>
        
        <div class="content">
            Welcome <span class="data-highlight"><?php echo $_POST["name"]; ?></span>
            <br>
            Your email address is: <span class="data-highlight"><?php echo $_POST["email"]; ?></span>
        </div>

        <a href="javascript:history.back()" class="btn-back">Go Back</a>
    </div>

</body>
</html>