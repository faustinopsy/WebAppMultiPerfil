# Multi perfil-permissoes
Autenticação e Autorização (somente back via API)
Instruções:
Clone o repositório e instale as dependências:
```
git clone https://github.com/faustinopsy/WebAppMultiPerfil.git

composer install
```
# Mini-Documentação do Sistema
- index.php
Serve como o ponto de entrada principal da aplicação. Roteia as requisições para os respectivos controladores.
- PerfilPermissoes.php
Gerencia a relação entre perfis e permissões. Contém lógica para associar ou desassociar permissões de um perfil.
- Perfis.php
Responsável por operações relacionadas a perfis de usuário, como criação, edição e remoção de perfis.
- Permissoes.php
Lida com a gestão de permissões, incluindo a criação e remoção de permissões.
- Token.php
Central para a geração e validação de tokens. Essencial para autenticação e autorização no sistema.
- Usuarios.php
Gerencia operações de usuário, incluindo registro, login e atualização de informações do usuário.
Aspectos Importantes

## Login e Tokens: 

Durante o login, um token é fornecido ao usuário. Este token é crucial para a autenticação subsequente e contém informações importantes, como permissões do usuário e seu ID.
```
public function login($senha,$lembrar) {
        $condicoes = ['email' => $this->usuarios->getEmail(),'ativo' => 1];
        $resultado = $this->select($this->usuarios, $condicoes);
        $checado=$lembrar? 60*12 : 3;
        $permissoes=[];
        if (!$resultado) {
            return ['status' => false, 'message' => 'Usuário não encontrado ou bloqueado.'];
        }
        if (!password_verify($senha, $resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        $perfper = $this->select($this->PerfilPermissoes,['perfilid'=>$resultado[0]['perfilid']]);
        foreach($perfper as $key => $value){
            $permissoes[] = $this->select($this->permissoes,['id'=>$value['permissao_id']]);
        } 
        foreach ($permissoes as $permissaoArray) {
            foreach ($permissaoArray as $permissao) {
                if (isset($permissao['nome'])) {
                    $permissoesNomes[] = $permissao['nome'];
                }
            }
        }
        $key = TOKEN;
        $local=$_SERVER['HTTP_HOST'];
        $nome=$_SERVER['SERVER_NAME'];
        $algoritimo='HS256';
            $payload = [
                "iss" =>  $local,
                "aud" =>  $nome,
                "iat" => time(),
                "exp" => time() + (60 * $checado),  
                "sub" => $resultado[0]['id'],
                'telas'=>$permissoesNomes
            ];
            
            $jwt = JWT::encode($payload, $key,$algoritimo);
        return ['status' => true, 'message' => 'Login bem-sucedido!','token'=>$jwt,'telas'=>$permissoesNomes];
    }
```

## Permissões no Token: 
As permissões incluídas no token determinam o que o usuário pode fazer dentro do sistema. Isso permite um controle de acesso eficaz e seguro.

## Uso do ID do Usuário: 
Em algumas operações, como inserção de registros ou logs, o ID do usuário é extraído do token. Isso assegura que as ações sejam corretamente atribuídas ao usuário autenticado.

- TokenController: faz a verificação se o token foi expirado, ou se a origem do dominio é o mesmo que criou o token e recupera o ID do usuário que esta no token

```
$router->post('/', function () {
        $body = json_decode(file_get_contents('php://input'), true);
        $permitido = new TokenController();
        $permitido->autorizado();
        $iduser= $permitido->verIdUserToken();
        $perfil = new Perfis();
        $perfil->setNome($body['nome']);
        $perfil->setCreate_id($iduser);
        $controller = new PerfilController($perfil);
            $resultado = $controller->adicionarPerfil();
            echo json_encode($resultado);
    });
```

# API Documentation - Detailed
Authorization não é fixa, pois a cada login é gerado novo token para validação subsequente, no projeto login no meu github possui um frontend que contem um javascript que faz uma requisição a cada 3 minutos para validar o login, caso queira saber mais, pois no exemplo abaixo na parte do login estou enviando o lembrar-me como true o que faz o token não expirar, mas se o lembrar-me for false o token é expiravel em alguns minutos.
## List_Permissões
**Method:** GET

**URL:** http://localhost/backend/Router/Permissoes

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
N/A

## Registrar_Permissões
**Method:** POST

**URL:** http://localhost/backend/Router/Permissoes

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "nome":"xxxxxxx"
}
```

## List_Perfil
**Method:** GET

**URL:** http://localhost/backend/Router/Perfil

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
N/A

## Registrar_Perfil
**Method:** POST

**URL:** http://localhost/backend/Router/Perfil

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "nome":"xxxxx"
}
```

## Login
**Method:** POST

**URL:** http://localhost/backend/Router/Usuarios/login

**Headers:**


**Body:**
```json
{
    "email":"rfaustino@gmail.com",
    "senha":"123456",
    "lembrar":"true"
}
```

## Usuarios
**Method:** GET

**URL:** http://localhost/backend/Router/Usuarios

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
N/A

## Registrar_Usuarios
**Method:** POST

