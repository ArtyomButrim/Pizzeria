<?php
require_once 'vendor/autoload.php';
require_once 'DataBase/dataBase.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$db_specialOffers = new DataBase(NULL);

if (isset($_SESSION['id']))
{
	$result['code']=1;
}
else
{
	$result['code']=0;
}

$special_offers= $db_specialOffers->getInfo('special_offers'); 

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