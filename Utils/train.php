<?php

 class Train{

  private $num_input;
  private $num_output;
  private $num_layers;
  private $num_neurons_hidden;
  private $desired_error;
  private $max_epochs;
  private $epochs_between_reports;

  function train($num_input,$num_output,$num_layers,$num_neurons_hidden,$desired_error,$max_epochs,$epochs_between_reports){
    $this->num_input = $num_input;
    $this->num_output = $num_output;
    $this->num_layers = $num_layers;
    $this->num_neurons_hidden = $num_neurons_hidden;
    $this->desired_error = $desired_error;
    $this->max_epochs = $max_epochs;
    $this->epochs_between_reports = $epochs_between_reports;
  }

  function render(){
    $ann = fann_create_standard($this->num_layers, $this->num_input, $this->num_neurons_hidden, $this->num_output );
    if ($ann) {
        fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
        fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);
        $filename = dirname(__FILE__) . "/../data.data";

        if (fann_train_on_file($ann, $filename, $this->max_epochs, $this->epochs_between_reports, $this->desired_error)){
          fann_save($ann, dirname(__FILE__) ."/../response.data");
        }
        fann_destroy($ann);
    }
  }
}
// $num_input = 2;
// $num_output = 6;
// $num_layers = 3;
// $num_neurons_hidden = 25;
// $desired_error = 0.0001;
// $max_epochs = 500000;
// $epochs_between_reports = 1000;


// $ann = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_output);

// if ($ann) {
//     fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
//     fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);
//     $filename = dirname(__FILE__) . "/data.data";
//
//     if (fann_train_on_file($ann, $filename, $max_epochs, $epochs_between_reports, $desired_error)){
//       fann_save($ann, dirname(__FILE__) ."/response.data");
//
//     }
//
//
//     fann_destroy($ann);
// }


?>
