<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدروس</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: center;
        }
        ul {
            list-style-type: none;
        }
        li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>الدروس المتاحة</h1>
    <?php
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=" . __DIR__ . "/data/your_database.accdb;";
    try {
        $conn = new PDO($dsn);
        $stmt = $conn->query("SELECT المادة, عنوان, الرابط FROM الدروس");
        $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($lessons) {
            echo "<ul>";
            foreach ($lessons as $lesson) {
                echo "<li>المادة: " . $lesson['المادة'] . " - <a href='" . $lesson['الرابط'] . "' target='_blank'>" . $lesson['عنوان'] . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>لا توجد دروس متاحة حاليًا.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>حدث خطأ أثناء الاتصال بقاعدة البيانات: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
