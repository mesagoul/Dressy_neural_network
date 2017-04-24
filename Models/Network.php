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

  function network($num_input,$num_output,$num_layers,$num_neurons_hidden,$desired_error,$max_epochs,$epochs_between_reports){
    $this->num_input = $num_input;
    $this->num_output = $num_output;
    $this->num_layers = $num_layers;
    $this->num_neurons_hidden = $num_neurons_hidden;
    $this->desired_error = $desired_error;
    $this->max_epochs = $max_epochs;
    $this->epochs_between_reports = $epochs_between_reports;
    $this->ann = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_output );
  }


  function train(){

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

  function use(){
    $train_file = (dirname(__FILE__) . "/../response.data");
    if (!is_file($train_file))
            die("The file response.data has not been created! Please run train.php to generate it" . PHP_EOL);
    $ann = fann_create_from_file($train_file);
    $valueType = 0.02;
    $valueMaterial = 0.02 ;
    $valueColor = 0.02;

    if ($this->ann) {
            $input = array($valueType,$valueMaterial,$valueColor);
            $calc_out = fann_run($ann, $input);
            echo $calc_out[0]."<br>";
            echo $calc_out[1]."<br>";
            echo $calc_out[2];
            fann_destroy($this->ann);
    } else {
            die("Invalid file format" . PHP_EOL);
    }

  }
}
