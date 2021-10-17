<?php
function phone($phone)
{
    if (empty($phone)) {
        return 'Номер не введён!!!';
    }

    $phone=trim($phone);
    $num=preg_match("/^\+375\((29|33|44|25)\)(\d){3}\-(\d){2}\-(\d){2}$/", $phone, $matches);
    																						
    if ($num != 0)
    {
    	return $matches[0];
    }
    else
    {

	    $phone = preg_replace("/[^0-9]/", "", $phone);

	    $correct =  preg_match("/^(375|80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$/", $phone);

	    if ($correct == 0)
	    {
	    	return "Введён некорректный номер!!!";
	    }
	    else
	    {
		    if (strlen($phone) == 12)
		    {
		    	$code = substr($phone, 3, 2);
		    	$number = substr($phone, 5, strlen($phone) - 5);
		    }
		    else
		    {
		    	$code = substr($phone, 2,2);
		    	$number = substr($phone, 4, strlen($phone)-4);
		    }

		    $number =  phoneBlocks($number);
		    $firstPart = "375";

		    $ResultFormOfNumber = "+".$firstPart."(".$code.")".$number;
		    
		    return $ResultFormOfNumber; 
		}
	}
}

function phoneBlocks($number){
    $add='';
    if (strlen($number)%2)
    {
        $add = $number[0];
        $number = substr($number, 1, strlen($number)-1);
    }
    return $add.implode("-", str_split($number, 2));
}

function isCorrectFieldPost($field) {
		$isCorrect = false;
		if (isset($field)) {
			$isCorrect =true;
			if ($field == '') {
				$isCorrect = false;
			}
		}
		return $isCorrect;
	}

function isNumberCorrect($number)
{
	if (empty($number)) {
        return false;
    }

    $phone=trim($number);
    $phone = preg_replace("/[^0-9]/", "", $phone);

    $correct =  preg_match("/^(375|80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$/", $phone);

    if ($correct == 0)
    {
    	return false;
    }
    else
    {
    	return true;
	}	
}

function isDateCorrect($date)
{
	$now = date("Y-m-d");
	if ($now > date("Y-m-d", strtotime($date)))
	{
		return false;
	}
	else 
	{
		return true;
	}
}

function isTimeCorrect($time, $date)
{
	$day = date("Y-m-d");
	$now = date("h:i:s");
	if ($day == date("Y-m-d", strtotime($date)) )
	{
		if ($now > $time)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}

function isEmailCorrect($mail)
{
	$email = trim($mail);
	 $num=preg_match("/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/", $email);

	 if ($num == 0)
	 {
	 	return false;
	 }
	 else
	 {
	 	return true;
	 }

}

function alert($msg) {
		echo "<script type = 'text/javascript'>alert('$msg');</script>";
	}