<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// url: http://localhost/api/public/reporte_existencias
$app->get('/reporte_existencias', function (Request $request, Response $response, array $args) { 
    $helper = new helper();   
    $sql = "SELECT m.nombre AS 'Materia Prima', i.existencias AS 'Existencias'
	FROM materiaprima m INNER JOIN inventario i ON m.idMateriaPrima = i.idMateriaPrima";                
    $result = $helper->select($sql); 
    $json['response'] = (!isset($result['error']))?$result:$result['error'];

    return $response->withStatus((!isset($result['error']))?200:401)
                    ->withJson($json);        
});

// url: http://localhost/api/public/facturar?pedido=1
$app->get('/facturar', function (Request $request, Response $response, array $args) {
 	$id = $request->getParam('pedido'); 
    if(isset($id) && !empty($id)){
        $helper = new helper();  
		$sql = "SELECT * FROM factura WHERE Codigo=?";  
	    $result = $helper->preparedStatement($sql,[$id]);
	    $res = [];
	    if(count($result)>0){
		    $productos = [];
		    foreach (json_decode($result[0]['detalle']) as $key => $value) {	
		    	$array = array(
		    		'producto' => $value->producto, 
		    		'cantidad' => $value->cantidad, 
		    		'precio' => $value->precio,
		    		'total' => $value->precio*$value->cantidad
		    	);    	
		    	array_push($productos, $array);	    	
		    }

		    $res = array(
		    	"codigo"=> $result[0]['Codigo'],
		    	"fecha"=> $result[0]['Fecha Pedido'],
		    	"cliente"=> $result[0]['Cliente'],
		    	"total"=> $result[0]['Total Pedido'],    	
		    	"detalle"=> $productos	    	
		    );	    	
	    }	    

	    $json['response'] = (!isset($result['error']))?$res:$result['error'];

	    return $response->withStatus((!isset($result['error']))?200:401)
	                    ->withJson($json);  
    } else {
        return $response->withStatus(400)
                        ->withJson(['response'=>'Petición incorrecta']);;
    }          
});