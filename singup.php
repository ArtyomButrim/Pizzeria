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
	$result['code'] = '2';
	$data = $_POST;
	if (isset($data['do_singup']))
	{
		$isCorrect = isCorrectFieldPost($data['login']) && isCorrectFieldPost($data['password']) && isEmailCorrect($data['email']) && isCorrectFieldPost($data['password_2']);

		if ($isCorrect)
		{
			$db_users = new DataBase(NULL);
			
			if ($db_users->isItUserExists($data['login'],$data['email'])== false)
			{
			if ($data['password'] == $data['password_2'])
			{

				$now = date("Y-m-d");
				$userData = array(
					'login' => $data['login'],
					'password' => password_hash($data['password'], PASSWORD_DEFAULT),
					'email' => $data['email'],
					'date' => $now

	 			);

	 			try
	 			{
	 				$db_users->insertUser($userData); 

	 			}
	 			catch (PDOException $e)
	 			{
	 				print_r($e);
	 				print_r("\n");
	 			}	

	 			alert("Вы успешно зарегистрированы");
			}
			else
			{
				$message = "Повторный пароль введён неверно!";
				alert($message);
			}

		}
		else
		{
			$message = "Пользователь с таким логином и почтой уже существует!!";
				alert($message);
		}
	}
	else
	{
		$errors= array();
		if (!isCorrectFieldPost($data['login']))
		{
			$errors[] = 'Введите логин!';
		}
		if (!isEmailCorrect($data['email']))
		{
			$errors[] = 'Почта введена неверно!';
		}
		if (!isCorrectFieldPost($data['password']))
		{
			$errors[] = 'Введите пароль!';
		}
		if (!isCorrectFieldPost($data['password_2']))
		{
			$errors[] = 'Повторный пароль не был введён!';
		}

		alert(array_shift(($errors)));
	}
}
}

$twig = new Twig_Environment($loader, $options);

echo $twig->render('singup.html', $result);