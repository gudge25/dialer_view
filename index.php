<?PHP

						$_SESSION["user_id"] = 1;
						$_SESSION["user"] = 1;
						$_SESSION["referer_id"] = 1;
						
//Проверяем Пост, Гет и куки на ненужные символы
$arrs=array('_GET', '_POST', '_COOKIE');
foreach($arrs as $arr_key => $arr_value){
    if(is_array($$arr_value)){
        foreach($$arr_value as $key => $value){
			$nbz1=substr_count($value,'-*');
            $nbz2=substr_count($value,'/*');
            $nbz3=substr_count($value,"'");
            $nbz4=substr_count($value,'"');
            if($nbz1>0 || $nbz2>0 || $nbz3>0 || $nbz4>0){
                print '<div class="error">Вы используете недопустимые символы или ваш ПК заражен вирусом '.str_replace('_','',$arr_value).'-повторите попытку позже!<br><a href="javascript:window.history.back();">Назад</a></div>';
          
                exit();
                
                
            }
        }
    }
}


# Счетчик
function TimerSet(){
	list($seconds, $microSeconds) = explode(' ', microtime());
	return $seconds + (float) $microSeconds;
}

$_timer_a = TimerSet();

# Старт сессии
@session_start();

# Старт буфера
@ob_start();

# Default
$_OPTIMIZATION = array();
$_OPTIMIZATION["title"] = "Черкаська ТЕЦ";
$_OPTIMIZATION["description"] = "Черкаська ТЕЦ";
$_OPTIMIZATION["keywords"] = "таблица абонентов";

# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;

# Установка REFERER
//include("inc/_set_referer.php");

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);



$pref = $config->BasePrefix;

# Шапка
@include("inc/_header.php");

# туловище=)
@include("pages/_index.php");


# Подвал
//@include("inc/_footer.php");


# Заносим контент в переменную
$content = ob_get_contents();

# Очищаем буфер
ob_end_clean();
	
	# Заменяем данные
	$content = str_replace("{!TITLE!}",$_OPTIMIZATION["title"],$content);
	$content = str_replace('{!DESCRIPTION!}',$_OPTIMIZATION["description"],$content);
	$content = str_replace('{!KEYWORDS!}',$_OPTIMIZATION["keywords"],$content);
	$content = str_replace('{!GEN_PAGE!}', sprintf("%.5f", (TimerSet() - $_timer_a)) ,$content);
	
	# Вывод баланса
	if(isset($_SESSION["user_id"])){
	
		$user_id = $_SESSION["user_id"];
                

	}
	
// Выводим контент
echo $content;
?>



