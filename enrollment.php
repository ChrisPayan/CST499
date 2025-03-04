<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Page</title>
</head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <h1>Class Registration</h1>
            <form action="enroll.php" method="post">

                <label for="courseName">Course Name:</label>
                <input type="text" id="courseName" name="courseName" required><br><br>

                <label for="semester">Semester:</label>
                <select id="semester" name="semester" required>
                    <option value="Fall">Fall</option>
                    <option value="Spring">Spring</option>
                    <option value="Summer">Summer</option>
                </select>

                <button type="submit">Enroll</button>

            </form>
        </main>
    </body>
</html>