
<?php 
    use Dotenv\Dotenv;
    require_once realpath(__DIR__ . "/vendor/autoload.php");    
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $server = getenv('DB_HOST'); //localhost
    $username = getenv('DB_USER'); //root
    $password = getenv('DB_PASS'); //
    $datebase = getenv('DB_NAME'); // nombreDeLaBaseDeDatos

    try {
        $conn = new PDO("mysql:host=$server;dbname=$datebase;",$username, $password);
        
    } catch (PDOException $e) {
        die('Connection Failed: ' . $e->getMessage());
    }
    

?>