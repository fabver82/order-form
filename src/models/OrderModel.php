<?php

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
        //var_dump('coming in');
        $data = [
            'email' => $email,
            'street' => $street,
            'streetNumber' => $streetNumber,
            'city' => $city,
            'zipcode' => $zipcode,
        ];
        $sql = "INSERT INTO orders (email, street, streetNumber,city,zipcode) VALUES (:email, :street, :streetNumber,:city,:zipcode)";
        $stmt = $this->databaseManager->connection->prepare($sql);

        foreach ($data as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        if (!$stmt->execute()) {
            die("couldn\'t create an order");
        };
        $id = $this->databaseManager->connection->lastInsertId();

        //to be refactored with OrderModel->addToOrder()
        $sql = "INSERT INTO order_product (id_order,id_product) VALUES (:id_order, :id_product)";
        $stmt = $this->databaseManager->connection->prepare($sql);
        foreach ($products as $product) {
            $data = [
                'id_order' => $id,
                'id_product' => $product,
            ];
            if (!$stmt->execute($data)) {
                die("couldn\'t add a product to the order");
            };
        }

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
        $order = $q->fetch(PDO::FETCH_ASSOC);

        $q = $this->databaseManager->connection->prepare("SELECT id_product FROM order_product WHERE id_order=:id");
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        if (!$q->execute()) {
            die("couldn\'t get an order");
        }
        $order['products'] = $q->fetchAll(PDO::FETCH_COLUMN);
        return $order;
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