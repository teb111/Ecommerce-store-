<?php require_once APPROOT .'/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
         <div class="card card-body bg-light mt-5">
             <h2>Add Post</h2>
             <p>Create a post with this form</p>
             <form action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">
            <!-- Form group starts -->
             <div class="form-group">
                 <label for="name">Title: <sup>*</sup></label>
                 <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
               <span class="invalid-feedback">
                   <?php echo $data['title_err']; ?>
               </span>
                </div>
                <!-- Form group Ends -->
                    <!-- Form group starts -->
             <div class="form-group">
                 <label for="name">Body: <sup>*</sup></label>
                 <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>">
                 <?php echo $data['body']; ?>
                </textarea>
               <span class="invalid-feedback">
                   <?php echo $data['body_err']; ?>
               </span>
                </div>
                <!-- Form group Ends -->
                       <!-- Form group starts -->
            <div class="group">
            <label for="file" id="file-label"><i class="fas fa-cloud-upload-alt upload-icon"> </i>Choose image</label>
            <input type="file" name="img" class="file <?php echo (!empty($data['img_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>" id="file">
              <span class="invalid-feedback">
                   <?php echo $data['img_err']; ?>
               </span>
          </div><!-- close group-->
                <!-- Form group Ends -->
                <div class="submit">
                <input type="submit" value="Submit" class="btn btn-success">
              </div>
            </form>
         </div>

<?php require_once APPROOT .'/views/inc/footer.php'; ?>