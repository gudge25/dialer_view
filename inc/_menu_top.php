<?PHP
$user_id = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
$usname = $prof_data["user"]; 

$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '$user_id'");
$refs = $db->FetchRow();
?>

        
        <div class="menu">
            <a href="/">Главная</a>
            <a href="/about">Об игре</a>
            <a href="/news">Новости</a>
            <a href="/payments">Статистика</a>
            <a href="/contacts">Контакты</a>
            <a href="/rules">Правила</a
        </div>
        
        <div class="button-place">
            <?if(isset($_SESSION["user"])){  ?>
            <a href="/account"><div class="button-big">ВЕРНУТСЯ В ИГРУ</div></a>
            <?PHP } else {	?>
            <!--<a href="/signup"><div class="button-big">РЕГИСТРАЦИЯ</div></a>-->
            <?PHP } ?>
        </div>
        
        <!--div class="social">
            <div style="float:left; margin-top:15px;">МЫ В СОЦ. СЕТЯХ</div>
            <a href="https://t.me/Carswar" target="blank"><img src="/img/telegram.png" style="margin-left:20px; margin-top:10px;"></a>
            <a href="https://vk.com/Carswar" target="blank"><img src="/img/vk.png" style="float:right; margin-top:10px;"></a>
            </div-->
            
            
            <div class="clr" style="height:60px;"></div>
        
        <center><a href="/"><img src="/img/logo.png"></a></center>
        





















