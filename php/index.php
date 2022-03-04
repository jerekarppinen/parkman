<?php 

$servername = "db";
$username = "devuser";
$password = "devpass";
$db = 'world_of_garages';

class Carage {

    private $conn;

    public function __construct(
        string $servername,
        string $username,
        string $password,
        string $db
    ) {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $this->conn = $conn;
    }

    public function getAllCarages(): string
    {
        $query = $this->conn->query('SELECT * FROM garages ORDER BY id ASC;');

        $results = [];

        while($row = $query->fetch_assoc()) {
            $results[] = $row;
        }

        return json_encode($results);
    }
}

$carage = new Carage(
    $servername,
    $username,
    $password,
    $db
);

switch($_GET['query']) {
    case 'all':
        print($carage->getAllCarages());
        break;
}


?>