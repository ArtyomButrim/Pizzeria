<?php
require_once 'vendor/autoload.php';
require_once 'DataBase/dataBase.php';
require_once 'DataBase/extend.php';

$loader = new Twig_Loader_Filesystem("templates");

$options  = array(
		'cache' => 'compilation_cache',
		'auto_reload' => true
);

if (!(isset($_SESSION['id']))) 
{
	$result['code'] = 3;
	$data = $_POST;
	if (isset($data['do_login']))
	{
		$db_users = new DataBase(NULL);
		if ($db_users->isUserExists($data['login']))
		{
			$isCorrect = isCorrectFieldPost($data['login']) && isCorrectFieldPost($data['password']) ;

			if ($isCorrect)
			{
				$userData = $db_users->getUserData($data['login']);
				$password = $userData['password'];
				if (password_verify($data['password'], $password))
				{
					$_SESSION['id'] = $userData['id'];
					header("Location: index.php");
				}
				else
				{
					alert("Неверный	пароль");
				}
			}
			else
			{
				$errors= array();
				if (!isCorrectFieldPost($data['login']))
				{
					$errors[] = 'Введите логин!';
				}
				
				if (!isCorrectFieldPost($data['password']))
				{
					$errors[] = 'Введите пароль!';
				}

				alert(array_shift(($errors)));
			}
		}
		else
		{
			alert('Такого польльзователя нет');
		}

	}
}
else
{
	header("Location: index.php");
}
$twig = new Twig_Environment($loader, $options);

echo $twig->render('login.html', $result);