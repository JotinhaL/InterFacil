<?php
/**
 * =============================================================================================
 *                Arquivo de instanciação do banco de dados/PDO e da const BASE_URL 
 * =============================================================================================
 */
namespace DAL;
require_once __DIR__.'/../Config/config.php';

use PDO;
use PDOException;
use config\Config;

// design pattern : Singleton
class DatabaseConnection
{
    private static PDO $db;
    
    private function __construct() { }
    private function __clone() { }

    public static function getInstance(){
        if(empty(self::$db)){
            try {
                $config = Config::getConfig();

                self::$db = new PDO(
                    "mysql:dbname={$config['dbname']};host={$config['host']}",
                    $config['dbuser'],
                    $config['dbpass'],
                    array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
                );
            } catch (PDOException $e) {
                die($e->getMessage());
                exit();
            }
        }

        return self::$db;
    }
}