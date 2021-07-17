<?php  
    @include_once('config.php');
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        exit('Error!: ' . $e->getMessage());
    }
?>  
