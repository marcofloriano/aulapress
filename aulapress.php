<?php
/*
Plugin Name: Aulapress
Plugin URI: https://aulapress.com.br
Description: Transforme o WordPress em uma plataforma de ensino online.
Version: 1.0
Author: Marco Floriano
Author URI: https://marcofloriano.com.br
*/
// HTML code of the registration form
function registration_form() {
    echo '
    <style>
    div {
        margin-bottom:20px;
    }
    input[type=text], input[type=password], textarea {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        
    }
    input[type=submit] {
        width: auto;
        display: block;
        margin: 0 auto;
        padding: 6px 10px;
    }
    </style>
    ';
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" ';
    if(isset($_POST['submit'])) { 
        echo 'style="display: none"';
    }
    echo '>
    <div>
    <label for="username">Usuário <strong>*</strong></label>
    <input type="text" name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
    </div>
    <div>
    <label for="password">Senha <strong>*</strong></label>
    <input type="password" name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
    </div>
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . (isset($_POST['email']) ? $email : null) . '">
    </div>
    <div>
    <label for="website">Site</label>
    <input type="text" name="website" value="' . (isset($_POST['website']) ? $website : null) . '">
    </div>
    <div>
    <label for="firstname">Nome</label>
    <input type="text" name="fname" value="' . (isset($_POST['fname']) ? $first_name : null) . '">
    </div>
    <div>
    <label for="website">Sobrenome</label>
    <input type="text" name="lname" value="' . (isset( $_POST['lname']) ? $last_name : null) . '">
    </div>
    <div>
    <label for="nickname">Apelido</label>
    <input type="text" name="nickname" value="' . (isset( $_POST['nickname']) ? $nickname : null) . '">
    </div>
    <div>
    <label for="bio">Sobre / Bio</label>
    <textarea name="bio">' . (isset( $_POST['bio']) ? $bio : null) . '</textarea>
    </div>
    <input type="submit" name="submit" value="Registrar"/>
    </form>
    ';
}

// HTML code of the login form
function login_form() {
    echo '
    <style>
    div {
        margin-bottom:20px;
    }
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        
    }
    input[type=submit] {
        width: auto;
        display: block;
        margin: 0 auto;
        padding: 6px 10px;
    }
    </style>
    ';
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" >
    <div>
    <label for="username">Usuário <strong>*</strong></label>
    <input type="text" name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
    </div>
    <div>
    <label for="password">Senha <strong>*</strong></label>
    <input type="password" name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
    </div>
    <input type="submit" name="submit" value="Acessar"/>
    </form>
    ';
}

// Validate and sanitize the user input at registration form
function registration_validation($username,$password,$email,$website,$first_name,$last_name,$nickname,$bio)  {
    // Instantiate the WP_Error class and make the instance variable global so it can be access outside the scope of the function
    global $reg_errors;
    $reg_errors = new WP_Error;
    // Check if any of the field is empty. If empty, we append the error message to the global WP_Error class
    if(empty($username) || empty($password) || empty($email)) {
        $reg_errors->add('field', 'Exitem campos obrigatórios não preenchidos.');    
    }
    // Check to make sure the number of username characters is not less than 4
    if(4 > strlen($username)) {
        $reg_errors->add( 'username_length', 'Usuário muito curto. Use ao menos 4 caracteres.' );    
    }
    // Check if the username is already registered
    if(username_exists($username)) {
        $reg_errors->add('user_name', 'Desculpe, este usuário já existe!');
    }
    // Make sure the username is valid
    if(! validate_username($username)) {
        $reg_errors->add( 'username_invalid', 'Desculpe, o usuáro informado não é válido.' );    
    }
    // Ensure the password entered by users is not less than 5 characters
    if(5 > strlen($password)) {
        $reg_errors->add( 'password', 'A senha precisa ter mais de 5 caracteres' );
    }
    // Check if the email is a valid email
    if(! is_email($email)) {
        $reg_errors->add('email_invalid','Email inválido.');    
    }
    // Check if the email is already registered
    if(email_exists($email)) {
        $reg_errors->add( 'email', 'Email já existe.' );    
    }
    // If the website field is filled, check to see if it is valid
    if(! empty($website)) {
        if(! filter_var($website, FILTER_VALIDATE_URL)) {    
            $reg_errors->add( 'website', 'URL do site inválida' );    
        }    
    }
    // Loop through the errors in our WP_Error instance and display the individual error
    if(is_wp_error($reg_errors)) {
        foreach($reg_errors->get_error_messages() as $error) {   
            echo '<div>';    
            echo '<strong>Erro</strong>: ';    
            echo $error . '<br/>';    
            echo '</div>';
        }
    }
}

