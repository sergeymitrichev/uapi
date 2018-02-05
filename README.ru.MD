# PHP-клиент для uCoz API

PHP-клиент для работы с [uCoz API](http://api.ucoz.net).

## Обязательные требования

* PHP версии 5.4 и выше
* PHP-расширение cURL

## Установка

1) Установите [composer](https://getcomposer.org/download/)

2) Выполните в папке проекта:
```bash
composer require ucoz/uapi-client ~DEV
```

В конфиг `composer.json` вашего проекта будет добавлена библиотека `ucoz/uapi-client`, которая установится в папку `vendor/`. При отсутствии файла конфига или папки с вендорами они будут созданы.

В случае, если до этого в вашем проекте не использовался `composer`, подключите файл автозагрузки вендоров. Для этого укажите в коде проекта:
```php
require 'path/to/vendor/autoload.php';
```

## Модули

### Интернет-магазин

#### Товары
#### Категории
#### Корзина
#### Заказы

**ordersAddItem** добавление товара к заказу
```php
$uApi->request->ordersAddItem($orderHash, $productId);
```
**ordersUpdateItems** редактирование списка товаров в заказе
```php
$productsToUpdate = [
    '125'   =>  ['toDelete' => 1],
    '237'   =>  ['toDelete' => 1],
    '128'   =>  ['cnt' => 2, 'price' => 127.5],
    '521'   =>  ['cnt' => 3, 'price' => 4315.75],
];
$uApi->request->ordersUpdateItems($orderHash, $productsToUpdate);
```
**ordersChangeStatus** изменение статуса заказа
```php
$ids = "14,23,643,1267";
$statusId = 5;
$uApi->request->ordersChangeStatus($ids, $statusId);
```

### Пользователи