<?php

namespace Controllers;

require_once 'BaseController.php';
require_once __DIR__ . '/../DAL/UsuariosDataLayer.php';
require_once __DIR__ . '/../DAL/GeralDataLayer.php';

use DAL\GeralDataLayer;
use DAL\UsuarioDataLayer;

class LoginController extends BaseController
{
    public function login()
    {
        $method = strtoupper($this->getMethod());
        if($method != 'POST')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $response = array();
        $data = $this->getRequestData();

        $user = UsuarioDataLayer::getUsuario($data['email']);

        if(!$user){
            $this->setError(400, "Não foi possível encontrar este usuário.", $response);
            $this->returnJson($response, 400);
        }

        $senha_coincide = password_verify($data['senha'], $user['senha']);

        if(!$senha_coincide){
            $this->setError(400, "Senha Incorreta.", $response);
            $this->returnJson($response, 400);
        }

        $this->returnJson($response, 200);
    }

    public function meu_perfil(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $response = array();
        $data = $this->getRequestData();

        $user = UsuarioDataLayer::getUsuario($data['email']);

        if(!$user){
            $this->setError(400, "Não foi possível encontrar este usuário.", $response);
            $this->returnJson($response, 400);
        }

        $nivel_ensino = GeralDataLayer::getNivelEnsinoById($user['nivelEnsino']);
        $status_ensino = GeralDataLayer::getStatusEnsinoById($user['statusEnsino']);
        $idiomas = GeralDataLayer::getIdiomasByUser($user['id']);

        $response['user'] = array(
            "id" => $user['id'],
            "nome" => $user['nome'],
            "email" => $user['email'],
            "experiencia" => $user['experiencia'],
            "dataNascimento" => $user['dataNascimento'],
            "nivelEnsino" => $nivel_ensino['nome'],
            "statusEnsino" => $status_ensino['nome'],
            "idiomas" => $idiomas,
        );
        
        $this->returnJson($response, 200);
    }

    public function getperfil(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $response = array();
        $data = $this->getRequestData();

        $user = UsuarioDataLayer::getUsuario($data['email']);

        if(!$user){
            $this->setError(400, "Não foi possível encontrar este usuário.", $response);
            $this->returnJson($response, 400);
        }

        $nivel_ensino = GeralDataLayer::getNivelEnsinoById($user['nivelEnsino']);
        $status_ensino = GeralDataLayer::getStatusEnsinoById($user['statusEnsino']);
        $idiomas = GeralDataLayer::getIdiomasByUser($user['id']);

        $response['user'] = array(
            "id" => $user['id'],
            "id_tipo_usuario" => $user['id_tipo_usuario'],
            "nome" => $user['nome'],
            "email" => $user['email'],
            "experiencia" => $user['experiencia'],
            "dataNascimento" => $user['dataNascimento'],
            "idNivelEnsino" => $nivel_ensino['id'],
            "nivelEnsino" => $nivel_ensino['nome'],
            "idStatusEnsino" => $status_ensino['id'],
            "statusEnsino" => $status_ensino['nome'],
            "idiomas" => $idiomas,
        );
        
        $this->returnJson($response, 200);
    }

    public function editarPerfil(){
        $method = strtoupper($this->getMethod());
        if($method != 'POST')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $response = array();
        $data = $this->getRequestData();

        $user = UsuarioDataLayer::getUsuario($data['email']);

        UsuarioDataLayer::updateUser($data);

        $idiomas = GeralDataLayer::getIdiomasByUser($user['id']);
        $idiomasFront = $data['idiomas'];

        foreach($idiomas as $idioma){
            $mantem_idioma = false;
            foreach($idiomasFront as $idi){
                if(!is_array($idi))
                    $idi = get_object_vars($idi);

                if($idioma['id_idioma'] == $idi['id_idioma']){
                    $mantem_idioma = true;
                    UsuarioDataLayer::updateIdiomasUsuario($user['id'], array($idi));
                }
            }

            if(!$mantem_idioma){
                UsuarioDataLayer::deleteIdiomasUsuario($user['id'], array($idioma));
            }
        }

        $this->returnJson($response, 200);
    }
}