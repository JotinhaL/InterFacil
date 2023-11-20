<?php

namespace DAL;

require_once 'DatabaseConnection.php';

use PDO;
use DAL\DatabaseConnection;

class UsuarioDataLayer
{
    public static function createUser(array $userInfo) : bool
    {
        try{
            $sql = "INSERT INTO usuario (id_tipo_usuario, nome, email, senha, dataNascimento, nivelEnsino, statusEnsino, experiencia)
                    VALUES (:tipo_usuario, :nome, :email, :senha, :dataNascimento, :nivelEnsino, :statusEnsino, :experiencia)
            ";

            $conn = DatabaseConnection::getInstance();
            $stmt = $conn->prepare($sql);
            
            $tipo_usuario = $userInfo['tipo_usuario'];
            $nome = $userInfo['nome'];
            $email = $userInfo['email'];
            //lembrar de enviar a senha em sha512, recomendado hashear em sha512 no client
            $new_hashed_password = password_hash($userInfo['senha'], PASSWORD_BCRYPT);
            $dataNascimento = $userInfo['dataNascimento'];
            $nivelEnsino = $userInfo['nivelEnsino'];
            $statusEnsino = $userInfo['statusEnsino'];
            $experiencia = $userInfo['experiencia'];

            //bindParam precisa do valor em uma variavel :(

            $stmt->bindParam(":tipo_usuario", $tipo_usuario);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":senha", $new_hashed_password);
            $stmt->bindParam(":dataNascimento", $dataNascimento);
            $stmt->bindParam(":nivelEnsino", $nivelEnsino);
            $stmt->bindParam(":statusEnsino", $statusEnsino);
            $stmt->bindParam(":experiencia", $experiencia);

            $success = $stmt->execute();
            if($success){
                $id_usuario = $conn->lastInsertId();
                self::createIdiomasUsuario($id_usuario, $userInfo['idiomas']);
            }
            else{
                throw new \Exception("Houve um erro tentando criar o usuario");
            }

            return true;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function getUsuario(?string $email) : array | false
    {
        try{
            $sql = "
                SELECT u.* FROM usuario u
                WHERE u.email = :email;
            ";
            
            $conn = DatabaseConnection::getInstance();
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function updateUser(array $userInfo) : bool
    {
        try{
            $sql = "UPDATE usuario
                    SET id_tipo_usuario = :tipo_usuario,
                        nome = :nome, 
                        email = :email, 
                        dataNascimento = :dataNascimento, 
                        nivelEnsino = :nivelEnsino,
                        statusEnsino = :statusEnsino,
                        experiencia = :experiencia
                    WHERE id = :id
            ";

            $conn = DatabaseConnection::getInstance();
            $stmt = $conn->prepare($sql);

            $tipo_usuario = $userInfo['tipo_usuario'];
            $nome = $userInfo['nome'];
            $email = $userInfo['email'];
            $dataNascimento = $userInfo['dataNascimento'];
            $nivelEnsino = $userInfo['nivelEnsino'];
            $statusEnsino = $userInfo['statusEnsino'];
            $experiencia = $userInfo['experiencia'];
            $id = $userInfo['id'];

            //bindParam precisa do valor em uma variavel :(

            $stmt->bindParam(":tipo_usuario", $tipo_usuario);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":dataNascimento", $dataNascimento);
            $stmt->bindParam(":nivelEnsino", $nivelEnsino);
            $stmt->bindParam(":statusEnsino", $statusEnsino);
            $stmt->bindParam(":experiencia", $experiencia);
            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function createIdiomasUsuario(int $id_usuario, array $idiomas)
    {
        try{
            $conn = DatabaseConnection::getInstance();

            foreach($idiomas as $idioma){
                if(!is_array($idioma))
                    $idioma = get_object_vars($idioma);
                $sql = "INSERT INTO idiomas_usuario (id_usuario, id_idioma, id_fluencia) VALUES(:id_usuario, :id_idioma, :id_fluencia)";
                $stmt = $conn->prepare($sql);

                $id_idioma = $idioma['id_idioma'];
                $id_fluencia = $idioma['id_fluencia'];

                $stmt->bindParam(":id_usuario", $id_usuario); 
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

    public static function deleteIdiomasUsuario(int $id_usuario, array $idiomas)
    {
        try{
            $conn = DatabaseConnection::getInstance();
            foreach($idiomas as $id){
                $sql = "
                    DELETE FROM idiomas_usuario 
                    WHERE id_usuario = :id_usuario AND id_idioma = :id_idioma;
                ";

                $id_idioma = $id['id_idioma'];

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id_usuario", $id_usuario); 
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

    public static function updateIdiomasUsuario(int $id_usuario, array $idiomas)
    {
        try{
            $conn = DatabaseConnection::getInstance();
            foreach($idiomas as $id){
                $sql = "
                    UPDATE idiomas_usuario 
                        SET id_fluencia = :id_fluencia
                    WHERE id_usuario = :id_usuario AND id_idioma = :id_idioma;
                ";

                $id_idioma = $id['id_idioma'];
                $id_fluencia = $id['id_fluencia'];

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id_fluencia", $id_fluencia);   
                $stmt->bindParam(":id_usuario", $id_usuario); 
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

    public static function deleteIdiomasUsuarioById(int $id_usuario)
    {
        try{
            $conn = DatabaseConnection::getInstance();
            $sql = "
                DELETE FROM idiomas_usuario 
                WHERE id_usuario = :id_usuario;
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id_usuario", $id_usuario); 

            $stmt->execute();
            return true;
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function updateSenha(array $loginInfo) : bool
    {
        try{
            $sql = "UPDATE usuario
                    SET senha = :senha
                    WHERE id = :id
            ";

            $conn = DatabaseConnection::getInstance();
            //lembrar de enviar a senha em sha512, recomendado hashear em sha512 no client
            $new_hashed_password = password_hash($loginInfo['senha'], PASSWORD_BCRYPT);
            $id = $loginInfo['id'];

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":senha", $new_hashed_password); 
            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    public static function deleteUser(int $id) : bool
    {
        try{
            $sql = "DELETE FROM usuario
                    WHERE id = :id
            ";

            $conn = DatabaseConnection::getInstance();

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
}
