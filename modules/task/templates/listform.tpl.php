 <!--<h3>Login</h3>-->
 <?php //$this->getErros();?>
 <?php //var_dump($this->model); 
 ?>
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!--NEW

 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="css/style.css">


<?php
$arr = $this->makeArr();
$abble=$this->getPernissions();
if (!isset($_SESSION['user_id'])){
/*echo '<div class="container-fluid" style="max-width:1200px">
<form class="form-inline" method="post" >
  <label class="sr-only" for="inlineFormInputName2">Name</label>
  <input type="text" name="userLogin" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Loggin">

  <label class="sr-only" for="inlineFormInputGroupUsername2">Password</label>
  <div class="input-group mb-2 mr-sm-2">
        <input type="password" name="userPswd" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Password">
  </div>
  <input type="submit" name="doLogin" class="btn btn-primary" value="Loggin">
</form>
</div>';*/
echo'
<div class="container-fluid" style="margin: 20px; border-radius: 10px; max-width:1200px">
  <form action="" method="post" >
  <input type="submit" name="toLoginPage" class="btn btn-primary" value="Loggin">
  </form>
  </div>';
}
else {
 echo' <div class="container-fluid" >
  <form class="form-inline" method="post" style="margin-bottom: 20px; margin-top:20px;">
   <p>Hello '.$_SESSION['user_name'].'!&nbsp;</p>
   <input type="submit" name="doLogout" class="btn btn-primary" value="Logout">
  </form>
  </div>';

}

if ($this->model['LOGGINERROR']!='')
{
     echo '<p style="color:#F84E5C;font-size: 14px; font-weight: bold; padding: 0 10px;">'.$this->model['LOGGINERROR'].'</p>';
} 
  if ($this->model['TEXTCGANGED']!='')
{
    echo '<p style="color:#F84E5C;font-size: 14px; font-weight: bold; padding: 0 10px;">'.$this->model['TEXTCGANGED'].'</p>';
} 
echo '<form action="" method="post" >
<div class="form-row">
<div class="form-group col-md-1">
<p>Sort:</p>
</div>
  <div class="form-group col-md-4">
    <select name="sortTask" class="form-control form-control-lg">
    <option name="default"'; if (!isset($_SESSION['Set_sort'])){echo 'selected';} echo'>By default</option>
        <option name="user_name_ASC"'; if (($_SESSION['fild_sort']=='user_name')&&($_SESSION['order_sort']=='ASC')){echo 'selected';} echo'>By name ascending</option>
        <option name="user_name_DESC"'; if (($_SESSION['fild_sort']=='user_name')&&($_SESSION['order_sort']=='DESC')){echo 'selected';} echo'>By name descending</option>
        <option name="user_email_ASC"'; if (($_SESSION['fild_sort']=='user_email')&&($_SESSION['order_sort']=='ASC')){echo 'selected';} echo'>By email ascending</option>
        <option name="user_email_DESC"'; if (($_SESSION['fild_sort']=='user_email')&&($_SESSION['order_sort']=='DESC')){echo 'selected';} echo'>By email descending</option>
        <option name="user_status_ASC"'; if (($_SESSION['fild_sort']=='status')&&($_SESSION['order_sort']=='ASC')){echo 'selected';} echo'>By status ascending</option>
        <option name="user_status_DESC"'; if (($_SESSION['fild_sort']=='status')&&($_SESSION['order_sort']=='DESC')){echo 'selected';} echo'>By status descending</option>
     </select>
  </div>
  <div class="form-group col-md-4">
    <input type="submit" name="doSort" class="btn btn-primary"'.$abble.' value="Sort">
  </div>
  
  </div>
</form>';
echo '<div class="row">
        <div class="col-sm-8">
          <div class="container-fluid" style="">
            ';
