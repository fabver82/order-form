<?php
require('../utilities/DatabaseManager.php');
// This class is focussed on dealing with queries for one type of data
// That allows for easier re-using and it's rather easy to find all your queries
// This technique is called the repository pattern
class FoodModel
{
    private DatabaseManager $databaseManager;

    // This class needs a database connection to function
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
        $this->databaseManager->connect();
    }

    public function create(): void
    {
    }

    // Get one
    public function find($id): array
    {
        $q = $this->databaseManager->connection->prepare("SELECT * FROM products WHERE id=:id");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        $q->bindParam(":id", $id, PDO::PARAM_INT);

        // execute return a boolean
        if (!$q->execute()) {
            die("couldn\'t get a product");
        }

        return $q->fetch(PDO::FETCH_ASSOC);
    }

    // Get all
    public function get(): array
    {
        // TODO: replace dummy data by real one
        $q = $this->databaseManager->connection->prepare("SELECT * FROM products");

        // bindParam() accepte uniquement une variable qui est interprétée au moment de l'execute()
        // $q->bindParam(":id", $id, PDO::PARAM_INT);

        // execute return a boolean
        if (!$q->execute()) {
            die("couldn\'t get a product");
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