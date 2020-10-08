<?php
session_start();

// flash message helper
// Example - flash('register_sucesss', 'You have been registered sucessfully' 'alert alert-sucess')
// Display In View - echo flash('register_sucesss');
function flash($name = '', $message = '', $class = 'alert alert-success'){
    // check if the name is not empty
   if(!empty($name)){
       // check if the messqage is not empty and the session is empty
       if(!empty($message) && empty($_SESSION['name'])){
           // check if the session already exists, if yes unset the session
           if(!empty($_SESSION[$name])){
               unset($_SESSION[$name]);
           }

           if(!empty($_SESSION[$name. '_class'])){
               unset($_SESSION[$name. '_class']);
           }

           // Then we want to set the session again
           $_SESSION[$name] = $message;
           $_SESSION[$name. '_class'] = $class;

           // check if the message is empty and the name session is not empty
       } elseif(empty($message) && !empty($_SESSION[$name])){
          $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
          echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
          unset($_SESSION[$name]);
          unset($_SESSION[$name. '_class']);
       }
   }
}

// A funtion to check if a user is logged in

 function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return true;
    } else {
        return false;
    }
}
