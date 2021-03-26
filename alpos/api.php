<?php


/**
*
* Обязательные поля для заполнения вручную
*
**/

$productId    = 119525;   // id товара в системе
$productPrice = 0 ;   // цена товара при создании заказа
$thankUrl     = 'http://poz.ocisha3.xyz/thanks.html'; // урл вашей страницы спасибо


/**
*   Настройки для передачи заказов по формату CPA
*   Дефолтное значение false, что означает заказ передается как обычный 'по выкупу''
**/

$isCPA = false;

/**
*   Если вы хотите передавать заказ по формату СРА, раскомментируйте код ниже 
*   и вместо '1' вставьте значение конкретного товара на сттанице офферов из столбца 'ID для апи' https://prnt.sc/v2egm3
*
**/


$isCPA = array('id' => 152);


/**
*
* Необязательные поля для заполнения вручную
*
**/

$comment       = '';  // комментарий в заказе
$streamId      = 42881; // id потока в системе (заказ будет привязываться к конретному потоку. полезно при настройке постбека)
$processedByMe = false; // для передачи отделения Новой почты записываем объект {'warehouse' : 'XXXX-XXXX' }, где XXXX-XXXX - хеш отделения, который отдается новой почтой, например, 661346c1-3796-11ea-8461-0025b502a04e

/**
*
* Автоматические поля
*
**/

$name = $_POST['name'];
$phone = $_POST['phone'];
$source = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';


$url = 'http://courier.darkleads.pro/data/exchange/extpartner/addorderapi.php';                 
$post = array();
$post['api_key'] = 'kZb?CEx97kdeNzpvsRJd';
$post['product_id'] = $productId;     
$post['stream_id'] = $streamId;        
$post['phone'] = $phone;
$post['price'] = $productPrice;
$post['name'] = $name;
$post['comment'] = $comment;
$post['source'] = $source;
$post['processedByMe'] = $processedByMe;
$post['is_cpa'] = $isCPA;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close ($ch);


$response = json_decode($server_output);
if ($response->result !== 'ok') {
    die($response->result);
}

header('location:' . $thankUrl);
?>