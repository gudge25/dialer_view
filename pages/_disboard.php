<?

if(isset($_GET["clear"])){
	
	$db->query("TRUNCATE `db_phone`");
	header('Location: /');
			   
}


if($_POST['dellall'] == 'ok'){
	
	
	foreach($_COOKIE as $key=>$value)
	{
		
		if(substr($key,0,2) == 'ch')
			$short = mb_substr($key, 2);
		else
			continue;

		$db->Query("DELETE FROM `db_phone` WHERE `id` = '".$short."' ");
		$coock = 'ch'.$short;
		setcookie($coock, 0, time()+100);
		
	}
	
	header('Location: /');
}



if($_GET["del"] > 0){
	
	$id = (int)$_GET["del"];
	$db->Query("DELETE FROM `db_phone` WHERE `id` = '".$id."' ");
	header('Location: /'); 
}

if(isset($_POST["nls"]) AND !isset($_POST["edit"])){
	
	$nls = $_POST["nls"];
	$phone = $_POST["phone"];
	$result = $_POST["result"];
	

	if($result == 'в очереди')
	    $res = 0;
	if($result == 'недоступен')
	    $res = 1;
	if($result == 'прослушал')
	    $res = 2;
    if($result == 'отбился')
	    $res = 3;
	
	$db->Query("INSERT INTO `db_phone` (`npp`, `ls`, `phone`, `resultat`, `res`, `status`) VALUES ('1', '$nls', '$phone', '$result','$res', '0')");
	
header('Location: /'); 
}


if(isset($_POST["edit"])){
	
	$id = $_POST["edit"];
	$nls = $_POST["nls"];
	$phone = $_POST["phone"];
	$result = $_POST["resultat"];
	
	if($result == 'в очереди')
	    $res = 0;
	if($result == 'недоступен')
	    $res = 1;
	if($result == 'прослушал')
	    $res = 2;
    if($result == 'отбился')
	    $res = 3;
	
	
	$db->Query("UPDATE `db_phone` SET `ls`='$nls', `phone`='$phone', `resultat`='$result', `res`= '$res' WHERE `id` = '$id' ");


}


?>      
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<!-- Add Project -->
				
				
             
                <!-- row -->


                <div class="row">
                    
                    
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">База Обзвона</h4>
			
			
			<button style="font-size: 17px; cursor: pointer;" class="btn btn-success shadow btn-xs sharp sweet-text1"><i class="fa fa-plus-circle"></i></button>							

		<script>
		var idbutton = 1;
		var arsweet = ".sweet-text" + idbutton;
		var formss = "'<div class='basic-form'><form action='/' method='post' ><div class='form-group row'><div class='col-sm-12'><input name='nls' type='text' class='form-control' placeholder='Номер лицевого счета'></div></div><div class='form-group row'><div class='col-sm-12'><input name='phone' type='text' class='form-control' placeholder='Номер Телефона'></div></div><div class='form-group row'><div class='col-sm-12'><select class='form-control default-select form-control-lg' name='result'><option disabled>Выберите результат</option><option value='в очереди' selected>в очереди</option><option value='недоступен'>недоступен</option><option value='прослушал'>прослушал</option><option value='отбился'>отбился</option></select></div></div><div class='form-group row'><div class='col-sm-12'><button type='submit' class='btn btn-primary'>Сохранить</button></div></div></form></div>';";
	
		document.querySelector(arsweet).onclick = function () {
		swal({
			title: "Введите данные",
			html: formss,
			type: "input",
			showCancelButton: !0,
			closeOnConfirm: !1,
			
			showConfirmButton: false, // There won't be any confirm button
			animation: "slide-from-top",
			inputPlaceholder: "Write something"
		}, function (e) {
			return !1 !== e && ("" === e ? (swal.showInputError("You need to write something!"), !1) : void swal("Hey !!", "You wrote: " + e, "success"))
		})
	}
	
	</script>
			
			
			
			

<link type="text/css" rel="stylesheet" href="/uploads/css/reset.css">
<link type="text/css" rel="stylesheet" href="/uploads/css/style.css">

					
	
	<div title='Нажмите сюда или перетащите excel для загрузки.' id="drop-zone2">
	<span class="text"></span>		
	<div id="showUpFile2"></div>		
	<i class="btn btn-secondary shadow btn-xs sharp fa fa-download " style="cursor:pointer;">
	<input id="file2" type="file" style="opacity: 0; cursor:pointer;">
	</i>
    </div>
	
				
				

