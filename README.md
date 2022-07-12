# apiphp_docker

## API em PHP no Docker

Esta é uma API REST que foi desenvolvida em PHP para demonstrar de forma simples como pode ser feito o cadastro e lista de desenvolvedores.

As informações são armazenadas num banco de dados, que neste exemplo foi utilizado o MySQL, mas que pode ser feito com qualquer banco de sua preferêcia desde que seja suportado pelo PHP.

Deve ser utilizada juntamente com o protocolo HTTP e seus metodos conhecidos: GET, POST, PUT e DELETE
com as seguintes funcionalidades:

- Adicionar
- Editar
- Listar
- Litar pelo ID
- Procurar usando filtro
- Excluir
- Testes

Abaixo estão descritos como as requisições devem serem feitas e o retorno que apresenta

1. ### Adicionar desenvolvedor
    
    *POST {host:port}/developers*

    *Query resquest*

    ```
        nome=João DE ABREU
        sexo=M
        idade=46
        passatempo=desenvolver api
        nascimento=02/01/2002
    ``` 

    *Response (Json):*

    ```
    {
        "status": true,
        "msg": "Desenvolvedor foi adicionado",
        "data": {
            "id": "670deda5cca43186475e637b29e9b55e3a3b2e8224afeb2c9ddbacd47ff420c8",
            "name": "João de Abreu",
            "sex": "M",
            "age": "46",
            "hobby": "dever",
            "birthdate": "2002-02-10"
        }
    }
    ```

    ou caso o campo nome for omitido ou deixado em branco, retornará o status `false`

    *Query resquest*

    ```
        sexo=M
        idade=46
        passatempo=desenvolver api
        nascimento=02/01/2002
    ``` 
    *Response (Json):*

    ```
    {
        "status": false,
        "msg": "Parâmetros incorretos",
        "data": []
    }
    ```

2. ### Editar um desenvolvedores

    *PUT {host:port}/developers/{id}*

    *Query resquest:*

    ```
        nome=Ivan Nack
        sexo=M
        idade=46
        passatempo=Desenvolver
        nascimento=02/01/1976
    ``` 

    *Response (Json):*

    ```
    {
        "status": true,
        "msg": "Desenvolvedor foi atualizado. Modified: 1",
        "data": {
            "name": "Ivan Nack",
            "sex": "M",
            "age": "46",
            "hobby": "Desenvolver",
            "birthdate": "1976-02-01"
        }
    }
    ```

3. ### Listar todos desenvolvedores

    *GET {host:port}/developers*

    *Response (Json):*

    ```
    {
        "status": false,
        "msg": "Nenhum desenvolvedor foi encontrado",
        "data": []
    }
    ```

    ou

    ```
    {
        "status": true,
        "msg": "3 desenvolvedores foram encontrados",
        "data": [
            {
                "id": "e44f89e12666e40bfca4636b5e328deabc6b2b722452a5581fa74b9da4231e46",
                "name": "Ivan Nack",
                "sex": "M",
                "age": 46,
                "hobby": "Desenvolver",
                "birthdate": "1976-02-01"
            },
            {
                "id": "670deda5cca43186475e637b29e9b55e3a3b2e8224afeb2c9ddbacd47ff420c8",
                "name": "João de Abreu",
                "sex": "M",
                "age": 20,
                "hobby": "Testar API",
                "birthdate": "2002-12-04"
            },
            {
                "id": "21a2d92415b255ba3353c7a505e221f0426fe6e960173a56b8026dc71aae79b6",
                "name": "Maria Ivone Handler",
                "sex": "M",
                "age": 29,
                "hobby": "dever",
                "birthdate": "1993-02-04"
            }
        ]
    }
    ```

4. ### Listar um desenvolvedor pelo ID
    *GET {host:port}/developers/{id}*
    
    *Response (Json):*

    ```
    {
        "status": true,
        "msg": "1 desenvolvedor foi encontrado",
        "data": [
            {
                "id": "670deda5cca43186475e637b29e9b55e3a3b2e8224afeb2c9ddbacd47ff420c8",
                "name": "João de Abreu",
                "sex": "M",
                "age": 46,
                "hobby": "dever",
                "birthdate": "2002-02-10"
            }
        ]
    }
    ```
5. ### Pocurar desenvolvedores usando `filter`
    
    *GET {host:port}/developers/filter*
    
    *Query resquest:*

    ```
    nome=maria
    ```

    *Response (Json):*

    ```
    {
        "status": true,
        "msg": "1 desenvolvedor foi encontrado",
        "data": [
            {
                "id": "21a2d92415b255ba3353c7a505e221f0426fe6e960173a56b8026dc71aae79b6",
                "name": "Maria Ivone Handler",
                "sex": "M",
                "age": 29,
                "hobby": "dever",
                "birthdate": "1993-02-04"
            }
        ]
    }
    ```

6. ### Excluir um desenvolvedor

    *DELETE {host:port}/developers/{id}*

    *Response (Json):*

    ``` 
    {
        "status": true,
        "msg": "Desenvolvedor foi excluido. ",
        "data": {
            "deleted": "Y",
            "deleted_by": 99,
            "deleted_at": "2022-07-12 01:17:04"
        }
    }
    ```

7. ## Testes

    *POST {host:port}/tests/add*

    *Query resquest:*

    ```
    nome=10
    ```

    *Response (Json):*

    ``` 
    {
        "statusCode": 500,
        "error": {
            "type": "SERVER_ERROR",
            "description": "O argumento 'A' deve conter apenas letras"
        }
    }
    ```
    
    ou
    
    *Query resquest:*

    ```
    nome=Pedro de Alcântara Francisco António João Carlos Xavier de Paula Miguel Rafael Joaquim José Gonzaga Pascoal Cipriano Serafim
    ```

    *Response (Json):*

    ``` 
    {
        "statusCode": 500,
        "error": {
            "type": "SERVER_ERROR",
            "description": "O tamanho do argumento 'A' deve ser menor que 20"
        }
    }
    ```


## Finalizando

Para armazenar o projeto de forma padronizada ele foi adicionado a uma imagem Docker que pode ser acessada neste link:
<a href="https://drive.google.com/file/d/1X9Q66MU5p9talUd6jrpN02GVoptH8M6K/view?usp=sharing">https://drive.google.com/file/d/1X9Q66MU5p9talUd6jrpN02GVoptH8M6K/view?usp=sharing</a>

Após baixado, em um terminal, pode ser carregado no Docker previamente instalado, atraves do comando load

 ```$ docker load < apiphp_ivannack_v5.tar.gz```

 E porteriormente iniciado em um container

 ```$ docker container run -tid --name="apiphpivannack_v5" -p 8008:80 apiphp_ivannack:version5``` 

Assim é possivel testar simplismente utlizando o host <a href="http://localhost:8008/">http://localhost:8008/</a>
