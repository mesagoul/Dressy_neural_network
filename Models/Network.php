<?php

class Network{
  private $num_input;
  private $num_output;
  private $num_layers;
  private $num_neurons_hidden;
  private $desired_error;
  private $max_epochs;
  private $epochs_between_reports;
  private $ann;


  function __construct(){
    $prepare = new Prepare();

    $this->num_input = $prepare->getCountInputs();
    $this->num_output = $prepare->getCountOutputs();
    $this->num_layers = 3;
    $this->num_neurons_hidden = $prepare->getCountInputs()*2;
    $this->desired_error = 0.00001;
    $this->max_epochs = 50000;
    $this->epochs_between_reports = 1000;
  }


  function train(){
    $this->ann = fann_create_standard($this->num_layers, $this->num_input, $this->num_neurons_hidden, $this->num_output );

    if ($this->ann) {
        fann_set_activation_function_hidden($this->ann, FANN_SIGMOID_SYMMETRIC);
        fann_set_activation_function_output($this->ann, FANN_SIGMOID_SYMMETRIC);
        $filename = dirname(__FILE__) . "/../datas.data";

        if (fann_train_on_file($this->ann, $filename, $this->max_epochs, $this->epochs_between_reports, $this->desired_error)){
          fann_save($this->ann, dirname(__FILE__) ."/../response.data");
        }
        fann_destroy($this->ann);
    }
  }

  function use($type = "", $material = "", $color = ""){
    $prepare = new Prepare();

    $valueType =  explode(" ", $prepare->getVector("type",$type));
    $valueMaterial = explode(" ", $prepare->getVector("material",$material));
    $valueColor = explode(" ", $prepare->getVector("color",$color));
    //$valueColor = array($color);


    $train_file = (dirname(__FILE__) . "/../response.data");
    if (!is_file($train_file))
            die("The file response.data has not been created! Please run train.php to generate it" . PHP_EOL);
    $trainedAnn = fann_create_from_file($train_file);



    if ($trainedAnn) {
            $input = array_merge($valueType,$valueMaterial,$valueColor);
            $calc_out = fann_run($trainedAnn, $input);
            fann_destroy($trainedAnn);
            return $prepare->vectorToFannIds($calc_out);
    } else {
            die("Invalid file format" . PHP_EOL);
    }
    return -1;
  }
}
