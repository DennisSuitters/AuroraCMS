<?php
if($config['idleTime']!=0){
  $logtime=time()-$_SESSION['logtime'];
  if($logtime>($config['idleTime']*60)){
    header("Location: https://www.google.com/");
  }
}
