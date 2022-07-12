<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Response as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Devs;
use App\Application\Helpers\Sanitize;
use Exception;

// use Slim\Exception\HttpUnauthorizedException;

class Developers
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um desenvolvedor passando '$id' pela url
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response, array $args)
    {

        //obtem os dados passados por parametros
        $id = $args['id'] ?? null;

        //obtem os dados passados por parametros e limpa espaços no incio ou final de cada valor
        $requests = array_map('trim', $request->getQueryParams() ?? []);

        if ($id == 'filter') {
            if (empty($requests)) {
                return $response->withJson([], false, 'Nenhum parâmetro de pesquisa foi enviado');
            }
            $id = null;
        }


        $devs = new Devs();
        $getDevs = $devs::list($id, $requests);
        // var_dump($leitor->count());exit;

        if ($getDevs->count()) {
            return $response->withJson($getDevs, true, $getDevs->count() . ($getDevs->count() > 1 ? ' desenvolvedores foram encontrados' : ' desenvolvedor foi encontrado'));
        } else {
            return $response->withJson($getDevs, false, 'Nenhum desenvolvedor foi encontrado');
        }

        return $response->withJson([], false, 'Parâmetros incorretos');
    }


    /**
     * Localiza e retorna um desenvolvedor passando '$id' pela url
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {

        $metodo = $request->getMethod();
        $sanitize = new Sanitize();
        //obtem os dados passados por parametros e limpa espaços no incio ou final de cada valor
        $requests = array_map('trim', $request->getQueryParams() ?? []);

        $id = $sanitize->set($requests['id'] ?? null)->get();
        $nome = $sanitize->set($requests['nome'] ?? null)->name()->get();
        $sexo = $sanitize->set($requests['sexo'] ?? null)->clear()->get();
        $idade = $sanitize->set($requests['idade'] ?? null)->integer()->get();
        $passatempo = $sanitize->set($requests['passatempo'] ?? null)->get();
        $nascimento = $sanitize->set($requests['nascimento'] ?? null)->date('m-d-Y')->get();

        if (!empty($nome)) {
            if (!empty('nascimento')) {
                try {
                    $nascimento = \DateTime::createFromFormat('Y-m-d', $nascimento);
                    if (false === $nascimento) {
                        $nascimento = null;
                    } else {
                        $nascimento = $nascimento->format('Y-m-d');
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }

            $dados = [
                'id' => hash('sha256', $nome . time()),
                'name' => $nome,
                'sex' => $sexo,
                'age' => $idade,
                'hobby' => $passatempo,
                'birthdate' => $nascimento,
            ];

            $devs = new Devs();

            //Adiciona um novo desenvolvedor
            if ($metodo == 'POST') {
                $getDevs = $devs::list($dados['id']);

                if ($getDevs->count()) {
                    return $response->withJson($getDevs, false, 'Já existe um desenvolvedor com este id');
                }

                $insert = $devs->insert($dados);
                if ($insert) {
                    return $response->withJson($dados, true, 'Desenvolvedor foi adicionado');
                }
                return $response->withJson($dados, false, 'Erro ao adicionar o desenvolvedor');
            }
            //Atualiza os dados de um desenvolvedor
            elseif ($metodo == 'PUT') {
                $id = $args['id'] ?? null;
                if (empty($id) || $id === null) {
                    return $response->withJson([], false, 'É necessário informar o id');
                }
                $getDevs = $devs::list($id);

                if ($getDevs->count() === 0) {
                    return $response->withJson([], false, 'Desenvolvedor não foi encontrado');
                }
                unset($dados['id']);
                // var_dump($id,$dados);exit;
                $update = $devs->where('id', $id)->update($dados);
                if ($update === false) {
                    return $response->withJson($dados, false, 'Erro ao atualizar o desenvolvedor');
                }
                return $response->withJson($dados, true, 'Desenvolvedor foi atualizado. ' . 'Modified: ' . $update);
            }
            return $response->withJson([], false, 'Método incorretos');
        }
        return $response->withJson([], false, 'Parâmetros incorretos');
    }

    /**
     * Localiza e retorna um desenvolvedor passando '$id' pela url
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function delete(Request $request, Response $response, array $args)
    {

        //definir um id do usuario fixo, pois esse aplicação não foi implementado autenticação
        $userId = 99;

        //pegar o metodo da requisição http
        $metodo = $request->getMethod();
        
        $id = $args['id'] ?? null;

        if (empty($id) || null === $id) {
            return $response->withJson([], false, 'É necessário informar o id');
        }

        $devs = new Devs();

        //Adiciona um novo desenvolvedor
        if ($metodo == 'DELETE') {

            $getDevs = $devs::list($id);

            if ($getDevs->count() === 0) {
                return $response->withJson([], false, 'Desenvolvedor não foi encontrado');
            }
            $dados = [
                'deleted' => 'Y',
                'deleted_by' => $userId,
                'deleted_at' => date('Y-m-d H:i:s'),
            ];

            // var_dump($id,$dados);exit;
            $update = $devs->where('id', $id)->update($dados);
            if ($update === false) {
                return $response->withJson($dados, false, 'Erro ao excluir o desenvolvedor');
            }
            return $response->withJson($dados, true, 'Desenvolvedor foi excluido. ');
        }
        return $response->withJson([], false, 'Método incorretos');
    }
}
