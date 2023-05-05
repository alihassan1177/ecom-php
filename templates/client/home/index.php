<?php

use App\ProductCategoryController;

$banners = $data["data"]["banners"];
$categories = $data["data"]["categories"];
$products = $data["data"]["products"];
$placeholderImage = "/img/product-placeholder.png";

if (count($banners) > 0) :
    ?>

    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php for ($i =0; $i < count($banners); $i++) :
                $banner = $banners[$i];
                ?>
                <div class="carousel-item <?= $i == 0 ? "active" : "" ?>">
                    <img class="img-fluid" src="<?= $banner["image"] ?>" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h4 class="text-light text-uppercase font-weight-medium mb-3"><?= html_entity_decode($banner["sub_heading"])  ?></h4>
                            <h3 class="display-4 text-white font-weight-semi-bold mb-4"><?= html_entity_decode($banner["heading"])  ?></h3>
                            <a href="<?= html_entity_decode($banner["btn_link"])  ?>" class="btn btn-light py-2 px-3"><?= html_entity_decode($banner["btn_text"])  ?></a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
<?php endif;  ?>

<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<?php if(count($categories) > 0):  ?>
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <?php foreach($categories as $category):
                $productsCount = count(ProductCategoryController::getProductsByCategory($products, $categories, $category["id"]));
                ?>
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <p class="text-right"><?= $productsCount ?> Products</p>
                        <a href="" class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid" src="<?= $placeholderImage ?>" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0"><?= $category["name"] ?></h5>
                    </div>
                </div>
            <?php endforeach;  ?>
        </div>
    </div>
    <!-- Categories End -->
<?php  endif; ?>

<!-- Offer Start -->
<div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                <img src="/client/img/offer-1.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                    <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                <img src="/client/img/offer-2.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                    <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<?php if(count($products) > 0):  ?>
    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Latest Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php 

            foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="<?= $placeholderImage ?>" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?= $product["name"] ?></h6>
                            <?php if(!empty($product["price"])): ?>
                                <div class="d-flex justify-content-center">
                                    <h6>$<?= $product["price"] - 10 ?></h6>
                                    <h6 class="text-muted ml-2"><del>$<?= $product["price"] ?></del></h6>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Products End -->
<?php endif?>
