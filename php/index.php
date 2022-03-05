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

    private function getBaseQuery() : string
    {
        return '
            SELECT
                garage_id,
                garage_name,
                owners.owner_id,
                owners.owner_name,
                hourly_price,
                currency,
                contact_email,
                country,
                latitude,
                longitude
            FROM garages
            INNER JOIN owners
            ON garages.owner_id = owners.owner_id
        ';
    }

    public function getAllCarages(): array
    {
        $query = $this->conn->query($this->getBaseQuery());

        $results = [];

        while($row = $query->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function getCaragesByCountry(string $country): array
    {
        // just for the lols
        if(!in_array($country, self::ALLOWED_COUNTRIES)) {
            return 'Bad country! Only these available: ' . implode(', ', self::ALLOWED_COUNTRIES);
        }

        $statement = $this->conn->prepare($this->getBaseQuery() . ' WHERE country=?');
        $statement->bind_param('s', $country);
        $statement->execute();
        $result = $statement->get_result();

        $results = [];

        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function getCaragesByOwner(string $owner): array
    {
        $statement = $this->conn->prepare('SELECT * FROM garages WHERE owner_name=?');
        $statement->bind_param('s', $owner);
        $statement->execute();
        $result = $statement->get_result();

        $results = [];

        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function getCaragesByLocation(float $longitude, float $latitude): array
    {
        $statement = $this->conn->prepare('SELECT * FROM garages WHERE longitude=? AND latitude=?');
        $statement->bind_param('dd', $longitude, $latitude);
        $statement->execute();
        $result = $statement->get_result();

        $results = [];

        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
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
            [
                'result' => true,
                'garages' => $carage->getAllCarages()
            ]
        ));
        break;
    case 'country':
        if(!isset($_GET['country'])) {
            die(json_encode(
                ['status' => 'Missing parameter: country']
            ));
        }
        print(json_encode(
            [
                'result' => true,
                'garages' => $carage->getCaragesByCountry($_GET['country'])
            ]
        ));
        break;
    case 'owner':
        print(json_encode(
            [
                'result' => true,
                'garages' => $carage->getCaragesByOwner($_GET['owner'])
            ]
        ));
        break;
    case 'location':
        [$longitude, $latitude] = explode(',', $_GET['location']);
        if(empty($longitude) || empty($latitude)) die(json_encode(
            ['status' => 'longitude and latitude required']
        ));
        print(json_encode(
            [
                'result' => true,
                'garages' => $carage->getCaragesByLocation((float) $longitude, (float) $latitude)
            ]
        ));
        break;
}


?>