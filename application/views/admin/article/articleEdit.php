<?php $this->load->view('admin/header'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Articles</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/article'; ?>">Articles</a></li>
                    <li class="breadcrumb-item active">Edit Article</li>
                    <li class="breadcrumb-item active"><?php echo $article['Title']; ?></li>
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
                            Edit Article "<?php echo $article['Title']; ?>"
                        </div>
                    </div>
                    <form enctype="multipart/form-data" name="categoryForm" id="categoryForm" method="post" action="<?php echo base_url() . 'admin/article/edit_article/' . $article['articleID'] ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control <?php echo (form_error('category_id') != "") ? 'is-invalid' : ''; ?>" id="category_id">
                                    <option value="">Select a Category</option>
                                    <?php
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            $selected = ($article['Category'] == $category['categoryID']) ? true : false;
                                    ?>
                                            <option <?php echo set_select('category_id', $category['categoryID'], $selected); ?> value="<?php echo $category['categoryID']; ?>"><?php echo $category['Name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                                echo form_error('category_id');
                                ?>
                            </div>

                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control <?php echo (form_error('title') != "") ? 'is-invalid' : ''; ?>" type="text" name="title" id="title" value="<?php echo set_value('title', $article['Title']); ?>">
                                <?php
                                echo form_error('title');
                                ?>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="textarea"><?php echo set_value('description', $article['Description']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Image</label> <br>
                                <input type="file" name="image" id="image" class="<?php echo (!empty($imageError)) ? 'is-invalid' : ''; ?>">

                                <br>
                                <?php
                                $path = './admin_section/uploads/articles/thumbnail_admin/' . $article['Image'];
                                if ($article['Image'] != "" && file_exists($path)) {
                                ?>
                                    <img class="mt-3" src="<?php echo base_url() . 'admin_section/uploads/articles/thumbnail_admin/' . $article['Image'] ?>">
                                <?php
                                }
                                ?>
                                <?php
                                if (!empty($imageError)) echo $imageError;
                                ?>
                            </div>

                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" name="author" id="author" value="<?php echo set_value('author', $article['Author']); ?>" class="form-control <?php echo (form_error('author') != "") ? 'is-invalid' : ''; ?>">
                                <?php
                                echo form_error('author');
                                ?>
                            </div>

                            <div class="custom-control custom-radio float-left">
                                <input class="custom-control-input" value="1" type="radio" id="statusActive" name="status" <?php echo ($article['Status'] == 1) ? 'checked' : ''; ?>>
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>

                            <div class="custom-control custom-radio float-left ml-3">
                                <input class="custom-control-input" value="0" type="radio" id="statusBlock" name="status" <?php echo ($article['Status'] == 0) ? 'checked' : ''; ?>>
                                <label for="statusBlock" class="custom-control-label">Block</label>
                            </div>
                        </div>

                        <div class="card-footer">

                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>

                            <a href="<?php echo base_url() . 'admin/article'; ?>" class="btn btn-secondary">Back</a>

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

<?php $this->load->view('admin/footer'); ?>