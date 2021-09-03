<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// url: http://localhost/api/public/login
// {
//     "usuario":"admin",
//     "contrasena":"$admin$"
// }
$app->post('/login', function (Request $request, Response $response, array $args) { 
    $data = $request->getParsedBody();
    if(isset($data['usuario']) && isset($data['contrasena'])){
        $helper = new helper();   
        $sql = "SELECT u.nombre as usuario, t.nombre AS rol
                FROM usuario u
                INNER JOIN tipousuario t ON u.idTipoUsuario = t.idTipoUsuario
                WHERE u.nombre=? AND u.contrasena=?";                
        $result = $helper->preparedStatement(
                    $sql, 
                    array($data['usuario'], $data['contrasena'])
                ); 
        $json['response'] = (count($result)>0)?$result[0]:'Credenciales incorrectas';
        $status = (count($result)>0)?200:401;

        return $response->withStatus($status)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }    
});

// url: http://localhost/api/public/usuarios
$app->get('/usuarios', function (Request $request, Response $response, array $args) { 
    $helper = new helper();   
    $sql = "SELECT u.idUsuario, u.nombre as usuario, u.contrasena, t.nombre AS rol
            FROM usuario u
            INNER JOIN tipousuario t ON u.idTipoUsuario = t.idTipoUsuario";                
    $result = $helper->select($sql); 
    $json['response'] = (!isset($result['error']))?$result:$result['error'];

    return $response->withStatus((!isset($result['error']))?200:401)
                    ->withJson($json);        
});

// url: http://localhost/api/public/rol
$app->get('/rol', function (Request $request, Response $response, array $args) { 
    $helper = new helper();   
    $sql = "SELECT idTipoUsuario AS id, nombre AS rol FROM tipousuario";                
    $result = $helper->select($sql); 
    $json['response'] = (!isset($result['error']))?$result:$result['error'];

    return $response->withStatus((!isset($result['error']))?200:401)
                    ->withJson($json);        
});

// url: http://localhost/api/public/insertar_usuario 
// {
//     "usuario":"admin",
//     "contrasena":"$admin$",
//     "rol":2  
// }
$app->post('/insertar_usuario', function (Request $request, Response $response, array $args) {    
    $data = $request->getParsedBody();
    if(isset($data['usuario']) && isset($data['contrasena']) && isset($data['rol'])){
        $helper = new helper();   
        $sql = "INSERT INTO usuario(nombre, contrasena, idTipoUsuario) VALUES(?,?,?)";                
        $result = $helper->execute(
                    $sql, 
                    array($data['usuario'], $data['contrasena'], $data['rol'])
                ); 
        $json['response'] = (!isset($result['error']))?'Usuario insertado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});

// url: http://localhost/api/public/modificar_usuario 
// {
//     "usuario":"admin",
//     "contrasena":"$admin$",
//     "rol":2,
//     "id":3
// }
$app->post('/modificar_usuario', function (Request $request, Response $response, array $args) {    
    $data = $request->getParsedBody();
    if(isset($data['usuario']) && isset($data['contrasena']) && isset($data['rol']) && isset($data['id'])){
        $helper = new helper();   
        $sql = "UPDATE usuario SET nombre=?, contrasena=?, idTipoUsuario=? WHERE idUsuario=?"; 
        $result = $helper->execute(
                    $sql, 
                    array($data['usuario'], $data['contrasena'], $data['rol'], $data['id'])
                ); 
        $json['response'] = (!isset($result['error']))?'Usuario modificado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});

// url: http://localhost/api/public/eliminar_usuario?id=13
$app->delete('/eliminar_usuario', function (Request $request, Response $response, array $args) {    
    $id = $request->getParam('id'); 
    if(isset($id) && !empty($id)){
        $helper = new helper();   
        $sql = "DELETE FROM usuario WHERE idUsuario=?"; 
        $result = $helper->execute(
                    $sql, 
                    array($id)
                ); 
        $json['response'] = (!isset($result['error']))?'Usuario eliminado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});