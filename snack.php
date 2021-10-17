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

if (isset($_POST['add_snack_to_basket']))
{

	if(isset($_SESSION['id']))
	{
		$basket_data = new DataBase(NULL);

		if ($basket_data->getSnackBasketInfoByIdAndUserID($_POST['add_snack_to_basket'], $_SESSION['id'],'basket_snack') == false)
		{
			$basketData = array(
				'id_user'=> $_SESSION['id'],
				'id_snack' => $_POST['add_snack_to_basket'],
				'count' => 1
			);

			$basket_data->insertBasketSnack($basketData);

		}
		else
		{
			$Info = $basket_data->getSnackBasketInfoByIdAndUserID($_POST['add_snack_to_basket'], $_SESSION['id'],'basket_snack');
			$newData=[
				'id'=>$Info['id'],
				'count_2'=> $Info['count']+1,
				'id_user' => $Info['id_user'],
				'id_snack' => $Info['id_snack']
			];
			$basket_data->UpdateBasketSnack($newData);
		}
	}
	else
	{
		alert('Воспользоваться корзиной могут только авторизованный пользователи!');
	}
}

$db_snacks = new DataBase(NULL);

$snack = $db_snacks->getInfo('snacks');

$result['snacks'] = $snack;	
$twig = new Twig_Environment($loader, $options);

echo $twig->render('snack.html',$result);