<script>
	
	var dropZone2 = document.getElementById("drop-zone2");
	var msgConteiner = document.querySelector("#drop-zone2.text");
	
	var eventClear = function (e) {
		e.stopPropagation();
		e.preventDefault();
	}
	
	dropZone2.addEventListener("dragenter", eventClear, false);
	dropZone2.addEventListener("dragover", eventClear, false);
	
	dropZone2.addEventListener("drop", function (e) {
			if(!e.dataTransfer.files) return;
			e.stopPropagation();
			e.preventDefault();

			sendFile(e.dataTransfer.files[0]);
		}, false);
	
	document.getElementById("file2").addEventListener("change", function (e) {
			sendFile(e.target.files[0]);
		}, false);
	
	
	var statChange = function (e) {
		if (e.target.readyState == 4) {
			if (e.target.status == 200) {
				//msgConteiner.innerHTML = "Загрузка успешно завершена!";
				location.reload();
				//document.location.href = '/import.php';
				dropZone2.classList.remove("error");
				dropZone2.classList.add("success");
				
				document.getElementById("showUpFile2").innerHTML = this.responseText;
			} else {
				msgConteiner.innerHTML = "Произошла ошибка!";
				dropZone2.classList.remove("success");
				dropZone2.classList.add("error");
			}
		}
	}
	
	var showProgress = function(e) {
		if (e.lengthComputable) {
			var percent = Math.floor((e.loaded / e.total) * 100);
			msgConteiner.innerHTML = "Загрузка... ("+ percent +"%)";
		}
	};
	
	var sendFile = function(file) {
		dropZone2.classList.remove("success");
		dropZone2.classList.remove("error");
		
		var re = /(\.xls|\.xlsx|\.xls|\.xlsx|\.csv)$/i;
		
		var pos = file.name.indexOf("`");
		var pos1 = file.name.indexOf("'");
		var pos2 = file.name.indexOf("=");
		
		if(pos>0 || pos1>0 || pos2 >0)
		{
			
				dropZone2.classList.add("error");
				e.target.status = 0;
				msgConteiner.innerHTML = "Недопустимое имя файла!";
				
		}
		
		if (!re.exec(file.name)) {
			
			msgConteiner.innerHTML = "Недопустимый формат файла!";
			dropZone2.classList.remove("success");
			dropZone2.classList.add("error");
		}
		else {
			var fd = new FormData();
			fd.append("upfile", file);
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "/uploads/uploadxls.php", true);
			
			xhr.upload.onprogress = showProgress;
			xhr.onreadystatechange = statChange;
			
			xhr.send(fd);
		}
	}
	
