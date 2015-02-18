# password

## Informações:
* Verifica o tamanho mínimo e máximo de uma senha
* Verifica se existe espaço na senha
* Verifica se uma senha é forte de acordo com a quantidade de itens encontrados no conjunto (números, caracteres minúsculos, caracteres maiúsculos, caracteres não alfanuméricos e caracteres especiais)

## Versão PHP
* PHP 5 ou superior

## Utilizando a classe
Inclua o arquivo da classe
```include
require_once('passwordUtil.php');
```

Crie um objeto
```
$pass = new passwordUtil();
```

Execute a verificação de senha
```
if ( $pass->isStrongPassword( '123mudar!' ) ) {
    die( 'Tudo certo!' );
} else {
    die( $pass->getLastError() );
}
```

## Observações
* Para deixar o nível de senha mais forte, altere a variável privada matchRules
* Para alterar os tamanhos mínimos e máximos de uma senha, passe os parâmetros 2(tamanho mínimo) e 3 (tamanho máximo) no método isStrongPassword. Para deixar sem tamanho mínimo e/ou máximo, informe o valor -1.
