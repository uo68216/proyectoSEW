<?php
declare(strict_types=1);
require_once __DIR__ . '/DatabaseException.php';
require_once __DIR__ . '/../util/Debug.php';
class Db {
    private static ?PDO $instance = null;

    public static function getConexion(): \PDO {
        if (self::$instance === null) {
            try {
                $config = parse_ini_file(__DIR__ . '\configDB.ini');
                Debug::log(['config =' => $config]);
                $server = $config['server'];
                $database = $config['database'];
                $user = $config['user'];
                $pass = $config['pass'];
                $charset = $config['charset'];
                $dsn = "mysql:host=$server;dbname=$database;charset=$charset";
                Debug::log(['dsn =' => $dsn]);
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                Debug::log(['DB Connection Error' => $e->getMessage()]);
                throw new DatabaseException('Error al conectar con la base de datos.');
            }
        }
        return self::$instance;
    }

    public static function reset(): void {
        self::$instance = null;
    }
}