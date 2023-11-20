<?php
/**
 * =============================================================================================
 *                Arquivo de configuração do banco de dados/PDO e da const BASE_URL 
 * =============================================================================================
 */
namespace Config;

class Config {
    public function __construct(){}

    public static function getConfig(){
        $config = array();

        define('BASE_URL', 'http://localhost/ppi/php/');
        $config['dbname'] = 'intercambio';
        $config['host'] = 'localhost';
        $config['dbuser'] = 'root';
        $config['dbpass'] = '';

        return $config;
    }
}