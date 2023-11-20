<?php

namespace Controllers;

require_once 'BaseController.php';
require_once __DIR__ . "/../DAL/UsuariosDataLayer.php";
require_once __DIR__ . "/../DAL/GeralDataLayer.php";

use DAL\UsuarioDataLayer;
use DAL\GeralDataLayer;


class SigninController extends BaseController
{
    public function signin()
    {
        $method = strtoupper($this->getMethod());
        if($method != 'POST')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $response = array();
        $data = $this->getRequestData();

        $user = UsuarioDataLayer::createUser($data);

        $this->returnJson($response, 200);
    }

    public function getTipoUsuario(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $this->returnJson(
            array(
                "data" => GeralDataLayer::getTipoUsuario()
            ),
            200
        );
    }

    public function getNivelEnsino(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $this->returnJson(
            array(
                "data" => GeralDataLayer::getNivelEnsino()
            ),
            200
        );
    }

    public function getStatusEnsino(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $this->returnJson(
            array(
                "data" => GeralDataLayer::getStatusEnsino()
            ),
            200
        );
    }

    public function getIdiomas(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $this->returnJson(
            array(
                "data" => GeralDataLayer::getIdiomas()
            ),
            200
        );
    }

    public function getFluencia(){
        $method = strtoupper($this->getMethod());
        if($method != 'GET')
            $this->returnJson(array("data" => "Method not allowed."), 400);

        $this->returnJson(
            array(
                "data" => GeralDataLayer::getFluencia()
            ),
            200
        );
    }
}
