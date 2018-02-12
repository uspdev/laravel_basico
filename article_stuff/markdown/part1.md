# Passos para a elaboração do artigo

## Modelagem do banco de dados
- Modelar no MySQL Workbench
- Colocar o model.mwb e um .png no repositório

## Criação do banco de dados
- Criar o banco de dados no SGBD preferido

## Criação do projeto Laravel
- composer create-project laravel/laravel laravel_basico

## Configurar as variáveis de ambiente
- Editar o arquivo .env com nossos dados de conexão ao banco de dados

## Criação dos models e migrations
- php artisan make:model Post -crmf
- php artisan make:model Comment -crmf

### Criação dos campos nas tabelas
- database/migrations/create_posts_table.php
  ```php
  public function up()
  { 
      Schema::create('posts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->text('content');
          $table->timestamps();
      }); 
  }
  ```

- database/migrations/create_comments_table.php
  ```php
  public function up()
  { 
      Schema::create('comments', function (Blueprint $table) {
          $table->increments('id');
          $table->string('author_email');
          $table->text('content');
          $text->integer('post_id')->unsigned();
          $table->timestamps();

          $table->foreign('post_id')->references('id')->on('posts');
      }); 
  }
  ```

### Rodar as migrations
- php artisan migrate

### Colocar o relacionamento 1:N nos models
- app/Post.php
    ```php
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    
- app/Comment.php
    ```php
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    
