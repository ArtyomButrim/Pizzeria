<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$snacks = array(
	array(
		'imgURL' => 'images/salat1.jpg',
		'price' => '0,65 руб.',
		'weight' => '100 гр.',
		'info' => 'Лучшее дополненеи к любому столу из свежих овощей.',
		'name' => 'Салат Греческий',
		'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование'
	),
	array(
		'imgURL' => 'images/salat2.jpg',
		'price' => '0,65 руб.',
		'weight' => '100 гр.',
		'info' => 'Лучшее дополненеи к любому столу из свежих овощей.',
		'name' => 'Салат Монтекристо',
		'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование'
	),
	array(
		'imgURL' => 'images/salat3.jpg',
		'price' => '0,65 руб.',
		'weight' => '100 гр.',
		'info' => 'Лучшее дополненеи к любому столу из свежих овощей.',
		'name' => 'Салат Оливье',
		'ingredients' => 'сыр, грибы, чеснок, острый перец, ущёдлинное наименование'
	)
);
	
$twig = new Twig_Environment($loader, $options);

echo $twig->render('snack.html', array('snacks' => $snacks));