</script>


	
		<a href="/exel.php?export=xls" style="font-size: 17px;" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-cloud-upload"></i></a>
		<a href="/?clear=yes" style="font-size: 17px; color:red; background:white;" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-times-circle"></i></a>			

					  </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
												<th>
												
													<div class='basic-form'>
													<form action='/' method='post' >
													<input hidden name="dellall" value='ok'>
													<button type='submit' class="btn-danger btn shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
												    </form>
													</div>

												</th>
												
                                                <th>№ п/п</th>
                                                <th>№ л/с</th>
                                                <th>Телефон</th>
                                                <th>Результат</th>
                                                <th>Действие</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										
										
	
										<?
										$db->Query("SELECT * FROM db_phone ");
										while ($row_view = $db->FetchArray())
										{
										?>			
                                            <tr>
												<td>
						
						
						<?
						$coockid = $row_view['id'];
						$strcoockie = 'ch'.$coockid;
						if($_COOKIE[$strcoockie] == 1)
						$check = 'checked';
						else
						$check = '';
					
						?>
						<div class="custom-control custom-checkbox ml-2" style="position: absolute;">
						<input <?=$check;?> onClick="submitForm('ch<?=$row_view['id'];?>')" name="checkbox<?=$row_view['id'];?>" type="checkbox" class="custom-control-input" id="customCheckBox<?=$row_view['id'];?>" required="">
						<label class="custom-control-label" for="customCheckBox<?=$row_view['id'];?>"></label>
						
						
						</div>
												
												</td>
												
                                                <td><?=$row_view['npp'];?></td>
                                                <td><?=$row_view['ls'];?></td>
                                                <td><?=$row_view['phone'];?></td>
                                                
                                                
                                                <?
                                                	if($row_view['res'] == 0)
                                                	    $restext = 'в очереди';
                                                	if($row_view['res'] == 1)
                                                	    $restext = 'недоступен';
                                                	if($row_view['res'] == 2)
                                                	    $restext = 'прослушал';
                                                    if($row_view['res'] == 3)
                                                	    $restext = 'отбился';
	                                            ?>
	                                            
                                                <td><?=$restext;?></td>
                                                
                                                
                                                
                                                
                                                <td>
													<div class="d-flex">
		
    <button style="font-size: 17px; cursor: pointer;" class="btn btn-warning shadow btn-xs sharp sweet-text-edit<?=$row_view['id'];?>"><i class="fa fa-pencil"></i></button>							



	<script>
		var idbutton = <?=$row_view['id'];?>;
		var arsweetedit = ".sweet-text-edit"+"<?=$row_view['id'];?>";
	
		document.querySelector(arsweetedit).onclick = function () {
		swal({
			title: "Отредактируйте данные id:"+<?=$row_view['id'];?>,
			html: "<div class='basic-form'><form action='/' method='post' ><div class='form-group row'><div class='col-sm-12'><input name='nls' value='<?=$row_view['ls'];?>' type='text' class='form-control' placeholder='Номер лицевого счета'></div></div><div class='form-group row'><div class='col-sm-12'><input value='<?=$row_view['phone'];?>' name='phone' type='text' class='form-control' placeholder='Номер Телефона'></div></div><div class='form-group row'><div class='col-sm-12'><select class='form-control default-select form-control-lg' name='resultat'><option disabled>Выберите результат</option><option value='в очереди' selected>в очереди</option><option value='недоступен'>недоступен</option><option value='прослушал'>прослушал</option><option value='отбился'>отбился</option></select><input name='edit' value='<?=$row_view['id'];?>' type='hidden'> </div></div><div class='form-group row'><div class='col-sm-12'><button type='submit' class='btn btn-primary'>Сохранить</button></div></div></form></div>",
			type: "input",
			showCancelButton: !0,
			closeOnConfirm: !1,
			
			showConfirmButton: false, // There won't be any confirm button
			animation: "slide-from-top",
			inputPlaceholder: "Write something"
		}, function (e) {
			return !1 !== e && ("" === e ? (swal.showInputError("You need to write something!"), !1) : void swal("Hey !!", "You wrote: " + e, "success"))
		})
	}
	
	</script>			  
			  
			 

		<button style="font-size: 17px;" class="btn-danger btn shadow btn-xs sharp mr-1 sweet-confirm<?=$row_view['id'];?>"><i class="fa fa-trash"></i></button>							
			  
		<script>
		
		var idbutton = <?=$row_view['id'];?>;
		var arsweet = ".sweet-confirm" + idbutton;
		document.querySelector(arsweet).onclick = function () {
		swal({
			title: "Удаление записи!",
			text: "Вы уверены, что хотите удалить запись ?",
			type: "warning",
			showCancelButton: !0,
			confirmButtonColor: "#000000",
			confirmButtonText: "<a href='?del="+<?=$row_view['id'];?>+"'> Да, удалить !! </a>",
			closeOnConfirm: !1
		}, function () {
			swal("Deleted !!", "Hey, your imaginary file has been deleted !!", "success")
		});
		}
	</script>
	
													</div>												
												</td>												
                                            </tr>
                                            
<?
  
}

?>	


<script>			
	function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

//сохранить
var location_name = $(".location-input").val();
setCookie('location_name', location_name, 365);

//прочитать
var location_name = getCookie('getCookie');
if (location_name != '')
{
    $(".location-input").val(location_name);
}
</script>
						
						

<script>
function submitForm(id) {
	
	if(getCookie(id)==1)
	{
		setCookie(id, 0, 1);
		//alert('отключаю');
	}
	else
	{
		setCookie(id, 1, 1);
		//alert('подключаю');
	}

  $("#" + id).submit(function(e) {
    e.preventDefault();
    for (let i = 0; i < e.target.length - 1; i++) {
      console.log(e.target[i].name, e.target[i].value);
    }
  });
}
</script>


					
                                        </tbody>
                                    </>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


     




    <!--**********************************
        Scripts
    ***********************************-->
	
    <!-- Datatable -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../js/plugins-init/datatables.init.js"></script>

    <link href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Required vendors -->
    <script src="./vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <!--script src="./js/plugins-init/sweetalert.init.js"></script-->
    
	
