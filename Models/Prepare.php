<?php

class Prepare{
  private $types;
  private $matieres;
  private $colors;
  private $result;

  // get size of each data tab
  private $nbTypes;
  private $nbMatieres;
  private $nbColor;
  private $totalElementsToTrain;
  private $nbInputsByElement;
  private $nbOutputsByElement;


   function __construct(){
     // get data from configs files and save them into tabs
     $this->types = file(dirname(__FILE__)."/../Structure/type.txt");
     $this->matieres = file(dirname(__FILE__)."/../Structure/matiere.txt");
     $this->colors = file(dirname(__FILE__)."/../Structure/colors.txt");

     // get size of each data tab
     $this->nbTypes = count($this->types);
     $this->nbMatieres = count($this->matieres);
     $this->nbColor = count($this->colors);

     // get configs for 1st line of data fann ($this->totalElementsToTrain, nbInputsByElement, nbOutputsByElement)
     $this->totalElementsToTrain = $this->nbTypes * $this->nbMatieres * $this->nbColor;
     $this->nbInputsByElement =  $this->nbTypes + $this->nbMatieres + $this->nbColor;
     $this->nbOutputsByElement =  $this->nbInputsByElement;
   }

 public function getCountInputs(){
   return $this->nbInputsByElement;
 }

 public function getCountOutputs(){
   return $this->nbOutputsByElement;
 }

 public function getVector($property, $value){
   switch($property){
     case "type":
     return $this->setVector($this->nbTypes,$this->types, $value);
      break;
    case "material":
     return $this->setVector($this->nbMatieres,$this->matieres, $value);
      break;
    case "color":
     return $this->setVector($this->nbColor,$this->colors, $value);
      break;
   }
 }

 public function vectorToFannIds($value){
   // Get type part in the $value array
   $type = array_slice($value, 0,$this->nbTypes);
   // get max of type part
   $max = max($type);
   // get index of max position in type part and return idfann (ex: 2*.0.2 = 0.04)
   $type = (array_search($max, $type)+1) * 0.02;

   // idem type
   $material = array_slice($value, $this->nbTypes,$this->nbMatieres );
   $max = max($material);
   $material = (array_search($max, $material)+1) * 0.02;


   // idem color
   $color = array_slice($value, $this->nbTypes + $this->nbMatieres , $this->nbColor);
   $max = max($color);
   $color = (array_search($max, $color)+1) * 0.02;


  // $color = array_slice($value, $this->nbTypes + $this->nbMatieres, $this->nbInputsByElement);
   // round color to 0.02 type
   //$color = (ceil($color[0]*100)) % 2 == 0 ? ceil($color[0]*100)/100  : (ceil($color[0]*100)-1)/100 ;

  return array("$type","$material", "$color");
 }

 public function setVector($counter, $list, $idfann){
   $vector = "";
   for($i = 0 ; $i < $counter ; $i++){
         $propertyTemp = explode(":",$list[$i]);
         $vector .= rtrim($idfann) == rtrim($propertyTemp[1]) ? "1" : "0";
         $vector .= " ";
   }
   return  rtrim($vector);
 }

  public function render(){

    $this->result = fopen("./datas.data", "w+");
    // Write 1st line with configs
    fwrite($this->result,$this->totalElementsToTrain." ".$this->nbInputsByElement." ".$this->nbOutputsByElement."\n");

    foreach($this->types as $type){

      $type = explode(":",$type);

      $resultType = $this->setVector($this->nbTypes,$this->types, $type[1]);


      foreach ($this->matieres as $matiere) {
          $matiere = explode(":",$matiere);

          $resultMatiere = $this->setVector($this->nbMatieres,$this->matieres, $matiere[1]);


        foreach ($this->colors as $color) {
            $color = explode(":",$color);
            $resultColor = $this->setVector($this->nbColor,$this->colors, $color[1]);

            $textResult = rtrim($resultType)." ".rtrim($resultMatiere)." ".rtrim($resultColor);

            // write line with  new  type||matiere||color
            fwrite($this->result,$textResult."\n");

            // write random new line for result
            // Get Random LOGIC and USABLE type for test
            do {
              $randValue = (rand(2,2*$this->nbTypes))/100;
            } while (($randValue*100) % 2 != 0);
            // vectorise randomType
            $randomType = $this->setVector($this->nbTypes,$this->types, $randValue);

            // Get Random LOGIC and USABLE matiere for test
            do {
              $randValue = (rand(2,2*$this->nbMatieres))/100;
            } while (($randValue*100) % 2 != 0);
            // vectorise randomMatiere
            $randomMatiere = $this->setVector($this->nbMatieres,$this->matieres, $randValue);

            do {
              $randValue = (rand(2,2*$this->nbColor))/100;
            } while (($randValue*100) % 2 != 0);
            // vectorise randomMatiere
            $randomColor = $this->setVector($this->nbColor,$this->colors, $randValue);


            $textRandomResult =  rtrim($randomType)." ".rtrim($randomMatiere)." ".rtrim($randomColor);
            fwrite($this->result,$textRandomResult."\n");
        }
      }
    }
    fclose($this->result);
  }
}


 ?>
