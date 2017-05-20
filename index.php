
<?php

error_reporting(E_ALL & ~E_NOTICE);

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
   $fann = new Network();
   $fann->train();
}

function useFann(){

  $type = $_GET["type"];
  $material = $_GET["material"];
  $color = $_GET["color"];

   $fann = new Network();
   var_dump($fann->use($type,$material,$color));


}

function prepare(){
  $prepare = new Prepare();
  $prepare->render();

}
?>
