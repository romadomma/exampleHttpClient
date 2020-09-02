#ExampleHttpClient

Клиент для получения комментариев сервиса http://example.com

##Установка

`$ composer require romadomma/example-http-client`

##Быстрый старт

```
<? 
require 'vendor/autoload';
use ExampleHttpClient\ExampleClient;
use ExampleHttpClient\ExampleComment;
$client = new ExampleClient();
...
$comment = new ExampleComment([
    'name' => 'Roman', 
    'text' => 'First comment', 
]);
```

##API

###Получение комментариев

Функция `$client->getComments()` возвращает массив объектов `ExampleComment`

###Добавление комментария

Функция `$client->addComment($comment)` добавляет новый комментарий. На вход принимает объект `ExampleComment` и его же возвращает.

###Изменение комментария

Функция `$client->updateComment($comment)` изменяет существующий комментарий. На вход принимает объект `ExampleComment`, у которого обязательно должно быть заполнено поле `id`. Возвращает также объект класса `ExampleComment`.
