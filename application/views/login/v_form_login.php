<h1>Login Page</h1>

<?php
// set attribut
$att_username = array(
    'name'  =>  'username',
    'type'  =>  'text',
    'value' =>  $this->input->post('username'),
    'id'    =>  '',
    'class' =>  '',
    'placeholder'   =>  'Username' 
);

$att_password = array(
    'name'  =>  'password',
    'type'  =>  'password',
    'value' =>  $this->input->post('password'),
    'id'    =>  '',
    'class' =>  '',
    'placeholder'   =>  'Password' 
);

echo form_open_multipart('verify');

    echo form_input($att_username);

    echo form_password($att_password);

    echo form_submit('login', 'Login');

echo form_close();

?>
