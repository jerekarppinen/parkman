<?php 

$servername = "db";
$username = "devuser";
$password = "devpass";
$db = 'world_of_garages';

class Carage {

    private $conn;

    private const ALLOWED_COUNTRIES = ['Finland', 'Ukraine'];

    public function __construct(
        string $servername,
        string $username,
        string $password,
        string $db
    ) {
        $conn = new mysqli($servername, $username, $password, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $this->conn = $conn;
    }

    public function getAllCarages(): array
    {
        $query = $this->conn->query('SELECT * FROM garages ORDER BY id ASC;');

        $results = [];

        while($row = $query->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function getCaragesByCountry(string $country): string
    {
        if(!in_array($country, self::ALLOWED_COUNTRIES)) {
            return 'Bad country! Only these available: ' . implode(', ', self::ALLOWED_COUNTRIES);
        }

        $statement = $this->conn->prepare('SELECT * FROM garages WHERE country=?');
        $statement->bind_param('s', $country);
        $statement->execute();
        $result = $statement->get_result();

        $results = [];

        while($row = $result->fetch_assoc()) {
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

// Todo: sanitize inputs
switch($_GET['query']) {
    case 'all':
        print(json_encode(
            $response = [
                'result' => true,
                'garages' => $carage->getAllCarages()
            ]
        ));
        break;
    case 'country':
        print($carage->getCaragesByCountry($_GET['country']));
        break;
}


?>