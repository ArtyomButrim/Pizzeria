<?php
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

$label = array(
	array(
		'firstLabelName' => 'Дата доставки:',
		'secondLabelName' => 'Время доставки:',
		'firstLabelType' => 'date',
		'secondLabelType' => 'time',
		'maxLength' => '20'
	),
	
	array(
		'firstLabelName' => 'Ваше имя:',
		'secondLabelName' => 'Ваш номер:',
		'firstLabelType' => 'text',
		'secondLabelType' => 'text',
		'maxLength' => '20'
	)
);

$input = array(
	array(
		'labelName' => 'Адреc доставки:',
		'labelType' => 'text',
		'maxlength' => '200'
	),
	array(
		'labelName' => 'Электронная почта:',
		'labelType' => 'text',
		'maxlength' => '200'
	)
);
	 
$twig = new Twig_Environment($loader, $options);

$result['label'] = $label;
$result['input'] = $input;

echo $twig->render('basket.html', $result);