// Validate and sanitize the user input at login form
function login_validation($username, $password) {
    global $reg_errors;
    $reg_errors = new WP_Error;
    // Check if any of the field is empty. If empty, we append the error message to the global WP_Error class
    if(empty($username) || empty($password)) {
        $reg_errors->add('field', 'Exitem campos obrigatórios não preenchidos.');    
    }
    // Loop through the errors in our WP_Error instance and display the individual error
    if(is_wp_error($reg_errors)) {
        foreach($reg_errors->get_error_messages() as $error) {   
            echo '<div>';    
            echo '<strong>Erro</strong>: ';    
            echo $error . '<br/>';    
            echo '</div>';
        }
    }
}

// Handles the user registration
function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if(1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
        'user_login'    => 	$username,
        'user_email' 	=> 	$email,
        'user_pass' 	=> 	$password,
        'user_url' 		=> 	$website,
        'first_name' 	=> 	$first_name,
        'last_name' 	=> 	$last_name,
        'nickname' 		=> 	$nickname,
        'description' 	=> 	$bio,
		);
        $user = wp_insert_user($userdata);
        echo '<div>';
        echo 'Registro efetuado com sucesso! Acesse a <a href="' . get_site_url() . '/login">página de login</a>.';
        echo '<div>';
	}
}

// Handles the user login
// function complete_login() {
//     global $username, $password;
//     if ( ! is_user_logged_in() ) {
//         $userdata = array(
//             'redirect' => admin_url(), // redirect to admin dashboard.
//             'user_login'    => 	$username,
//             'user_pass' 	=> 	$password,
//             'remember' => true
//         );
//     wp_login_form( $userdata );
//     }
// }

function login_wordpress($username, $password) {
    global $username, $password;
    $userdata = array();
    $userdata['user_login'] = $username;
    $userdata['user_password'] = $password;
    $userdata['remember'] = true;
    $user = wp_signon( $userdata, false );
    if ( is_wp_error($user) ) {
       echo $user->get_error_message();
       die();
    } else {
        wp_set_auth_cookie( $user->ID, 1, is_ssl() );
    }
}

// Function that puts all the registration functions we've created above into use
function custom_registration_function() {
    if(isset($_POST['submit'])) {
        registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['website'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['nickname'],
            $_POST['bio']
    	);
        // sanitize user registration form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username	= 	sanitize_user($_POST['username']);
        $password 	= 	esc_attr($_POST['password']);
        $email 		= 	sanitize_email($_POST['email']);
        $website 	= 	esc_url($_POST['website']);
        $first_name = 	sanitize_text_field($_POST['fname']);
        $last_name 	= 	sanitize_text_field($_POST['lname']);
        $nickname 	= 	sanitize_text_field($_POST['nickname']);
        $bio 		= 	esc_textarea($_POST['bio']);
		// call @function complete_registration to create the user
		// only when no WP_error is found
        complete_registration(
            $username,
            $password,
            $email,
            $website,
            $first_name,
            $last_name,
            $nickname,
            $bio
		);
    }
    registration_form();
}

// Function that puts all the login functions we've created above into use
function custom_login_function() {
    if(isset($_POST['submit'])) {
        login_validation(
            $_POST['username'],
            $_POST['password']
    	);
        // sanitize user login form input
        global $username, $password;
        $username	= 	sanitize_user($_POST['username']);
        $password 	= 	esc_attr($_POST['password']);
		// call @function complete_login to redirect the user
		// only when no WP_error is found
        login_wordpress($username,$password);
        wp_redirect(home_url());
    }
    elseif(is_user_logged_in() == true) {
        echo '<div>';
        echo 'Logado com sucesso! Para sair <a href="' . wp_logout_url(get_permalink()) . '">clique aqui.</a>';
        echo '<div>';
    }
    else {
        login_form();
    }
}

// Register a new shortcode: [aulapress_custom_registration]
add_shortcode( 'aulapress_custom_registration', 'custom_registration_shortcode' );
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

// Register a new shortcode: [aulapress_custom_login]
add_shortcode( 'aulapress_custom_login', 'custom_login_shortcode' );
// The callback function that will replace [book]
function custom_login_shortcode() {
    ob_start();
    custom_login_function();
    return ob_get_clean();
}

//This action hook executes just before WordPress determines which template page to load. It is a good hook to use if you need to do a redirect with full knowledge of the content that has been queried.
// Alguns temas apresentaram warnings sobre headers enviados após o carregamento da página de login
// Warning: cannot modify header information
add_action('template_redirect', function () {
    ob_start();
});