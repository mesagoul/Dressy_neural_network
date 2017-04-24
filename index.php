
<?php


 include "./Models/Network.php";
 include "./Models/Prepare.php";


if(isset($_GET["train"]) && !empty($_GET["train"])){
  train();
}
if(isset($_GET["prepare"]) && !empty($_GET["prepare"])){
  prepare();
}
if(isset($_GET["use"]) && !empty($_GET["use"])){
  useFann();
}


function train(){
   $fann = new Network(3,3,3,3,0.00001,500000,1000);
   $fann->train();
}

function useFann(){

   $fann = new Network(3,3,3,3,0.00001,500000,1000);
   $fann->use();

}

function prepare(){
  $prepare = new Prepare();
  $prepare->render();

}
?>
