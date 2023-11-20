<?php

namespace DAL;

require_once 'DatabaseConnection.php';

use PDO;
use DAL\DatabaseConnection;

class GeralDataLayer
{
    public static function getTipoUsuario(?int $limit = 0) : array
    {
        try{

            $sql = "
                SELECT te.* FROM tipo_usuario te
            ";

            if($limit != 0){
                $sql.= "LIMIT {$limit}";
            }

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
    public static function getTipoUsuarioById(?int $id) : array
    {
        try{
            $conn = DatabaseConnection::getInstance();

            $result = $conn->query("SELECT te.* FROM tipo_usuario te WHERE id = {$id}");

            return $result->fetch();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getNivelEnsino(?int $limit = 0) : array
    {
        try{

            $sql = "
                SELECT ne.* FROM nivel_ensino ne
            ";

            if($limit != 0){
                $sql.= "LIMIT {$limit}";
            }

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getNivelEnsinoById(?int $id) : array
    {
        try{
            $conn = DatabaseConnection::getInstance();

            $result = $conn->query("SELECT ne.* FROM nivel_ensino ne WHERE ne.id = {$id}");

            return $result->fetch();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getStatusEnsino(?int $limit = 0) : array
    {
        try{

            $sql = "
                SELECT se.* FROM status_ensino se
            ";

            if($limit != 0){
                $sql.= "LIMIT {$limit}";
            }

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getStatusEnsinoById(?int $id) : array
    {
        try{
            $conn = DatabaseConnection::getInstance();

            $result = $conn->query("SELECT se.* FROM status_ensino se WHERE se.id = {$id}");

            return $result->fetch();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getIdiomas(?int $limit = 0) : array
    {
        try{

            $sql = "
                SELECT i.* FROM idioma i
            ";

            if($limit != 0){
                $sql.= "LIMIT {$limit}";
            }

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getIdiomasByUser(?int $id_usuario) : array
    {
        try{

            $sql = "SELECT 
                        i.id as id_idioma,
                        i.nome as idioma, 
                        f.id as id_fluencia,
                        f.nome as fluencia 
                    FROM idiomas_usuario iu 
                    INNER JOIN idioma i ON iu.id_idioma = i.id 
                    INNER JOIN fluencia f ON iu.id_fluencia = f.id 
                    WHERE iu.id_usuario = {$id_usuario}";

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getIdiomasByVaga(?int $id_vaga) : array
    {
        try{

            $sql = "SELECT i.nome as idioma, f.nome as fluencia 
                    FROM idiomas_vaga iv 
                    INNER JOIN idioma i ON iv.id_idioma = i.id 
                    INNER JOIN fluencia f ON iv.id_fluencia = f.id 
                    WHERE iv.id_vaga = {$id_vaga}";

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getFluencia(?int $limit = 0) : array
    {
        try{

            $sql = "
                SELECT f.* FROM fluencia f
            ";

            if($limit != 0){
                $sql.= "LIMIT {$limit}";
            }

            $conn = DatabaseConnection::getInstance();

            $result = $conn->query($sql);

            $data = array();

            while($row = $result->fetch())
                $data[] = $row;

            return $data;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
}
