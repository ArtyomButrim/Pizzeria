<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$special_offers = array(
	array(
		'name' => 'Каждая 10-я пицца бесплатно', 
		'img_url' => 'images/prize.png', 
		'info' => 'Пицца из печи', 
		'img_width' => '200','img_height' => '100',
		'class' => 'prize_image1'
	),
	array(
		'name' => 'Сертификат на пиццу', 
		'img_url' => 'images/win.jpg', 
		'info' => 'Пицца Двойная Пепперони',
		'img_width' => '100','img_height' => '100', 
		'class' => 'prize_image2'
	),
	array(
		'name' => 'Акция апреля', 
		'img_url' => 'images/drink.jpg', 
		'info' => 'Напиток при заказе пиццы в подарок!', 
		'img_width' => '200','img_height' => '100', 
		'class' => 'prize_image1'
	)
);
	
$informations = array(
	array(
		'first_info' => 'Пиццу мы выпекаем по традиционным итальянским технологиям - в настоящей печи на дровах!',
		'second_info' => 'Данная технология является уникальной на территории Республики Беларусь.', 
		'img_url' => 'images/pech.jpeg'
	),
	array(
		'first_info' => 'Готовим пиццу из качественных, преимущественно итальянских, продуктов.', 
		'second_info' => 'Пицца - как способ совершить маленькое гастрономическое путешествие в Италию!', 
		'img_url' => 'images/testo.jpg'
	)
);
	
$twig = new Twig_Environment($loader, $options);

$result['special_offers'] = $special_offers;
$result['informations'] = $informations;
echo $twig->render('index.html', $result);