**URL:** http://localhost/backend/Router/Usuarios/Registrar

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "nome":"Rodrigo Teste",
    "email":"rfaustino@gmail.com",
    "senha":"123456"
}
```

## Deletar_Usuarios
**Method:** DELETE

**URL:** http://localhost/backend/Router/Usuarios

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "email":"rfaustino@gmail.com"
}
```

## Associar_perfil_permissao
**Method:** POST

**URL:** http://localhost/backend/Router/Associar

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "perfilId":"2",
    "permissao_id":"1"
}
```

## list_perfil_permissao
**Method:** GET

**URL:** http://localhost/backend/Router/Associar/2

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
N/A

## Deletar_Associação
**Method:** DELETE

**URL:** http://localhost/backend/Router/Associar/4

**Headers:**
- Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJhdWQiOiJsb2NhbGhvc3QiLCJpYXQiOjE3MDY3OTAxMzYsImV4cCI6MTcwNjgzMzMzNiwic3ViIjoxLCJ0ZWxhcyI6WyJpbmRleCIsInByb2R1dG9zIiwiYWRtaW4iLCJ1c3VhcmlvcyIsInNhbG9lcyJdfQ.kZI3h-PjZn9aGZ4Q8d5nolmzM0CH68hSbz6ZhHFOw10"

**Body:**
```json
{
    "permissao_id":"5"
}
```

# Aspectos epeciais

# Classe Crud (A classe especial)

Localizada em App\Database\Crud, esta classe é responsável pelas operações básicas de banco de dados em um estilo de programação orientado a objetos. Ela estende a classe Connection, indicando que gerencia a conexão com o banco de dados.
A classe Crud segue o padrão de design Active Record, que é um padrão de acesso a dados. Este padrão implica que um objeto de um modelo contém tanto os dados (representados pelos campos do banco de dados) quanto o comportamento que inclui a lógica de acesso a esses dados (as operações CRUD). A classe estende uma Connection, que presumivelmente gerencia a conexão com o banco de dados, seguindo o princípio de herança para reutilizar a lógica de conexão.

## Possibilidades e Melhorias

Reflexão para Mapeamento Objeto-Relacional (ORM): Utiliza reflexão para mapear propriedades de objetos para colunas em uma tabela de banco de dados. Isso permite uma abstração significativa, mas tem limitações, como a necessidade de que as propriedades sejam privadas e mapeadas um-a-um com as colunas da tabela.

Abstração e Flexibilidade: Facilita operações com o banco de dados sem escrever SQL diretamente, abstraindo muitos dos detalhes e aumentando a segurança contra injeções de SQL através do uso de prepared statements.

## Melhorias:

Validação e Sanitização: Incluir mecanismos de validação e sanitização de dados antes de executar operações no banco de dados para aumentar a segurança.
Padronização dos Nomes das Tabelas: A classe assume que o nome da tabela é o nome da classe do objeto passado em minúsculas. Isso pode não ser sempre desejável ou viável, especialmente em bancos de dados com convenções de nomenclatura específicas.
Tratamento de Erros: O código atualmente apenas imprime mensagens de erro. Seria mais adequado lançar exceções ou utilizar um sistema de logging para registrar esses erros.
Suporte a Relacionamentos: Não há suporte explícito para o mapeamento de relações entre tabelas, como chave estrangeira, o que poderia ser uma adição valiosa.

## Funcionalidades da Classe Crud:
- getLastInsertId: 
Retorna o ID do último registro inserido.
- insert: 
Insere um novo registro no banco de dados baseado no objeto passado. Utiliza reflexão para determinar as propriedades privadas do objeto e seus valores, construindo e executando uma consulta SQL INSERT.
- select: 
Realiza uma consulta SELECT no banco de dados. Permite condições de pesquisa flexíveis, incluindo operadores como LIKE e BETWEEN.
- update: 
Atualiza registros existentes no banco de dados. Similar ao método insert, utiliza reflexão para construir a consulta UPDATE.
- delete: 
Remove registros do banco de dados com base nas condições fornecidas.

## Uso de Reflexão: 
A classe Crud utiliza reflexão (a classe ReflectionClass do PHP) para manipular propriedades privadas dos objetos passados. Isso permite que a classe opere de maneira genérica com diferentes tipos de objetos, adequando-se às necessidades de várias tabelas e estruturas de dados.

# Reflexão em PHP
Reflexão é um recurso de linguagens de programação que permite a um programa inspecionar e modificar sua estrutura e comportamento em tempo de execução. Em PHP, a reflexão é usada principalmente para:

Obter Informações sobre Classes e Objetos: Inspecionar classes, propriedades, métodos e outros aspectos internos de um objeto.
## Acessar Propriedades e Métodos: 
Manipular propriedades e invocar métodos, independentemente de sua visibilidade (pública, protegida ou privada).
Vantagens e Usabilidade no Contexto dos Códigos
Nos códigos fornecidos, a reflexão é usada na classe Crud para manipular objetos de diferentes tipos de forma genérica. Vamos detalhar suas vantagens e usabilidade:

##  Abstração e Reutilização de Código: 
A classe Crud é capaz de realizar operações de banco de dados com qualquer tipo de objeto sem necessitar de implementações específicas para cada tipo. Isso é possível porque a reflexão permite inspecionar os objetos em tempo de execução e descobrir suas propriedades. Assim, a mesma lógica de insert, update, select e delete pode ser reutilizada para diferentes tipos de entidades.

##  Flexibilidade com Propriedades Privadas: 
Normalmente, propriedades privadas em uma classe não são acessíveis fora da própria classe. No entanto, com reflexão, a classe Crud pode acessar e modificar essas propriedades. Isso é crucial para operações de banco de dados onde cada propriedade do objeto pode mapear para uma coluna na tabela do banco de dados.

## Construção Dinâmica de Consultas SQL: 
A reflexão permite que a classe Crud construa consultas SQL dinamicamente baseadas nos objetos passados. Por exemplo, ao inserir um objeto, a classe pode automaticamente gerar uma instrução INSERT INTO com colunas e valores correspondentes às propriedades do objeto. Isso elimina a necessidade de escrever consultas SQL manualmente para cada tipo de objeto, simplificando o código e reduzindo a probabilidade de erros.

## Manutenção e Extensibilidade do Código: 
A capacidade de tratar diferentes tipos de objetos de maneira genérica facilita a manutenção e extensão do código. Novas entidades podem ser adicionadas ao sistema sem a necessidade de alterar a lógica central de CRUD, desde que sigam a estrutura esperada.


# Entendendo a classe CRUD
Na classe que irá usar o CRUD, usa extends para herdar a classe CRUD, e inicia o construtor da classe pai que a classe CRUD dentro do proprio construtor.

1º:
```
class PerfilController extends Crud{
    private $perfil;
    public function __construct($perfil){
        parent::__construct();
        $this->perfil=$perfil;
    }
```
Assim a classe filha poderá usar o "$this" como se fosse a própria classe, usando os métodos da classe pai, pois herdou e instanciou-a
2º SELECT
$this->select(ARGUMENTO1, ARGUMENTO2)
- $this->perfil = ARGUMENTO 1, classe Model que representa a tabela do banco de dados.
- ['nome'=> $this->perfil->getNome()) = ARGUMENTO 2, um array nome da coluna do banco e seu valor. se vazio [] trará todos os registros.
- uso com betwwen: ['latitude' => ['BETWEEN', [$latMin, $latMax]]]
- uso com like: ['bairro' => ['LIKE', $this->enderecos->getBairro()]]
```
$this->select($this->perfil,['nome'=> $this->perfil->getNome()]);
```
Uso de um select especial como Inner join:
onde precisaria exibir todas as permissoes de um perfil (neste caso há uma associação N:N), primeiro busquei o perfil especifico e com o resultado que é o id das permissões listei em um array todas as permissões.
```
public function obterPermissoesDoPerfil($permissoes){
         $resultado = $this->select($this->perfilpermissoes,['perfilid'=> $this->perfilpermissoes->getPerfilid()]);
         $dados=[];
         foreach($resultado as $key => $value) {
            $dados[] = $this->select($permissoes,['id'=> $value['permissao_id']]);
         }
         return $dados;
    }
```
Mas o padrão de uso é enviar a "classe model" que representa a tabela do banco no primeiro argumento do método.

# Fluxo de Cadastro e Listagem
- 1. Ponto de Entrada: index.php
Função: index.php atua como o ponto de entrada do aplicativo. Ele direciona as requisições HTTP para os respectivos controladores baseados na URL acessada.
Processo: Quando uma requisição é feita, index.php determina qual rota corresponde à URL e passa o controle para o arquivo e função relevantes definidos na rota.
- 2. Arquivos de Rota: Usuarios.php (Rota)
Função: Define as rotas específicas (como /usuarios) e os métodos HTTP (GET, POST, etc.) correspondentes.
Processo: Quando uma rota é chamada, ela instanciará o controlador apropriado e chamará o método relevante para lidar com a requisição.
- 3. Model: Usuarios.php (Model)
Função: Representa a estrutura de dados do usuário. Contém definições e regras dos dados que um usuário pode ter.
Processo: O Model é usado pelo controlador para criar objetos de usuário com dados que podem ser salvos ou recuperados do banco de dados.
- 4. UsuarioController
Função: Contém a lógica de negócios para operações de usuário.
Processo:
Para o cadastro, o controlador recebe dados do usuário, cria um objeto de usuário e utiliza a classe Crud para inserir os dados no banco de dados.
Para a listagem, o controlador usa a classe Crud para buscar dados dos usuários do banco de dados.
- 5. Classe Crud
Função: Gerencia operações básicas de banco de dados (CRUD - Criar, Ler, Atualizar, Deletar).
Processo:
Inserir: Recebe um objeto, extrai seus dados (usando reflexão, se necessário), e executa uma instrução SQL INSERT.
Selecionar: Executa uma instrução SQL SELECT para ler dados do banco de dados. Pode ser utilizada para listar usuários.
Atualizar e Deletar: Similar ao inserir, mas com as respectivas operações SQL.
<img src="assets/img/seqex.svg">
