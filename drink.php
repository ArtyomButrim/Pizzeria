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

if (isset($_POST['add_drink_to_basket']))
{

	if(isset($_SESSION['id']))
	{
		$basket_data = new DataBase(NULL);
		
		if ($basket_data->getDrinkBasketInfoByIdAndUserID($_POST['add_drink_to_basket'], $_SESSION['id'],'basket_drink') == false)
		{
			$basketData = array(
				'id_user'=> $_SESSION['id'],
				'id_drink' => $_POST['add_drink_to_basket'],
				'count' => 1
			);

			$basket_data->insertBasketDrink($basketData);
		}
		else
		{
			$Info = $basket_data->getDrinkBasketInfoByIdAndUserID($_POST['add_drink_to_basket'], $_SESSION['id'],'basket_drink');
			$newData=[
				'id'=>$Info['id'],
				'count_2'=> $Info['count']+1,
				'id_user' => $Info['id_user'],
				'id_drink' => $Info['id_drink']
			];
			$basket_data->UpdateBasketDrink($newData);
		}
	}
	else
	{
		alert('Воспользоваться корзиной могут только авторизованный пользователи!');
	}
}
$db_drinks = new DataBase(NULL);

$drinks= $db_drinks->getInfo('drinks'); 

$twig = new Twig_Environment($loader, $options);

$result['drinks'] = $drinks;

echo $twig->render('drink.html', $result);