<?php
error_reporting(0);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/hello/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World! Api de Gelvazio!");
    return $response;
});

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Index! Api de Gelvazio!");

    return $response;
});

$app->get('/testbot/{message}', function (Request $request, Response $response, array $args) {

    $mensageInformada = $args['message'];

    if(isset($mensageInformada)){
        $mensageInformada = " Mensagem:" . $mensageInformada;
    }

    require_once ("controllers/ControllerApiTelegram.php");

    ControllerApiTelegram::sendMessage("Testando Chatbot de Gelvazio." . $mensageInformada);

    $response->getBody()->write("Enviando mensagem para o chatbot!");

    return $response;
});

$app->get('/testbotusername/{name}', function (Request $request, Response $response, array $args) {

    require_once ("controllers/ControllerApiTelegram.php");

    $name = $args['name'];

    $nomeInformado = "Branco";
    if(isset($name)){
        $nomeInformado = $name;
    }

    ControllerApiTelegram::sendMessage("Chatbot Gelvazio!Parametro Informado:" . $nomeInformado);

    $response->getBody()->write("Enviando mensagem para o chatbot!Parametro Informado:" . $nomeInformado);

    return $response;
});

$app->post('/setwebhook/', function (Request $request, Response $response, array $args) {

    require_once ("controllers/ControllerApiTelegram.php");

    ControllerApiTelegram::setWebhook("https://api-php-slim-vercel.vercel.app/webhook");

    $response->getBody()->write("Setando o webhook!");

    return $response;
});

$app->post('/webhook', function (Request $request, Response $response, array $args) {
    require_once ("controllers/ControllerApiTelegram.php");

    // Pegar os dados do body, que contem a mensagem do usuario!

    ControllerApiTelegram::sendMessage("Chatbot respondendo!");

    $response->getBody()->write("Chatbot respondendo!");

    return $response;
});

$app->get('/listwebhook', function (Request $request, Response $response, array $args) {
    require_once ("controllers/ControllerApiTelegram.php");

    $aDadosWebhook = ControllerApiTelegram::callApiTelegramUpdates();

    $response->getBody()->write("Dados Webhook" . $aDadosWebhook);

    return $response;
});

$app->run();
