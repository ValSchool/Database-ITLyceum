    <?php
    class DB {
    private $pdo;
    protected $stmt;

    public function __construct($db, $host = "localhost", $port = "3306", $user = "root", $pass = "") {
        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }
    public function exec($sql, $placeholders = null) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt;
    }
    public function read($fields, $table, $conditions, $values) {
        $sql = "SELECT $fields FROM $table WHERE $conditions LIMIT 1"; // Limit to 1 row
        $stmt = $this->pdo->prepare($sql);
        foreach ($values as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch only one row
    }
    
    
}

$myDb = new DB('itlyceum');
