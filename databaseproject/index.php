<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $librarian_code = mysqli_real_escape_string($conn, $_POST['lid']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    $sql = "SELECT * FROM librarians
            WHERE librarian_code='$librarian_code'
            AND librarian_name='$name'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        $_SESSION['librarian_id'] = $row['librarian_id'];
        $_SESSION['librarian_name'] = $row['librarian_name'];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid Librarian Code, Name, or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Login</h1>

<section>
    <form class="loginform" method="POST" action="">

        <div>
            <label for="lid">Librarian Code</label>
            <input type="text" name="lid" id="lid"
                   placeholder="LI0000000002" required>
        </div>

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   placeholder="John" required>
        </div>

        <div>
            <label for="pass">Password</label>
            <input type="password" name="pass"
                   id="pass" placeholder="********" required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>

        <?php
        if (!empty($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>

    </form>
</section>

</body>
</html>