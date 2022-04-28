<?php
require('../utilities/DatabaseManager.php');
// This class is focussed on dealing with queries for one type of data
// That allows for easier re-using and it's rather easy to find all your queries
// This technique is called the repository pattern
class OrderModel
{
    private DatabaseManager $databaseManager;

    // This class needs a database connection to function
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
        $this->databaseManager->connect();
    }

    public function create($email, $street, $streetNumber, $city, $zipcode, $products): int
    {
        $data = [
            'email' => $email,
            'street' => $street,
            'streetNumber' => $streetNumber,
            'city' => $city,
            'zipcode' => $zipcode,
            'products' => $products,
        ];
        $sql = "INSERT INTO orders (email, street, streetNumber,city,zipcode,products) VALUES (:email, :street, :streetNumber,:city,:zipcode,:products)";
        $stmt = $this->databaseManager->connection->prepare($sql);
        if (!$stmt->execute($data)) {
            die("couldn\'t create an order");
        };
        $id = $this->databaseManager->connection->lastInsertId();
        return $id;
    }

    // Get one
    public function find($id): array
    {
        $q = $this->databaseManager->connection->prepare("SELECT * FROM orders WHERE id=:id");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        $q->bindParam(":id", $id, PDO::PARAM_INT);

        // execute return a boolean
        if (!$q->execute()) {
            die("couldn\'t get an order");
        }

        return $q->fetch(PDO::FETCH_ASSOC);
    }

    // Get all
    public function get(): array
    {
        // TODO: replace dummy data by real one
        $q = $this->databaseManager->connection->prepare("SELECT * FROM orders");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        // $q->bindParam(":id", $id, PDO::PARAM_INT);

        // execute return a boolean
        if (!$q->execute()) {
            die("couldn\'t get an order");
        }

        return $q->fetch(PDO::FETCH_ASSOC);

        // We get the database connection first, so we can apply our queries with it
        // return $this->databaseManager->connection-> (runYourQueryHere)
    }

    public function update(): void
    {
    }

    public function delete(): void
    {
    }
}