<?

// Страница авторизации

include "config.php";

# Функция для генерации случайной строки

function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIHJKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}



# Соединямся с БД

mysql_connect($host, $db_login,$db_password);

mysql_select_db($db_name);


if(isset($_POST['submit']))

{

    # Вытаскиваем из БД запись, у которой логин равняеться введенному

    $query = mysql_query("SELECT user_id, user_password FROM wc__superusers WHERE user_login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");

    $data = mysql_fetch_assoc($query);

    

    # Соавниваем пароли

    if($data['user_password'] === ($_POST['password']))

    {

		session_start();

        # Генерируем случайное число и шифруем его

        $hash = md5(generateCode(10));

            

        if(!@$_POST['not_attach_ip'])

        {

            # Если пользователя выбрал привязку к IP

            # Переводим IP в строку

            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";

        }

        
        # Ставим куки

        setcookie("id", $data['user_id'], time()+60*60*24*30);

        setcookie("hash", $hash, time()+60*60*24*30);
		

        # Записываем в БД новый хеш авторизации и IP

        mysql_query("UPDATE wc__superusers SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
        

        # Переадресовываем браузер на страницу проверки нашего скрипта

        header("Location: check.php"); exit();

    }

    else

    {

        print "Вы ввели неправильный логин/пароль";

    }

}

?>

<form method="POST">

Login <input name="login" type="text"><br>

Password <input name="password" type="password"><br>

Remember me <input type="checkbox" name="not_attach_ip"><br>

<input name="submit" type="submit" value="Enter!">

</form>