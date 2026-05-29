<?php
$conn = mysqli_connect("localhost","root","","secure_auth");
if (!$conn) {
    echo "DBFAIL";
    exit(1);
}
$res = $conn->query("SELECT id,email,role FROM users");
while ($row = $res->fetch_assoc()) {
    echo $row["id"] . "|" . $row["email"] . "|" . $row["role"] . "\n";
}
