<?php

// get data from configs files and save them into tabs
$types = file("../Structure/type.txt");
$matieres = file("../Structure/matiere.txt");
$colors = file("../Structure/colors.txt");
$result = fopen("../datas.data", "w+");

// get size of each data tab
$nbTypes = count($types);
$nbMatieres = count($matieres);
$nbColor = count($colors);

// get configs for 1st line of data fann ($totalElementsToTrain, nbInputsByElement, nbOutputsByElement)
$totalElementsToTrain = $nbTypes*$nbMatieres*$nbColor;
$nbInputsByElement = 3;
$nbOutputsByElement = 3;

// Write 1st line with configs
fwrite($result,$totalElementsToTrain." ".$nbInputsByElement." ".$nbOutputsByElement."\n");

foreach($types as $type){
  $type = explode(":",$type);
  foreach ($matieres as $matiere) {
      $matiere = explode(":",$matiere);
    foreach ($colors as $color) {
        $color = explode(":",$color);
        $textResult = rtrim($type[1])." ".rtrim($matiere[1])." ".rtrim($color[1]);

        // write line with  new  type||matiere||color
        fwrite($result,$textResult."\n");

        // write random new line for result
        $randType = explode(":",$types[rand(0,$nbTypes-1)]);
        $randMatiere = explode(":",$matieres[rand(0,$nbMatieres-1)]);
        $randColor = explode(":",$colors[rand(0,$nbColor-1)]);
        $textRandomResult =  rtrim($randType[1])." ".rtrim($randMatiere[1])." ".rtrim($randColor[1]);
        fwrite($result,$textRandomResult."\n");

    }
  }
}
fclose($result);
echo "Nombre d'élements : ".$totalElementsToTrain;




// if ($type && $colors && $matiere) {
//     while (($lineType = fgets($type)) !== false) {
//         //echo $lineType;
//       while (($lineColor = fgets($colors)) !== false) {
//         //echo $lineColor;
//       }
//       echo "<br>";
//     }
//     // if (!feof($type) || !feof($colors) || !feof($matiere)) {
//     //     echo "Erreur: fgets() a échoué\n";
//     // }
//     fclose($type);
//     fclose($colors);
//     fclose($matiere);
// }else{
//   echo "Nop";
// }



 ?>
