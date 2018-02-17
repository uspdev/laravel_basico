# Parte 7 - Views - Posts

## Fazer login dos autores
### Alterar o model Author para relacionar com User
- Tabelas users e authors
    - Imagem das tabelas
- Tabelas users e authors com relacionamento 1:1
    - Imagem das tabelas
#### Alterar a tabela authors
- Criar migration para adicionar user_id foreign e remover as colunas name e email
    - php artisan make:migration add_user_id_remove_name_email_from_authors --table=authors
    - Código para a migration database/migrations/add_user_id_remove_name_email_from_authors.php
    ```php
    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('name');
            $table->string('email');
            $table->dropForeign('authors_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
    ```

#### Ajustar os models User e Author
- Setar o relacionamento: adicionar em app\User.php
```php
public function author()
{
    return $this->hasOne('App\Author');
}
```
- Setar o relacionamento: adicionar em app\Author.php
```php
public function user()
{
    return $this->belongsTo('App\User');
}
```

#### Inserir user e author no Banco de Dados
- No tinker
```php
>>> $user = new User
>>> $user->name = "Leandro Ramos"
>>> $user->email = "leandroembu@gmail.com"
>>> $user->password = Hash::make('123456');
>>> $user->save()
>>> $author = new Author
>>> $author->bio = "My bio here."
>>> $user->author()->save($author)
```

### Criar a autenticação
- php artisan make:auth

### Adicionar o campo "bio" ao form de registro
- Adicionar ao formulário (antes do campo password) resources/views/auth/register.blade.php:
```php
<div class="form-group row">
    <label for="bio" class="col-md-4 col-form-label text-md-right">Bio</label>
    <div class="col-md-6">
        <textarea id="bio" class="form-control" name="bio" value="{{ old('bio')  }}"></textarea>
    </div>
</div>
```

### Ajustar o controller 
- app/Http/Controllers/Auth/RegisterController.php
```php
// Coloque abaixo do namespace
use App\User;

// ... aqui tem um monte de código
// troque o código do método create por isso:
protected function create(array $data)
{
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    $author = new Author;
    $author->bio = $data['bio'];

    $user->author()->save($author);

    return $user;
}
```

## Links para saber mais
[Laravel 5.6 - Authentication](https://laravel.com/docs/5.6/authentication)
[Laravel 5.6 - Routing](https://laravel.com/docs/5.6/routing)
