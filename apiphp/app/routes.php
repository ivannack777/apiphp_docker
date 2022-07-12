<?php

declare(strict_types=1);

use App\Application\Controller\Developers;
use App\Application\Tests\AddUser;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });


    $app->group('/developers', function (Group $group) {
        //Retorna os dados de um desenvolvedor
        //Retorna todos os desenvolvedores
        $group->get('[/{id}]', [Developers::class, 'list']); 
        
        //Retorna os desenvolvedores de acordo com o termo passado via querystring e paginação
        $group->get('/[/filter]', [Developers::class, 'list']);
        
        //Adiciona um novo desenvolvedor
        $group->post('', [Developers::class , 'save']); 

        //Atualiza os dados de um desenvolvedor
        $group->put('/{id}', [Developers::class , 'save']); 

        //Apaga o registro de um desenvolvedor
        $group->delete('/{id}', [Developers::class , 'delete']);
        $group->map(['GET','POST'], '/login/check', [Developers::class , 'check']);
    });


    $app->group('/tests', function (Group $group) {
        //Retorna os dados de um desenvolvedor
        
        $group->post('/add', [AddUser::class, 'inputs']); 
    });

};
