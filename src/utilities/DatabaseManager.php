<?php

// This class will manage the connection to the database
// It will be passed on the other classes who need it
class DatabaseManager
{
    // These are private: only this class needs them
    private string $host;
    private string $user;
    private string $password;
    private string $dbname;
    private int $port;
    // This one is public, so we can use it outside of this class
    // We could also use a private variable and a getter (but let's not make things too complicated at this point)
    public PDO $connection;

    public function __construct(string $host, string $user, string $password, string $dbname, int $port)
    {
        // TODO: Set any user and password information
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
    }

    public function connect(): void
    {
        // TODO: make the connection to the database
        try {

            // We create a new instance of the class PDO
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=" . $this->port, $this->user, $this->password);

            //We want any issues to throw an exception with details, instead of a silence or a simple warning
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            // We intantiate an Exception object in $e so we can use methods within this object to display errors nicely
            echo $e->getMessage();
            $this->connection = null;
            exit;
        }
    }
}