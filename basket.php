<?php
require_once 'vendor/autoload.php';
require_once 'DataBase/dataBase.php';
require_once 'DataBase/extend.php';

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

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

$db_basket = new DataBase(NULL);
if (isset($_POST['add_one_pizza']))
{
	$Info = $db_basket->getBasketPizzaInfoById($_POST['add_one_pizza']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']+1,
		'id_user' => $Info['id_user'],
		'id_pizza' => $Info['id_pizza']
	];
	$db_basket->UpdateBasketPizza($newData);
}

if (isset($_POST['delete_one_pizza']))
{
	$Info = $db_basket->getBasketPizzaInfoById($_POST['delete_one_pizza']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']-1,
		'id_user' => $Info['id_user'],
		'id_pizza' => $Info['id_pizza']
	];

	if ($newData['count_2']==0)
	{
		$db_basket->deleteBasketPizza($newData['id']);
	}
	else
	{
		$db_basket->UpdateBasketPizza($newData);
	}
}

if (isset($_POST['add_one_snack']))
{
	$Info = $db_basket->getBasketSnackInfoById($_POST['add_one_snack']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']+1,
		'id_user' => $Info['id_user'],
		'id_snack' => $Info['id_snack']
	];
	$db_basket->UpdateBasketSnack($newData);
}

if (isset($_POST['delete_one_snack']))
{
	$Info = $db_basket->getBasketSnackInfoById($_POST['delete_one_snack']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']-1,
		'id_user' => $Info['id_user'],
		'id_snack' => $Info['id_snack']
	];

	if ($newData['count_2'] == 0)
	{
		$db_basket->deleteBasketSnack($newData['id']);
	}
	else
	{
		$db_basket->UpdateBasketSnack($newData);
	}
}

if (isset($_POST['add_one_drink']))
{
	$Info = $db_basket->getBasketDrinkInfoById($_POST['add_one_drink']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']+1,
		'id_user' => $Info['id_user'],
		'id_drink' => $Info['id_drink']
	];
	$db_basket->UpdateBasketDrink($newData);
}

if (isset($_POST['delete_one_drink']))
{
	$Info = $db_basket->getBasketDrinkInfoById($_POST['delete_one_drink']);
	var_dump($Info);
	
	$newData=[
		'id'=>$Info['id'],
		'count_2'=> $Info['count']-1,
		'id_user' => $Info['id_user'],
		'id_drink' => $Info['id_drink']
	];

	if ($newData['count_2']==0)
	{
		$db_basket->deleteBasketDrink($newData['id']);
	}
	else
	{
		$db_basket->UpdateBasketDrink($newData);
	}
}

if (isset($_POST['delete_pizza']))
{
	$db_basket->deleteBasketPizza($_POST['delete_pizza']);
}

if (isset($_POST['delete_snack']))
{
	$db_basket->deleteBasketSnack($_POST['delete_snack']);
}

if (isset($_POST['delete_drink']))
{
	$db_basket->deleteBasketDrink($_POST['delete_drink']);
}

if (isset($_POST['delete_all_order']))
{
	$db_basket->deleteAllBasketPizzaByUserId($_SESSION['id']);
	$db_basket->deleteAllBasketSnackByUserId($_SESSION['id']);
	$db_basket->deleteAllBasketDrinkByUserId($_SESSION['id']);
}
$pizza = $db_basket->getBasketPizzaInfo($_SESSION['id']);
$snack = $db_basket->getBasketSnackInfo($_SESSION['id']);
$drink = $db_basket->getBasketDrinkInfo($_SESSION['id']);

$pizza_order = $db_basket->getPizzaOrder($pizza);
$snack_order = $db_basket->getSnackOrder($snack);
$drink_order = $db_basket->getDrinkOrder($drink);

$price = 0;
if ($pizza_order != NULL)
{
	foreach($pizza_order as $pizza)
	{
		$price += $pizza['price'];
	}
}

if ($snack_order != NULL)
{
	foreach($snack_order as $snack)
	{
		$price += $snack['price'];
	}
}

if ($drink_order != NULL)
{
	foreach($drink_order as $drink)
	{
		$price += $drink['price'];
	}
}

$result['price']= $price;

