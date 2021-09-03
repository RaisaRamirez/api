<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// url: http://localhost/api/public/clientes
$app->get('/clientes', function (Request $request, Response $response, array $args) { 
    $helper = new helper();   
    $sql = "SELECT * FROM cliente";                
    $result = $helper->select($sql); 
    $json['response'] = (!isset($result['error']))?$result:$result['error'];

    return $response->withStatus((!isset($result['error']))?200:401)
                    ->withJson($json);        
});

// url: http://localhost/api/public/insertar_cliente 
// {
//     "nombre":"erick",
//     "apellido":"fuentes",
//     "direccion":"santa ana",
//     "telefono":"2356-7899"
// }
$app->post('/insertar_cliente', function (Request $request, Response $response, array $args) {    
    $data = $request->getParsedBody();
    if(isset($data['nombre']) && isset($data['apellido']) && isset($data['direccion']) && isset($data['telefono'])){
        $helper = new helper();   
        $sql = "INSERT INTO cliente(nombre, apellido, direccion, telefono) VALUES(?,?,?,?)";  
        $arreglo = array(
            $data['nombre'], 
            $data['apellido'], 
            $data['direccion'], 
            $data['telefono']
        );              
        $result = $helper->execute(
                    $sql, 
                    $arreglo
                ); 
        $json['response'] = (!isset($result['error']))?'Cliente insertado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});

// url: http://localhost/api/public/modificar_cliente 
// {
//     "nombre":"ana",
//     "apellido":"fuentes",
//     "direccion":"San Miguel",
//     "telefono":"2467-6859",
//     "id":3
// }
$app->post('/modificar_cliente', function (Request $request, Response $response, array $args) {    
    $data = $request->getParsedBody();
    if(isset($data['nombre']) && isset($data['apellido']) && isset($data['direccion']) && isset($data['telefono']) && isset($data['id'])){
        $helper = new helper();   
        $sql = "UPDATE cliente SET nombre=?, apellido=?, direccion=? , telefono=? WHERE idCliente=?"; 
        $arreglo = array(
            $data['nombre'], 
            $data['apellido'], 
            $data['direccion'], 
            $data['telefono'], 
            $data['id']
        );
        $result = $helper->execute(
                    $sql, 
                    $arreglo
                ); 
        $json['response'] = (!isset($result['error']))?'Cliente modificado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});

// url: http://localhost/api/public/eliminar_cliente?id=3
$app->delete('/eliminar_cliente', function (Request $request, Response $response, array $args) {    
    $id = $request->getParam('id'); 
    if(isset($id) && !empty($id)){
        $helper = new helper();   
        $sql = "DELETE FROM cliente WHERE idCliente=?"; 
        $result = $helper->execute(
                    $sql, 
                    array($id)
                ); 
        $json['response'] = (!isset($result['error']))?'Cliente eliminado':$result['error'];
        
        return $response->withStatus((!isset($result['error']))?200:401)
                        ->withJson($json); 
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }
});