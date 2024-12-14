<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتائج الطلاب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <h1>عرض نتائج الطلاب</h1>
    <form method="post">
        <label for="seatNumber">أدخل رقم الجلوس:</label>
        <input type="text" id="seatNumber" name="seatNumber" required>
        <button type="submit">عرض النتيجة</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $seatNumber = $_POST['seatNumber'];

        // إعداد الاتصال بقاعدة البيانات
        $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=" . __DIR__ . "/data/your_database.accdb;";
        try {
            $conn = new PDO($dsn);
            $stmt = $conn->prepare("SELECT المادة, الدرجة FROM النتائج WHERE رقم_الجلوس = ?");
            $stmt->execute([$seatNumber]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<h2>نتائج الطالب:</h2><ul>";
                foreach ($results as $result) {
                    echo "<li>المادة: " . $result['المادة'] . " - الدرجة: " . $result['الدرجة'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>لم يتم العثور على نتائج لهذا الرقم.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>حدث خطأ أثناء الاتصال بقاعدة البيانات: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>
