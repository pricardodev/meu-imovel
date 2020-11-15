## Descrição
API construída com Laravel 6 e JWT, para realização de cadastro, edição, listagem e exclusão de registros voltados a área de vendas e alugueis de imóveis. 

## Tecnologias

Laravel 6 <a href="https://laravel.com/docs/6.x/installation"><img src="https://img.shields.io/static/v1?label=Laravel&message=framework&color=orange&style=for-the-badge&logo=Laravel"/></a>

JWT <a href="https://jwt.io/"><img src="https://img.shields.io/static/v1?label=jwt.io&message=framework&color=red&style=for-the-badge&logo=jwt.io"/></a>

## Instalação

Baixe o projeto, replique o arquivo .env.example renomeando para .env;
Configure as variáveis de ambiente do relacionada a base de dados que irá utilizar;
Execute:
<code> 
composer install
php artisan key:generate 
php artisan migrate
</code>
Para executar o projeto:
<code>
php artisan serve
</code>

## Considerações
O front-end da aplicação não foi desenvolvida para aplicação nessa versão 0.1 do projeto, o intuito é criar apenas endpoints de uma aplicação mobile ou servir a um sistema que consuma recursos de uma api voltada a gestão de imóveis. 
Você pode realizar os testes via:
POSTMAN <a href="https://www.postman.com/"><img src="https://img.shields.io/static/v1?label=postman&message=plataforma&color=orange&style=for-the-badge&logo=postman"/></a>
INSOMNIA <a href="https://insomnia.rest/"><img src="https://img.shields.io/static/v1?label=insomnia&message=plataforma&color=purple&style=for-the-badge&logo=insomnia"/></a>