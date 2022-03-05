<?php 

$servername = "db";
$username = "devuser";
$password = "devpass";
$db = 'world_of_garages';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// give connection as parameter to class,
// so in real world scenario this could be mocked for functional tests
$carage = new Carage($conn);

class Carage {

    private $conn;

    private const ALLOWED_COUNTRIES = ['Finland', 'Ukraine'];

    public function __construct(
        $conn
    ) {
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
                CONCAT_WS(" ", latitude, longitude) AS point
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
            die('Bad country! Only these available: ' . implode(', ', self::ALLOWED_COUNTRIES));
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
        $statement = $this->conn->prepare($this->getBaseQuery() .  ' WHERE owner_name=?');
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
        $statement = $this->conn->prepare($this->getBaseQuery() . ' WHERE longitude=? AND latitude=?');
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

$filterArgs = [
    'query' => FILTER_SANITIZE_STRING,
    'country' => FILTER_SANITIZE_STRING,
    'owner' => FILTER_SANITIZE_STRING,
    'location' => FILTER_SANITIZE_STRING,
];

$_GET = filter_var_array($_GET, $filterArgs);

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
        if(empty($_GET['country'])) {
            die(json_encode(
                ['result' => 'Missing parameter: country']
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
        if(empty($_GET['owner'])) {
            die(json_encode(
                ['result' => 'Missing parameter: owner']
            ));
        }
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
            ['result' => 'longitude and latitude required']
        ));
        print(json_encode(
            [
                'result' => true,
                'garages' => $carage->getCaragesByLocation((float) $longitude, (float) $latitude)
            ]
        ));
        break;
    default:
    print(json_encode(
        ['result' => 'Invalid query params']
    ));
    break;
}


?>