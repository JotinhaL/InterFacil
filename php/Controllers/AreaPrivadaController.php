<?php

namespace Controllers;

require_once 'BaseController.php';
require_once __DIR__ . '/../DAL/UsuariosDataLayer.php';
require_once __DIR__ . '/../DAL/VagaDataLayer.php';
require_once __DIR__ . '/../DAL/GeralDataLayer.php';

use DAL\GeralDataLayer;
use DAL\UsuarioDataLayer;
use DAL\VagaDataLayer;

class AreaPrivadaController extends BaseController
{
    public function getUserInfo(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $data = $this->getRequestData();
        $user = UsuarioDataLayer::getUsuario($data['email']);

        $response = array("data" => $user);

        $this->returnJson($response, 200);
    }

    public function buscar_vagas(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $data = $this->getRequestData();
        $vagas = VagaDataLayer::getVagas($data['limit'] ?? 0);

        $vagas_formatted = array();
        foreach($vagas as $v){
            $v = array(
                "nome" => $v['nome'],
                "descricao" => $v['descricao'],
                "nivelEnsino" => GeralDataLayer::getNivelEnsinoById($v['nivelEnsino'])['nome'],
                "statusEnsino" => GeralDataLayer::getStatusEnsinoById($v['statusEnsino'])['nome'],
                "idiomas" => GeralDataLayer::getIdiomasByVaga($v['id']),
            );

            $vagas_formatted[] = $v;
        }

        $response = array("vagas" => $vagas_formatted);

        $this->returnJson($response, 200);
    }

    public function cadastrar_vagas(){
        $method = strtoupper($this->getMethod());
        if($method != 'POST')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $data = $this->getRequestData();

        $success = VagaDataLayer::createVaga($data);

        $this->returnJson(array(), $success ? 200 : 500);
    }

    public function excluir_usuario(){
        $method = strtoupper($this->getMethod());
        if($method != 'POST')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $data = $this->getRequestData();

        //$data = get_object_vars($data['id']);
        $success = UsuarioDataLayer::deleteIdiomasUsuarioById($data['id']);
        $success = UsuarioDataLayer::deleteUser($data['id']);


        $this->returnJson(array(), $success ? 200 : 500);
    }
}