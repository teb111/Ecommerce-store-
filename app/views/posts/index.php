<?php require_once APPROOT .'/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
 <div class="row">
     <div class="col-md-6">
         <h1>Posts</h1> 
     </div>
     <div class="col-md-6">
         <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary float-right">
         <i class="fa fa-pencil"></i> Add Post
        </a>
     </div>
 </div>
 <div class="row">
      
            <img src="<? echo URLROOT; ?>/public/img/black.jpg" alt="">
       
 </div>
 <?php foreach($data['posts'] as $post): ?>
    <div class="card card-body mb-3">
       <div class="img">
           <img src="<?php echo URLROOT; ?>/public/img/<?php echo $post->img; ?>" alt="" width="100" height="100">
       </div>
    <h4 class="card-title"><?php echo $post->title; ?></h4>
    <div class="bg-light p-2 md-3">
     Written By <?php echo $post->name; ?> on <?php echo $post->postCreated; ?>
    </div>
    <p class="card-text">
        <?php echo $post->body ?>
    </p>
    <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">Show More</a>
    </div>

 <?php endforeach; ?>
<?php require_once APPROOT .'/views/inc/footer.php'; ?>