$db_users = new DataBase(NULL);
if (isset($_POST['letsgo'])) {
	$isCorrectPost = isCorrectFieldPost($_POST['name']) && isCorrectFieldPost($_POST['address']) && isCorrectFieldPost($_POST['comment']) && isNumberCorrect($_POST['number']) && isDateCorrect($_POST["date"]) && isTimeCorrect($_POST['time'], $_POST["date"] && $price>0);
	if ($isCorrectPost)
	{

		$infoUser = $db_users->getInfoById($_SESSION['id'],'users');
		$info='';
		$price = 0;
		if ($pizza_order != NULL)
		{
			foreach($pizza_order as $pizza)
			{
				$info = $info.$pizza['name'].'-'.$pizza['count'].' шт.,';
				$price += $pizza['price'];
			}
		}

		if ($snack_order != NULL)
		{
			foreach($snack_order as $snack)
			{
				$info = $info.$snack['name'].'-'.$snack['count'].' шт.,';
				$price += $snack['price'];
			}
		}

		if ($drink_order != NULL)
		{
			foreach($drink_order as $drink)
			{
				$info = $info.$drink['name'].'-'.$drink['count'].' шт.,';
				$price += $drink['price'];
			}
		}

		$userData = array(
			'date' => date("Y-m-d", strtotime($_POST["date"])),
			'phone' => phone($_POST['number']),
			'time' => $_POST['time'],
			'name' => $_POST['name'],
			'address' => $_POST['address'],
			'mail' => $infoUser['email'],
			'comment'=>$_POST['comment'],
			'info' => $info,
			'price' => $price
		);

		$db_users->insertData($userData);

		try {
		 			$email = $userData['mail'];
                    $mail = new PHPMailer\PHPMailer\PHPMailer();

                    $mail->isSMTP();
                    $mail->CharSet = 'UTF-8';
                    $mail->SMTPAuth = true;

                    $mail->Host = 'smtp.gmail.com';
                    $mail->Username = 'pizzeria.bravo.2020@gmail.com';
                    $mail->Password = '1133779924568i';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('pizzeria.bravo.2020@gmail.com', 'Пиццерия Браво');

                    $mail->addAddress("$email");

                    $mail->isHTML(true);

                    $mail->Subject = 'Пиццерия Браво:Заказ.';
                    $mail->Body = "Боагодарим за осуществление заказа в нашей пиццерри<br>
                                   <b>Ваш заказ:</b>".$userData['info']."<br>
                                   <b>Итоговая стоимость:</b>".$userData['price']."руб.<br><br>
                                 
                                   <b>Будет доставлен ".$userData['date']." приблизительно в ".$userData['time']." по адресу ".$userData['address']."</b>";

                     if ($mail->send()) 
                     {
                     	echo "success";
                     } 
                } catch (Exception $e) {
                    $textError = $mail->ErrorInfo;
                }		

		$db_users->deleteAllBasketPizzaByUserId($_SESSION['id']);
		$db_users->deleteAllBasketSnackByUserId($_SESSION['id']);
		$db_users->deleteAllBasketDrinkByUserId($_SESSION['id']);

		$pizza = $db_users->getBasketPizzaInfo($_SESSION['id']);
		$snack = $db_users->getBasketSnackInfo($_SESSION['id']);
		$drink = $db_users->getBasketDrinkInfo($_SESSION['id']);

		$pizza_order = $db_users->getPizzaOrder($pizza);
		$snack_order = $db_users->getSnackOrder($snack);
		$drink_order = $db_users->getDrinkOrder($drink);
		$result['price'] = 0; 
	}
	else
	{
		if ($price<=0)
		{
			alert('Корзина пуста');
		}
		else
		{
			alert('Что-то введено неверно');
		}
	}

}

$db_labels = new DataBase(NULL);

$label= $db_labels->getInfo('labels'); 

$db_input = new DataBase(NULL);

$input= $db_input->getInfo('input'); 
 
$twig = new Twig_Environment($loader, $options);

$result['label'] = $label;
$result['input'] = $input;
$result['pizza'] = $pizza_order;
$result['snack'] = $snack_order;
$result['drink'] = $drink_order;
echo $twig->render('basket.html', $result);