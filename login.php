<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    
    <?php include 'header.php'; ?>
    <main>
        <h1>Login</h1>
        <form action="login_process.php" method="post">
            
            <?php if (isset($_GET['error'])) { ?>
                <p style="color: red;"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label for="userID">userID:</label>
            <input type="text" id="userID" name="userID" required><br><br>

            <label for="password">Password:</label>
            <input  type="password" id="password" name="password" required><br><br>   


            <button type="submit">Login</button>
        </form>

    </main>
</body>
</html>