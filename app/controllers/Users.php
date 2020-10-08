<?php
  class Users extends Controller {
      public function __construct(){
        $this->userModel = $this->Model('User');
      }

      public function register(){
          // check for a post request or if it is just beign viewed
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
              // PROCESS THE FORM
              // Sanitize post data
              $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
              // init data
              $data = [
                'name'                 => trim($_POST['name']),
                'email'                => trim($_POST['email']),
                'password'             => trim($_POST['password']),
                'confirm_password'     => trim($_POST['confirm_password']),
                'name_err'             => '',
                'email_err'            => '',
                'password_err'         => '',
                'confirm_password_err' => ''
                
            ];

            // validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please Enter your Email';
            } else {
                // check if the email exists already
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email Already Exists. Please Enter Another Email';
                }
            }

            // validate name
            if(empty($data['name'])){
                $data['name_err'] = 'Please Enter your Name';
            }

            // validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please Enter Your Password';
            } elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            //validate confirm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm Your Password';
            } else {
                if($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            //make sure errors are empty
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // validated
                
                // hash the password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // register user
                if($this->userModel->register($data)){
                flash('register_success', 'You are registered, Please Log In');
                  redirect('users/login');
                } else {
                    die('something went wrong');
                }
            } else {
                // load the view with errors
                $this->view('users/register', $data);
            }


          } else {
              // LOAD THE FORM
              // init data
             $data = [
                 'name'                 => '',
                 'email'                => '',
                 'password'             => '',
                 'confirm_password'     => '',
                 'name_err'             => '',
                 'email_err'            => '',
                 'password_err'         => '',
                 'confirm_password_err' => ''
                 
             ];

             $this->view('users/register', $data);
          }
      }

      public function login(){
        // check for a post request or if it is just beign viewed
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // PROCESS THE FORM
              // Sanitize post data
              $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
              // init data
              $data = [
                'email'                => trim($_POST['email']),
                'password'             => trim($_POST['password']),
                'email_err'            => '',
                'password_err'         => ''
                
            ];

            // VALIDATE EMAIL
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter your email';
            }

            // validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please Enter Your Password';
            }

            // check if user email exists
            if($this->userModel->findUserByEmail($data['email'])){
                // user found
            } else {
                // user not found
                $data['email_err'] = 'No User Found';
            }

              //make sure errors are empty
              if(empty($data['email_err']) && empty($data['password_err'])){
                // validated
               // check and set logged in user
               
               $loggedInUser = $this->userModel->login($data['email'], $data['password']);

               if($loggedInUser){
                   // create Sessions
                  
                  $this->createUserSession($loggedInUser);
               } else {
                   // throw our errors and re render the form
                   $data['password_err'] = 'Password Incorrect';
                   $this->view('users/login', $data);
               }
            } else {
                // load the view with errors
                $this->view('users/login', $data);
            }

        } else {
            // LOAD THE FORM
            // init data
           $data = [
               'email'                => '',
               'password'             => '',
               'email_err'            => '',
               'password_err'         => '',
               
           ];

           $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('posts');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

  
  }