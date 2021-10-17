<?php
require_once 'vendor/autoload.php';
require_once 'DataBase/dataBase.php';
require_once 'DataBase/extend.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

if (isset($_SESSION['id']))
{
	$result['code']=1;
}
else
{
	$result['code']=0;
}

if (isset($_POST['add_pizza_to_basket']))
{

	if(isset($_SESSION['id']))
	{
		$basket_data = new DataBase(NULL);

		if ($basket_data->getPizzaBasketInfoByIdAndUserID($_POST['add_pizza_to_basket'], $_SESSION['id'],'basket_pizza') == false)
		{
			$basketData = array(
				'id_user'=> $_SESSION['id'],
				'id_pizza' => $_POST['add_pizza_to_basket'],
				'count' => 1
			);

			$basket_data->insertBasketPizza($basketData);
		}	
		else
		{
			$Info = $basket_data->getPizzaBasketInfoByIdAndUserID($_POST['add_pizza_to_basket'], $_SESSION['id'],'basket_pizza');
			$newData=[
				'id'=>$Info['id'],
				'count_2'=> $Info['count']+1,
				'id_user' => $Info['id_user'],
				'id_pizza' => $Info['id_pizza']
			];
			$basket_data->UpdateBasketPizza($newData);
		}
	}
	else
	{
		alert('Воспользоваться корзиной могут только авторизованный пользователи!');
	}
}

$db_pizza = new DataBase(NULL);

$pizza = $db_pizza->getInfo('pizza');



$result['pizza'] = $pizza;
$twig = new Twig_Environment($loader, $options);

echo $twig->render('pizza.html',$result);


