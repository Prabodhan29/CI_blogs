<?php
$this->load->view('front/header');
?>

<div class="container">
    <h3 class="pt-4 pb-4">Blog / <?php echo $category['Name']?></h3>

    <?php
    if(!empty($articles)) {
        foreach ($articles as $article) {
    ?>
    <div class="row mb-5">
        <div class="col-md-4">
            
            <?php
            if (!empty($article['Image'])) {
                ?>
                <img class="w-100 rounded" src="<?php echo base_url('admin_section/uploads/articles/thumbnail_admin/'.$article['Image'])?>">
                <?php
            }
            ?>

        </div>
        <div class="col-md-8">
           <p class="bg-light pt-2  pb-2  pl-3">
               <a href="<?php echo base_url('blog/category/'.$article['Category'])?>" class="text-muted text-uppercase "><?php echo $article['Category']?></a>
           </p>

           <h3>
                <a href="<?php echo base_url('blog/detail/'.$article['articleID']);?>"><?php echo $article['Title'];?></a>
           </h3>
            
            <p>
                <?php echo word_limiter(strip_tags($article['Description']),50);?>
                <a href="<?php echo base_url('blog/detail/'.$article['articleID']);?>" class="text-muted">Read More</a> 
            </p> 

            <p class="text-muted">Posted By <strong><?php echo $article['Author'];?></strong> on <strong><?php echo date('d M Y',strtotime($article['createdAt']));?></strong></p>
        </div>
    </div>
    <?php
        }
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <?php
                echo $pagination_links;
            ?>
        </div>
    </div>
    
</div>

<?php
$this->load->view('front/footer');
?>