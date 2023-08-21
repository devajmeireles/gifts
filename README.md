<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Gifts

Este é o repositório do projeto **Gifts**. **Gifts** foi criado por mim, [AJ Meireles](https://www.linkedin.com/in/devajmeireles/), com o objetivo de disponibilizar uma plataforma para a criação de listas de presentes online, adequadas para ocasiões como casamentos, aniversários e outros eventos.

Devido às frequentes dúvidas que recebo sobre minha abordagem de trabalho e a maneira como desenvolvo minhas aplicações, gostaria de enfatizar que aproximadamente 95% do processo de construção desse sistema foi realizado ao vivo, por meio das transmissões realizadas na comunidade [EuSeiPhp, no YouTube](https://www.youtube.com/@euseiphp). Dessa forma, este projeto serve como um exemplo concreto de como costumo desenvolver minhas aplicações.


## Base

- PHP 8.1
- Laravel 10.x
- TALL Stack 🚀

## Instalação

1. Clone o repositório:

```bash
git clone git@github.com:devajmeireles/gifts.git
```

2. Instale as dependências:

```bash
composer install
```

3. Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

4. Crie o banco de dados e configure o arquivo `.env` com os dados de acesso.
5. Configure o `APP_URL` no `.env`.

6. Execute o comando de setup:

```bash
php artisan setup
```

Obs.: Este comando executa um `migrate:fresh --seed`, **não o utilize em produção.**

7. Crie o usuário `root` da aplicação:

```bash
php artisan make:user
```

8. Faça o build dos assets:

```bash
npm install && npm run build
```

9. Acesse a aplicação pelo `APP_URL` configurado no `.env`.

## Possíveis Adicionais Futuros

1. Notificações via Slack, WhatsApp ou E-mail.
2. Integração com PIX da PagHiper.
3. Exportações de Listas de Itens e Assinaturas via Excel.


## Contribuições

Sinta-se à vontade para contribuir com melhorias através de um pull request.

# Licença

Este projeto está licenciado sob a licença MIT. Consulte o arquivo [LICENSE](./LICENSE.md) para obter mais detalhes.