foreach($arr as $news){
  if ($news['task_status']==1){
    $check='checked';
  }
  else {
    $check='';
  }  
echo '<div style="background-color: #fcf8e3; padding: 20px; margin-bottom: 20px; border-radius: 10px;">
        <form action="" method="post" >
          <div class="form-group" hidden>
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="userId" value='.$news['task_id'].'>
            </div>
          </div>

          <div class="form-group">
            <label for = "userName">Name</label>
            <input type="text" class="form-control" name="userName" id="userName'.$news['user_name'].'" value="'.$news['user_name'].'" disabled>
          </div>
    
          <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="text" class="form-control" name="userEmail" id="userEmail'.$news['user_id'].'" value="'.$news['user_email'].'" disabled>
          </div>

          <div class="form-group">
              <label for="Textarea">Task</label>
              <input type="text" class="form-control" name="userText" id="Textarea" rows="3" value="'.$news['task_text'].'"'.$abble.'>
          </div>

          <div class="form-check">
            <label class="form-check-label">сделлано</label>
            <input type="checkbox"'.$check.' name="userDone" class="form-check-input"'.$abble.'>
          </div>

          <input type="submit" name="doSaveChanges" class="btn btn-primary"'.$abble.'>
        </form>
      </div>';
}
echo '</div>
  </div>
    <div class="col-sm-4">
      <div style="background-color: #fcf8e3; padding: 20px; margin: 20px; border-radius: 10px;">
        <form action="" method="post" >
        <h2>Offer News</h2>
        <div class="form-group">
        <label for = "userName">Name</label>
        <input type="text" class="form-control" name="userofferName" id="userofferName" required value="'.$this->model['NAMEVALUE'].'"';
if ($this->model['NAMEERROR']!='')
 {
   echo '<p style="color:#F84E5C;font-size: 14px; font-weight: bold; padding: 0 10px;">'.$this->model['NAMEERROR'].'</p>';
 } 
echo'</div>';

echo '<div class="form-group">
      <label for="userEmail">Email</label>
      <input type="text" class="form-control" name="userofferEmail" id="userofferEmail" required  value="'.$this->model['EMAILVALUE'].'">';
 if ($this->model['EMAILERROR']!='')
	{
		echo '<p style="color:#F84E5C;font-size: 14px; font-weight: bold; padding: 0 10px;">'.$this->model['EMAILERROR'].'</p>';
	} 
echo'</div>';

echo'<div class="form-group">
      <label for="Textarea">Enter task</label>
      <textarea type="text" class="form-control" name="userofferText" id="Textarea" rows="3" required value="">'.$this->model['TEXTVALUE'].'</textarea >';
  if ($this->model['TEXTERROR']!='')
   {
     echo '<p style="color:#F84E5C;font-size: 14px; font-weight: bold; padding: 0 10px;">'.$this->model['TEXTERROR'].'</p>';
   } 
echo'</div>';

echo'<input type="submit" name="doAddTask" class="btn btn-primary">
</form>
</div>
</div>
</div>
</div>';

?>

<!-- Bootstrap 4 -->  
<?
echo '<div class="container-fluid">
<nav">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href=index.php?id=1>
        Первая
      </a>
    </li>
    <li class="page-item ">
      <a class="page-link" href=index.php?id=back aria-label="Предыдущая">
        <span aria-hidden="true">«</span>
        <span class="sr-only">Предыдущая</span>
      </a>
    </li>';
     $num=$this->getPageNum();
      for($i=1; $i<=$num; $i++){

        echo '';
        //$active=' active';
        $active='';
    echo '<li class="page-item '.$active.'">
            <a class="page-link" href=index.php?id='.$i.'>'.$i.'</a>
          </li>';
         }
        
    echo'<li class="page-item">
      <a class="page-link" href=index.php?id=next aria-label="Следующая">
        <span aria-hidden="true">»</span>
        <span class="sr-only">Следующая</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">
        Последняя
      </a>
    </li>
  </ul>
</nav>
</div>' ?>
