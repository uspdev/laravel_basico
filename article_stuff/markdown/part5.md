# Parte 5 - PostController

## Fazer login dos autores
### Alterar o model Author para relacionar com User
- Tabelas users e authors
    - Imagem das tabelas
- Tabelas users e authors com relacionamento 1:1
    - Imagem das tabelas
#### Alterar a tabela authors
- Criar migration para adicionar user_id foreign e remover as colunas name e email
    - php artisan make:migration add_user_id_remove_name_email_from_authors --table=authors

