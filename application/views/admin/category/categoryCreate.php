<?php $this->load->view("admin/header.php") ?>

<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>admin/category">Categories</a></li>
              <li class="breadcrumb-item active">Create New Category</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        Create New Category
                    </div>
                </div>

                <form enctype="multipart/form-data" name="categoryForm" id="categoryForm" method="post" action="<?php echo base_url()?>admin/category/create_category">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <!-- The is-invalid class is a bootstrap class to change the color of the input box  -->
                            <!-- We are using ternary operator to put the class or not based on the form_error -->
                            <!-- The set_value is used in value so that the form does not get cleared if validation error occurs -->
                            <input type="text" name="name" id="name" value="<?php echo set_value('name');?>" class="form-control <?php echo (form_error('name') != "") ? 'is-invalid' : ''; ?>">
                            <?php echo form_error('name');?>
                        </div>

                        <div class="form-group">
                            <label>Image</label> <br>
                            <input type="file" name="image" id="image" class="<?php echo (!empty($errorImageUpload)) ? 'is-invalid' : '';?>">
                            <?php echo (!empty($errorImageUpload)) ? $errorImageUpload : '';?>
                        </div>

                        <div class="custom-control custom-radio float-left">
                            <input class="custom-control-input" value="1" type="radio" id="statusActive" name="status" checked="">
                            <label for="statusActive" class="custom-control-label">Active</label>
                        </div>

                        <div class="custom-control custom-radio float-left ml-3">
                            <input class="custom-control-input" value="0" type="radio" id="statusBlock" name="status">
                            <label for="statusBlock" class="custom-control-label">Block</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button name="submit" type="submit" class="btn btn-primary">Submit</button>  
                        <a href="<?php echo base_url()?>admin/category" class="btn btn-secondary">Back</a>
                    </div>
              </form>
            </div>

          </div>
          <!-- /.col-md-6 -->
          </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   
<?php $this->load->view("admin/footer.php") ?>