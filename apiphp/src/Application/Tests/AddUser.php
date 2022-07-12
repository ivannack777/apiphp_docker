<?php

declare(strict_types=1);

namespace App\Application\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use InvalidArgumentException;

class AddUser extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    
    public function inputs(Request $request, Response $response, array $args){
        $requests = array_map('trim', $request->getQueryParams() ?? []);
        // $id = $requests['id'];
        $nome = $requests['nome'];
        $sexo = $requests['sexo'];
        $idade = $requests['idade'];
        $passatempo = $requests['passatempo'];
        $nascimento = $requests['nascimento'];

        // $this->testAdd($nome, $idade, 46);
        $this->testString($nome, 20);

        return $response->withJson([], false, 'ok');
    }

    protected function testString($str, $length)
    {
        if(!is_string($str) || !preg_match('/[a-zA-z]/', $str)){
            throw new InvalidArgumentException('O argumento A precisa deve conter apenas letras');
        }
        if(empty($str)){
            throw new InvalidArgumentException('O argumento A precisa não pode ser vazaio');
        }
        if(strlen($str) > $length ){
            throw new InvalidArgumentException('O tamanho do argumento A deve ser menor que '. $length);
        }
    }

    protected function testAdd($a, $b, $expected)
    {
        if(!is_numeric($a)){
            throw new InvalidArgumentException('O argumento A precisa ser um número');
        }
        if(!is_numeric($b)){
            throw new InvalidArgumentException('O argumento B precisa ser um número');
        }
        if(!is_numeric($expected)){
            throw new InvalidArgumentException('O argumento C precisa ser um número');
        }
        $this->assertEquals($expected, $a + $b);
    }

    public function additionProvider()
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 3]
        ];
    }

}