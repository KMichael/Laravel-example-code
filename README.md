# Инструкция к проету: 
1. git clone в удобную директорию, например - /var/www/book-store
2. Создать базу для проекта, например - book_store
3. В .env проекта настроить доступы к базе:
- DB_DATABASE=book_store
- DB_USERNAME=user
- DB_PASSWORD=pass
4. Настроить сервер, например nginx
```
server {
    listen 80;
    server_name book-store.test;
    root /var/www/book-store/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    error_log  /var/log/nginx/book-store.test_error.log;
    access_log /var/log/nginx/book-store.test_access.log;
}
```
5. Настроить /etc/hosts
```
127.0.0.1	book-store.test
```
6. В проекте - `composer install` для установки необходимых зависимостей
7. `npm run build` - Для сборки стилей и скриптов проекта
8. `php artisan migrate --seed` - для выполнения всех миграций и заполнение базы рандомными данными

Вход в админку через `Log in` в правом верхнем углу дефолтной страницы начального проекта Laravel

- admin@example.com/password - логин/пароль для админа

## Для проверки запросов рекомендуется postman

### Для тестирования запросов можно взять email рандомного пользователя из базы, пароль у всех одинаковый - `password`

1. Авторизация - http://book-store.test/api/login, тип запроса `POST`, json указываем вида:
```
{
    "email": "you@email",
    "password": "you_pass"
}
```
В ответ получаем токен, который будем использовать дальше

2. Обновление данных книги, авторизация под автором книги обязательна, тип запроса `PUT`, json указываем вида:
```
{
    "title": "new title",
    "edition": "digital"
}
```
В заголовки в `key` указываем `Authorization`, в `Value` `Bearer {token}`

3. Удаление книги, авторизация под автором книги обязательна, тип запроса `DELETE`
- http://book-store/api/books/{book}

В заголовки в `key` указываем `Authorization`, в `Value` `Bearer {token}`

4. Обновление данных автора, авторизация под автором обязательна, тип запроса `PUT`, json указываем вида:
```
{
    "name": "new name",
    "email": "new email",
    "password": "new password"
}
```
В заголовки в `key` указываем `Authorization`, в `Value` `Bearer {token}`

5. Получение списка книг с именем автора, авторизация не обязательна (с пагинацией), тип запроса `GET`
- http://book-store.test/api/books без пагинации
- http://book-store.test/api/books?page=2 с пагинацией

6. Получение данных книги по id, авторизация не обязательна, тип запроса `GET`
- http://book-store.test/api/books/{id}

7. Получение списка авторов с указанием количества книг, авторизация не обязательна (с пагинацией), тип запроса `GET`
- http://book-store.test/api/authors без пагинации
- http://book-store.test/api/authors?page=2 с пагинацией

8. Получение данных автора со списком книг, авторизация не обязательна, тип запроса `GET`
- http://book-store.test/api/authors/{id}

9. Список жанров со списком книг внутри (с пагинацией), тип запроса `GET`
- http://book-store.test/api/genres без пагинации
- http://book-store.test/api/genres?page=2 с пагинацией
