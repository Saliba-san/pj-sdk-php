# inter-sdk-php

## Modo de execução

- Para executar os métodos do InterSdk é necessário uma aplicação externa que o tenha como dependência de projeto. Pode-se utilizar o projeto exemplo que se encontra no seguinte repositório: https://gitlab.sharedservices.local/sdks/demo-sdk-php

- Para verificar se um método está executando corretamente, é possível rodar/criar um teste para ele na pasta tests do projeto.  
  Nesse caso, na classe TestUtils deve ser informado os seguintes dados: clientId, clientSecret, ambiente de execução, path + nome do arquivo do certificado .crt e o path + nome do arquivo de senha do certificado .key.
