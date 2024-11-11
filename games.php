<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("location: index.php");
    exit;
}
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "softball";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Softball Games</title>
    </head>
    <body>
        <h1>Softball Games</h1>
        <?php
        $sql = "SELECT * FROM games ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Opponent</th>
                        <th>Site</th>
                        <th>Result</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['opponent'] . "</td>";
                echo "<td>" . $row['site'] . "</td>";
                echo "<td>" . $row['result'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No games found.";
        }

        $conn->close();
        ?>
        <a href="index.php">Home</a>

    </body>
</html>
