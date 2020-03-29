 <div class="container-fluid">
 <h4>Welcome</h4>
 <img src="<?php $adress=explode("/", $this->fileLink); echo $adress[2]."/".$adress[3]; ?>" style="height:50px; border-radius:10px;" alt="Альтернативный текст">
 <br>
 <!-- 1. В базу сразу писать правильный адресс
	2. проверка картинка или нет
3. перечитать задание, какой файл нужно грузить-->
 <?=$this->getErros();?>
 <?=$this->userLogin;?> ( <?=$this->userName;  ?>)
  <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<input type="submit" class="btn btn-sm btn-outline-info" name="doLogout" value="Logout" />
 </form>
</div>
