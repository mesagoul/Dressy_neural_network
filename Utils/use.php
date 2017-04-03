<?php

$train_file = (dirname(__FILE__) . "/response.data");
if (!is_file($train_file))
        die("The file response.data has not been created! Please run train.php to generate it" . PHP_EOL);
$ann = fann_create_from_file($train_file);
$valueType = 0.02;
$valueColor = 0.06;
echo "Votre ".getHabit($valueType)." ".getColor($valueColor)." va bien avec :<br>";

if ($ann) {
        $input = array($valueType,$valueColor);
        $calc_out = fann_run($ann, $input);
        for($i = 0 ; $i < count($calc_out) ; $i++) {
          $value = $calc_out[$i];
          if ($i % 2 == 0){
            echo getHabit($value);
          }else{
            echo getColor($value);
              echo "<br>";
          }
        }



        fann_destroy($ann);
} else {
        die("Invalid file format" . PHP_EOL);
}



function getHabit($value){
  if($value >= 0.01 && $value < 0.03){
    return "chemise";
  }else if($value >= 0.03 && $value < 0.05){
    return "tee shirt";
  }else if($value >= 0.05 && $value < 0.07){
    return "pull";
  }else if($value >= 0.07 && $value < 0.09){
    return "débardeur";
  }else if($value >= 0.09 && $value < 0.11){
    return "blouse";
  }else if($value >= 0.11 && $value < 0.13){
    return "manteau";
  }else if($value >= 0.13 && $value < 0.15){
    return "top Court";
  }else if($value >= 0.15 && $value < 0.17){
    return "K-Way";
  }else if($value >= 0.17 && $value < 0.19){
    return "robe";
  }else if($value >= 0.19 && $value < 0.21){
    return "jupe";
  }else if($value >= 0.21 && $value < 0.23){
    return "pantalon";
  }else if($value >= 0.23 && $value < 0.25){
    return "short";
  }else if($value >= 0.25 && $value < 0.27){
    return "slim";
  }else {
    return $value;
  }
}

function getColor($value){
  if($value >= 0.01 && $value < 0.03){
    return " bleu";
  }else if($value >= 0.03 && $value < 0.05){
    return " rouge";
  }else if($value >= 0.05 && $value < 0.07){
    return " vert";
  }else if($value >= 0.07 && $value < 0.09){
    return " orange";
  }else if($value >= 0.09 && $value < 0.11){
    return " marron";
  }else if($value >= 0.11 && $value < 0.13){
    return " jaune";
  }else if($value >= 0.13 && $value < 0.15){
    return " rose";
  }else if($value >= 0.15 && $value < 0.17){
    return " violet";
  }else if($value >= 0.17 && $value < 0.19){
    return " noire";
  }else if($value >= 0.19 && $value < 0.21){
    return " gris";
  }else if($value >= 0.21 && $value < 0.23){
    return " blanc";
  }else{
    return $value;
  }
}
 ?>
