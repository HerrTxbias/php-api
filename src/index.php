<?php

/* RAW-Data
$app->get('/', function (Request $request, Response $response){
    $response->getBody()->write("Willkommen zu unserer API!");
    $this->logger->addInfo("GET / | RESP: ".$response->getBody());
    return $response;
});
*/

include 'config.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

include 'container.php';

$app->get('/', function (Request $request, Response $response){
  $response->getBody()->write("Welcome to the API!");
  $this->logger->addInfo("GET / | RESP: ".$response->getBody());
  return $response;
});

$app->get('/docker/ctcontrol/start/{pass}/{port}', function (Request $request, Response $response, array $args){
	if($args['pass'] == "K%(97f)M]x<e\hm="){
		$resp = shell_exec("docker run -v /opt/docker/cachet/includes/".$args['port']."/:/mnt/ -p ".$args['port'].":80 -d cachet");
	}
	$response->getBody()->write($resp);
	$this->logger->addInfo("GET /docker/ctcontrol/start | RESP: ".$response->getBody());
	return $response;
});

$app->get('/docker/ctcontrol/stop/{ctid}', function (Request $request, Response $response, array $args){
	$resp = shell_exec("docker stop ".$args['ctid']);
  $resp = shell_exec("docker rm ".$args['ctid']);
	$response->getBody()->write($resp);
	$this->logger->addInfo("GET /docker/ctcontrol/stop/".$args['ctid']." | RESP: ".$response->getBody());
	return $response;
});

$app->get('/docker/ctcontrol/delete/{pass}/{ctid}', function (Request $request, Response $response, array $args){
	if($args['pass'] == "K%(97f)M]x<e\hm="){
     $resp = shell_exec("docker stop ".$args['ctid']);
    $resp = shell_exec("docker rm ".$args['ctid']);
	}
	$response->getBody()->write($resp);
	$this->logger->addInfo("GET /docker/ctcontrol/delete | RESP: ".$response->getBody());
	return $response;
});

$app->get('/docker/image/create/{name}', function (Request $request, Response $response, array $args){
	$resp = shell_exec("docker build -t ".$args['name']." -q /opt/docker/cachet/web/");
	$response->getBody()->write($resp);
	$this->logger->addInfo("GET /docker/image/create/".$args['name']." | RESP: ".$response->getBody());
	return $response;
});

$app->get('/docker/image/delete/{pass}/{id}', function (Request $request, Response $response, array $args){
	if($args['pass'] == "K%(97f)M]x<e\hm="){
		$resp = shell_exec("docker rmi ".$args['id']);
	}
	$response->getBody()->write($resp);
	$this->logger->addInfo("GET /docker/image/delete | RESP: ".$response->getBody());
	return $response;
});

$app->get('/ticket-system/version', function (Request $request, Response $response){
  $resp = array(
    'success' => 'true',
    'version' => '01',
    'beta-version' => '02'
  );
  $resp = json_encode($resp);
  $response->getBody()->write($resp);
  $this->logger->addInfo("GET /ticket-system/version | RESP: ".$response->getBody());
  return $response;
});

$app->get('/ticket-system/msg', function (Request $request, Response $response){
  $resp = array(
    'success' => 'true',
    'show' => false,
    'type' => 'info',
    'text' => 'Test'
  );
  $resp = json_encode($resp);
  $response->getBody()->write($resp);
  $this->logger->addInfo("GET /ticket-system/msg | RESP: ".$response->getBody());
  return $response;
});

$app->get('/chat/connectionmanager', function (Request $request, Response $response){
  $resp = array(
    'success' => 'true',
    'count' => '1',
    'cmid' => array(
        '1' => '127.0.0.1'
    )
  );
  $resp = json_encode($resp);
  $response->getBody()->write($resp);
  $this->logger->addInfo("GET /chat/connectionmanager | RESP: ".$response->getBody());
  return $response;
});

$app->get('/cloudsystem/license/{key}', function (Request $request, Response $response, array $args){
	$validkeys = array(
		'XXXX-XXXX-XXXX-XXXX',
		'XXXX-XXXX-XXXX-XXX0'
	);
    $resp = array(
		'valid' => false
	);
	if(in_array($args['key'], $validkeys)){
		$resp = array(
			'valid' => true
		);
	}
	$resp = json_encode($resp);
	$response->getBody()->write($resp);
    $this->logger->addInfo("GET /cloudsystem/license/".$args['key']." | RESP: ".$response->getBody());
    return $response;
});

$app->run();
