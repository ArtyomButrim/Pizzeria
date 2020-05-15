<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$drinks = array(
	array(
		'imgURL' => 'images/cocacola.png',
		'price' => '2 руб.',
		'name' => 'Кока-Кола',
		'capacity' => '1,5 л.',
		'class' => 'drink_img1',
		'imgWidth' => '123',
		'imgHeight' => '300'
	),
	array(
		'imgURL' => 'images/schweppes2.png',
		'price' => '2 руб.',
		'info' => 'Лучшее дополненеи к любому столу из свежих овощей.',
		'name' => 'Швепс',
		'capacity' => '1,5 л.',
		'imgWidth' => '90',
		'imgHeight' => '300',
		'class' => 'drink_img2'
	),
	array(
		'imgURL' => 'images/sprite.png',
		'price' => '2 руб.',
		'name' => 'Спрайт',
		'capacity' => '1,5 л.',
		'class' => 'drink_img3',
		'imgWidth' => '109',
		'imgHeight' => '350'
	),
	array(
		'imgURL' => 'images/fanta.png',
		'price' => '2 руб.',
		'name' => 'Фанта',
		'capacity' => '1,5 л.',
		'class' => 'drink_img2',
		'imgWidth' => '90',
		'imgHeight' => '300'
	),
	array(
		'imgURL' => 'images/pepsi.png',
		'price' => '2 руб.',
		'name' => 'Пепси-Кола',
		'capacity' => '1,5 л.',
		'class' => 'drink_img2',
		'imgWidth' => '90',
		'imgHeight' => '300'
	)
);
	
$twig = new Twig_Environment($loader, $options);

echo $twig->render('drink.html', array('drinks' => $drinks));