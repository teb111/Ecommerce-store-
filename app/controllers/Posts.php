<?php

class Posts extends Controller {

    public function __construct()
    {
        if(!isLoggedIn()){
            redirect('users/login');
        }

        $this->postModel = $this->model('post');
        $this->userModel = $this->model('User');
    }

    public function index(){

        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];

        $this->view('posts/index', $data);
    }


// Add A Post
    public function add(){

        // check if the user made a POST REQUEST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // sanitize POST super global array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
'title' =>     trim($_POST['title']),
'body'  =>     trim($_POST['body']),
'user_id' =>   $_SESSION['user_id'],
'img_name' => $_FILES['img']['name'],
'img_tmp'  => $_FILES['img']['tmp_name'],
'img_path' =>  "localhost/shareposts/public\img",
'title_err' => '',
'body_err' =>  '',
'img_err'  => ''
];


$extensions = ['jpg','jpeg','png'];
$img_ext = explode('.', $data['img_name']);
$image_extension = end($img_ext);



             //validate data
             if(empty($data['title'])){
                $data['title_err'] = 'Please Enter a Title';
            }

            if(empty($data['body'])){
                $data['body_err'] = 'Please Enter a Body';
            }

            if(empty($data['img_name'])){
                $data['img_err'] = "Please Choose An Image";
            }

            if(!in_array($image_extension, $extensions)) {
                $data['img_err'] = 'Please Choose a Valid Image';
            }



            // make sure there are no errors
            if(empty($data['title_err']) && empty($data['body_err']) && empty($data['img_err'])) {
                // VALIDATED
                // 
               
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Post Added');
                    redirect('posts');

                }else {

                }

            } else {
                
                $this->view('posts/add', $data);
            }
        } else {
            
            $data = [
                'title' =>  '',
                'body'  => '',
                'img' => ''
            ];
    
            $this->view('posts/add', $data);
        }
    }


// Edit Post
    public function edit($id){

        // check if the user made a POST REQUEST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // sanitize POST super global array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id'   =>      $id,
                'title' =>     trim($_POST['title']),
                'body'  =>     trim($_POST['body']),
                'user_id' =>   $_SESSION['user_id'],
                'title_err' => '',
                'body_err' =>  ''
            ];

             //validate data
             if(empty($data['title'])){
                $data['title_err'] = 'Please Enter a Title';
            }

            if(empty($data['body'])){
                $data['body_err'] = 'Please Enter a Body';
            }

            // make sure there are no errors
            if(empty($data['title_err']) && empty($data['body_err'])) {
                // VALIDATED
                if($this->postModel->updatePost($data)){
                    flash('post_message', 'Post Updated');
                    redirect('posts');

                }else {
                    die('something went wrong');
                }

            } else {
                // load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
              // Get Existing post from model
            $post = $this->postModel->getPostById($id);

            // check for post owner
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            
            $data = [
                'id'   => $id,
                'title' =>  $post->title,
                'body'  => $post->body
            ];
    
            $this->view('posts/edit', $data);
        }
    }

    public function show($id){

        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    public function delete($id) {
        // check if it was a post request
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
               // Get Existing post from model
        $post = $this->postModel->getPostById($id);

               // check for post owner
        if($post->user_id != $_SESSION['user_id']){
                   redirect('posts');
               }
            if($this->postModel->deletePost($id)){
                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die('Something Horrible Went Wrong');
            }
        } else {
            redirect('posts');
        }
    }
}