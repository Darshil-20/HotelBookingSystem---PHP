<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hbwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`,`name` FROM `rooms`";
$result = $conn->query($sql);
?>

<select name="dropdown">
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
    ?>
</select>

<?php
// Close connection
$conn->close();
?>
