<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$pizza = array(
	array(
	'imgURL' => 'images/neapolitana.png',
	'number' => '1',
	'name' => 'Неаполитана',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Неаполитана скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/pepperony.png',
	'number' => '2',
	'name' => 'Пепперони',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Пепперони скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/tropicana.png',
	'number' => '3',
	'name' => 'Тропикана',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Тропикана скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/double_pepperony.png',
	'number' => '4',
	'name' => 'Двойная Пепперони',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Двойная Пепперони скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/mexic.png',
	'number' => '5',
	'name' => 'Мексиканская',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Мексиканская скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/havai.png',
	'number' => '6',
	'name' => 'Гавайская',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Гавайская скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	),
	array(
	'imgURL' => 'images/cheese.png',
	'number' => '7',
	'name' => 'Четыре сыра',
	'pizzaInfo' => 'Манящая, свежая, аппетитная классическая Четыре сыра скрасит любой вечер в любой компании.',
	'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование',
	'price' => '13 руб.'
	)
);
	
$twig = new Twig_Environment($loader, $options);

echo $twig->render('pizza.html',array('pizza' => $pizza));


