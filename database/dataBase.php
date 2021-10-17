<?php
	
	session_start();

	class DataBase {

		public $host;
		public $db;
		private $user;
		private $pass;
		public $charset;
		public $pdo;

		public function __construct($db_data) {
			if ($db_data == NULL) {
				$db_data = [
					'host' => 'localhost',
					'db' => 'pizza_order',
					'user' => '',
					'pass' => '',
					'charset' => 'utf8',
				];
			}
			$this->host  = $db_data['host'];
			$this->db = $db_data['db'];
			$this->user = $db_data['user'];
			$this->pass = $db_data['pass'];
			$this->charset = $db_data['charset'];
			$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
			$opt = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			];
			$this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
		}

		private function formatInfoList($Informations) {
			foreach($Informations as $key => $Information) {
				$Informations[$key] = $Information;
			}
			return $Informations;
		}

		public function getInfoById($id, $name) {
			$data = [
				'id' => $id,
			];

			$sth = $this->pdo->prepare("SELECT * FROM $name where id = :id ");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}


		public function getInfo($name) {
			$Info = [];
			$data = $this->pdo->query("SELECT * FROM $name");
			$info_ids = $data->fetchAll();

			foreach ($info_ids as $id) {
				$curr_id = $id['id'];
				array_push($Info, $this->getInfoById($curr_id, $name));
			}

			$Info = $this->formatInfoList($Info);

			return $Info;
		}

		public function insertData($data) {
			$sth = $this->pdo->prepare("INSERT INTO orders SET date=:date,phone=:phone,time=:time,name=:name,address=:address,mail=:mail,comment=:comment, info=:info, price=:price");
			$sth->execute($data);
			return $this->pdo->lastInsertId();
		}

		public function insertUser($userData) {
			$sth = $this->pdo->prepare("INSERT INTO users SET sing_up_date=:date,login =:login,password=:password,email=:email");
			$sth->execute($userData);
			return $this->pdo->lastInsertId();
		}

		public function insertBasketDrink($basketData) {
			$sth = $this->pdo->prepare("INSERT INTO basket_drink SET id_user=:id_user,id_drink =:id_drink,count=:count");
			$sth->execute($basketData);
			return $this->pdo->lastInsertId();
		}

		public function insertBasketPizza($basketData) {
			$sth = $this->pdo->prepare("INSERT INTO basket_pizza SET id_user=:id_user,id_pizza =:id_pizza,count=:count");
			$sth->execute($basketData);
			return $this->pdo->lastInsertId();
		}

		public function insertBasketSnack($basketData) {
			$sth = $this->pdo->prepare("INSERT INTO basket_snack SET id_user=:id_user,id_snack =:id_snack,count=:count");
			$sth->execute($basketData);
			return $this->pdo->lastInsertId();
		}

		public function isUserExists($login)
		{
			$data = [
				'login' => $login,
			];

			$sth = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE login = :login");
			$sth->execute($data);
			$count = $sth->fetchColumn();
			if ($count > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function getUserData($login) 
		{
			$data = [
				'login' => $login,
			];
			$sth = $this->pdo->prepare("SELECT id, login, password FROM users WHERE login = :login");
			$sth->execute($data);
			return $sth->fetch();
		}


		private function formatBasketInfoList($Informations) {
			foreach($Informations as $key => $Information) {
				$Informations[$key] = $Information;
			}
			return $Informations;
		}

		public function getCountAtInfo($name) {
			$Info = [];
			$data = $this->pdo->query("SELECT * FROM $name");
			$info_ids = $data->fetchAll();

			foreach ($info_ids as $id) {
				$curr_id = $id['id'];
				array_push($Info, $this->getInfoById($curr_id, $name));
			}

			$Info = $this->formatInfoList($Info);

			return count($Info);
		}

		public function getPizzaOrder($massiv)
		{
			$result = NULL;
			$i=0;
			foreach ($massiv as $key => $element)
			{
					$db = new DataBase(NULL);
					$info = $db->getInfoById($element['id_pizza'],'pizza');

					$result[$i] = array(
						'id' => $element['id'],
						'name' => 'Пицца '.$info['name'],
						'price' => $info['price']*$element['count'],
						'count' => $element['count'] 
					);

					$i++;
			}
			return $result;
		}

		public function getSnackOrder($massiv)
		{
			$result = NULL;
			$i=0;
			foreach ($massiv as $key => $element)
			{
					$db = new DataBase(NULL);
					$info = $db->getInfoById($element['id_snack'],'snacks');

					$result[$i] = array(
						'id' => $element['id'],
						'name' =>  $info['name'],
						'price' => $info['price']*$element['count'],
						'count' => $element['count'] 
					);

					$i++;
 
			}
			return $result;
		}

		public function getDrinkOrder($massiv)
		{
			$result = NULL;
			$i=0;
			foreach ($massiv as $key => $element)
			{
					$db = new DataBase(NULL);
					$info = $db->getInfoById($element['id_drink'],'drinks');

					$result[$i] = array(
						'id' => $element['id'],
						'name' => 'Напиток '.$info['name'],
						'price' => $info['price']*$element['count'],
						'count' => $element['count'] 
					);

					$i++;

			}
			return $result;
		}

		public function getPizzaBasketInfoByIdAndUserID($id,$userId, $name) {
			$data = [
				'id' => $id,
				'userId' => $userId
			];

			$sth = $this->pdo->prepare("SELECT * FROM $name where id_user =:userId and id_pizza=:id  ");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}
		public function UpdateBasketPizza($data) {
			$sth = $this->pdo->prepare("UPDATE basket_pizza SET count=:count_2, id_pizza=:id_pizza, id_user=:id_user WHERE id=:id");
			$sth->execute($data);
		}

		public function getSnackBasketInfoByIdAndUserID($id,$userId, $name) {
			$data = [
				'id' => $id,
				'userId' => $userId
			];

			$sth = $this->pdo->prepare("SELECT * FROM $name where id_user =:userId and id_snack=:id  ");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}
		public function UpdateBasketSnack($data) {
			$sth = $this->pdo->prepare("UPDATE basket_snack SET count=:count_2, id_snack=:id_snack, id_user=:id_user WHERE id=:id");
			$sth->execute($data);
		}

		public function getDrinkBasketInfoByIdAndUserID($id,$userId, $name) {
			$data = [
				'id' => $id,
				'userId' => $userId
			];

			$sth = $this->pdo->prepare("SELECT * FROM $name where id_user =:userId and id_drink=:id  ");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}
		public function UpdateBasketDrink($data) {
			$sth = $this->pdo->prepare("UPDATE basket_drink SET count=:count_2, id_drink=:id_drink, id_user=:id_user WHERE id=:id");
			$sth->execute($data);
		}

		public function getBasketPizzaInfo($user_id) {
			$Info = [];
			$data = $this->pdo->query("SELECT * FROM basket_pizza");
			$info_ids = $data->fetchAll();

			foreach ($info_ids as $id) {
				if ($user_id==$id['id_user'])
				{
					$curr_id = $id['id'];
					array_push($Info, $this->getBasketPizzaInfoById($curr_id));
				}
			}

			$Info = $this->formatInfoList($Info);

			return $Info;
		}

		public function getBasketPizzaInfoById($id) {
			$data = [
				'id' => $id,
			];

			$sth = $this->pdo->prepare("SELECT * FROM basket_pizza where id = :id");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}

			public function getBasketSnackInfo($user_id) {
			$Info = [];
			$data = $this->pdo->query("SELECT * FROM basket_snack");
			$info_ids = $data->fetchAll();

			foreach ($info_ids as $id) {
				if ($user_id==$id['id_user'])
				{
					$curr_id = $id['id'];
					array_push($Info, $this->getBasketSnackInfoById($curr_id));
				}
			}

			$Info = $this->formatInfoList($Info);

			return $Info;
		}

		public function getBasketDrinkInfo($user_id) {
			$Info = [];
			$data = $this->pdo->query("SELECT * FROM basket_drink");
			$info_ids = $data->fetchAll();

			foreach ($info_ids as $id) {
				if ($user_id==$id['id_user'])
				{
				$curr_id = $id['id'];
					array_push($Info, $this->getBasketDrinkInfoById($curr_id));
				}
			}

			$Info = $this->formatInfoList($Info);

			return $Info;
		}

		public function getBasketSnackInfoById($id) {
			$data = [
				'id' => $id
			];

			$sth = $this->pdo->prepare("SELECT * FROM basket_snack where id = :id");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}

		public function getBasketDrinkInfoById($id) {
			$data = [
				'id' => $id
			];

			$sth = $this->pdo->prepare("SELECT * FROM basket_drink where id = :id");
			$sth->execute($data);
			$Info = $sth->fetch();
			if ($Info) {
				return $Info;
			} else {
				return false;
			}
		}

		public function deleteBasketPizza($id) {
			$data = [
				'id' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_pizza where id = :id");
			$sth->execute($data);
		}

		public function deleteBasketSnack($id) {
			$data = [
				'id' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_snack where id = :id");
			$sth->execute($data);
		}

		public function deleteBasketDrink($id) {
			$data = [
				'id' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_drink where id = :id");
			$sth->execute($data);
		}

		public function deleteAllBasketPizzaByUserId($id) {
			$data = [
				'id_user' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_pizza where id_user = :id_user");
			$sth->execute($data);
		}

		public function deleteAllBasketSnackByUserId($id) {
			$data = [
				'id_user' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_snack where id_user = :id_user");
			$sth->execute($data);
		}

		public function deleteAllBasketDrinkByUserId($id) {
			$data = [
				'id_user' => $id,
			];

			$sth = $this->pdo->prepare("DELETE FROM basket_drink where id_user = :id_user");
			$sth->execute($data);
		}

		public function isItUserExists($login, $email)
		{
			$data = [
				'login' => $login,
				'email' => $email
			];

			$sth = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE login = :login AND email=:email");
			$sth->execute($data);
			$count = $sth->fetchColumn();
			if ($count > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
