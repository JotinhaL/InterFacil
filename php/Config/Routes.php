<?php
/**
 * =============================================================================================
 *                                 Arquivo de configuração das ROTAS
 * =============================================================================================
 */
    //Cofiguração das rotas
    global $routes;
    $routes = array();
    
    //rotas do LoginController
    $routes['/login'] = 'login';
    $routes['/perfil'] = 'login/meu_perfil';
    $routes['/getperfil'] = 'login/getperfil'; // este traz completo, pra edicao de usuario
    $routes['/editar'] = 'login/editarPerfil';

    //rotas do SigninController
    $routes['/signin'] = 'signin';
    $routes['/getTipoUsuario'] = 'signin/getTipoUsuario';
    $routes['/getNivelEnsino'] = 'signin/getNivelEnsino';
    $routes['/getStatusEnsino'] = 'signin/getStatusEnsino';
    $routes['/getIdiomas'] = 'signin/getIdiomas';
    $routes['/getFluencia'] = 'signin/getFluencia';

    //rotas do VagasController
    $routes['/getVagas'] = 'areaPrivada/buscar_vagas';
    $routes['/cadastrarVaga'] = 'areaPrivada/cadastrar_vagas';

    $routes['/excluir'] = 'areaPrivada/excluir_usuario';

?>