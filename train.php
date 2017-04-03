<?php
$num_input = 3;
$num_output = 3;
$num_layers = 3;
$num_neurons_hidden = 70;
$desired_error = 0.0001;
$max_epochs = 500000;
$epochs_between_reports = 1000;


$ann = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_output);

if ($ann) {
    fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
    fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);
    $filename = dirname(__FILE__) . "/datas.data";

    if (fann_train_on_file($ann, $filename, $max_epochs, $epochs_between_reports, $desired_error)){
      fann_save($ann, dirname(__FILE__) ."/response.data");
      //showUse();
    }


    fann_destroy($ann);
}


function showUse(){
  echo "<p>Now go to <a href='./use.php' target='_BLANK'> the test page </a></p>";
}
?>
