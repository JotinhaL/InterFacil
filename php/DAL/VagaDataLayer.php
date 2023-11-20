<?php

namespace DAL;

require_once 'DatabaseConnection.php';

use PDO;
use DAL\DatabaseConnection;

class VagaDataLayer
{
    public static function createVaga(array $vaga) : bool
    {
        try{
            $sql = "INSERT INTO vaga (nome, descricao, nivelEnsino, statusEnsino)
                    VALUES (:nome, :descricao, :nivelEnsino, :statusEnsino)
            ";

            $conn = DatabaseConnection::getInstance();
            $stmt = $conn->prepare($sql);
            
            $nome = $vaga['nome'];
            $descricao = $vaga['descricao'];
            $nivelEnsino = $vaga['nivelEnsino'];
            $statusEnsino = $vaga['statusEnsino'];

            //bindParam precisa do valor em uma variavel :(

            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":nivelEnsino", $nivelEnsino);
            $stmt->bindParam(":statusEnsino", $statusEnsino);
            
            $success = $stmt->execute();
            if($success){
                $id_vaga = $conn->lastInsertId();
                self::createIdiomasVaga($id_vaga, $vaga['idiomas']);
            }
            else{
                throw new \Exception("Houve um erro tentando criar a vaga");
            }
            
            return true;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getVagas(?int $limit = 0) : array | false
    {
        try{

            $sql = "
                SELECT v.* FROM vaga v
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

    public static function createIdiomasVaga(int $id_vaga, array $idiomas)
    {
        try{
            $conn = DatabaseConnection::getInstance();
            foreach($idiomas as $idioma){
                if(!is_array($idioma))
                    $idioma = get_object_vars($idioma);

                $sql = "INSERT INTO idiomas_vaga (id_vaga, id_idioma, id_fluencia) VALUES(:id_vaga, :id_idioma, :id_fluencia)";
                $stmt = $conn->prepare($sql);

                $id_idioma = $idioma['id_idioma'];
                $id_fluencia = $idioma['id_fluencia'];

                $stmt->bindParam(":id_vaga", $id_vaga); 
                $stmt->bindParam(":id_idioma", $id_idioma);
                $stmt->bindParam(":id_fluencia", $id_fluencia);

                $stmt->execute();
            }

            return true;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function deleteIdiomasVaga(int $id_vaga, array $idiomas)
    {
        try{
            $conn = DatabaseConnection::getInstance();
            foreach($idiomas as $id_idioma){
                $sql = "DELETE FROM idiomas_vaga WHERE id_vaga = :id_vaga AND id_idioma = :id_idioma";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id_vaga", $id_vaga); 
                $stmt->bindParam(":id_idioma", $id_idioma);   

                $stmt->execute();
            }

            return true;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
}
