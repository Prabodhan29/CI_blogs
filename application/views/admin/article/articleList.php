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
                    <li class="breadcrumb-item active">Articles</li>
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

                <?php if ($this->session->flashdata('success') != "") { ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('error') != "") { ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <form id="searhFrm" name="searhFrm" method="get" action="">
                                <div class="input-group mb-0">
                                    <input type="text" value="<?php echo $q; ?>" class="form-control" placeholder="Search" name="q">
                                    <div class="input-group-append">
                                        <button class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-tools">
                            <a href="<?php echo base_url() . 'admin/article/create_article'; ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <th width="50">#</th>
                                <th width="100">Image</th>
                                <th>Title</th>
                                <th width="180">Author</th>
                                <th width="100">Created date</th>
                                <th width="70">Status</th>
                                <th width="140" class="text-center">Action</th>
                            </tr>

                            <?php if (!empty($articles)) {
                                foreach ($articles as $article) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $article['articleID'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            $path = './admin_section/uploads/articles/thumbnail_admin/' . $article['Image'];
                                            if ($article['Image'] != "" && file_exists($path)) {
                                            ?>
                                                <img class="w-100" src="<?php echo base_url('./admin_section/uploads/articles/thumbnail_admin/' . $article['Image']) ?>" alt="">
                                            <?php
                                            } else {
                                            ?>
                                                <img class="w-100" src="<?php echo base_url('./admin_section/uploads/articles/no_image.jpg'); ?>" alt="">

                                            <?php
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <?php echo $article['Title'] ?>
                                        </td>
                                        <td>
                                            <?php echo $article['Author'] ?>
                                        </td>
                                        <td>
                                            <?php echo date('Y-d-m', strtotime($article['createdAt'])) ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($article['Status'] == 1) {
                                            ?>
                                                <p class="badge badge-success">Active</p>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="badge badge-danger">Block</p>
                                            <?php } ?>

                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url('admin/article/edit_article/' . $article['articleID']); ?>" class="btn btn-sm btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <a href="javascript:void(0);" onclick="deleteArticle(<?php echo  $article['articleID']; ?>)" class="btn btn-sm btn-danger">
                                                <i class="far fa-trash-alt"></i>
                                            </a>

                                        </td>
                                    </tr>

                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">Records not found</td>
                                </tr>

                            <?php

                            } ?>
                        </table>
                        <nav>
                            <?php  echo $pagination_links ?>
                        </nav>
                    </div>

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
<script type="text/javascript">
    function deleteArticle(id) {
        if (confirm("Are you sure you want to delete article?")) {
            window.location.href = '<?php echo base_url().'admin/article/delete_article/'; ?>' + id;
        }
    }
</script>