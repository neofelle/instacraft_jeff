 <?php
            if ($productDetail->item_unit == '1')
                $weight_in = 'ounce';
            if ($productDetail->item_unit == '2')
                $weight_in = 'gram';
            if ($productDetail->item_unit == '3')
                $weight_in = 'ml';
            if ($productDetail->item_unit == '4')
                $weight_in = 'piece';
            ?>
<section class="container mobile-view-container">
    <div class="order_detail_container">
        <div class="product-det-thumb">
            <a class="inline" href="#image_fullscreen"><img src="<?=$productDetail->item_image?>"/></a>
        </div>
        <div class="prod-deta">
            <h1><?=$productDetail->item_name?></h1>
            <p class="prod-cat"><?=$productDetail->category_name?></p>
            <span class="prod-price"><label>Price</label><span> $<?=$productDetail->price_gram_off > 0?$productDetail->price_gram_off:$productDetail->price_gram?> /gram</span></span>
        </div>
        <ul class="tabs_menu three-tabs d-flex flex-nowrap align-items-center justify-content-start">
            <li class="col active">Info</li>
            <li class="col">Effects</li>
        </ul>
        <div class="detail_tab">
            <div class="product_container">
                <h2 class="description-head">Description:</h2>
                <p class="description">
                    <?=$productDetail->review?>
                </p>
                <button class="btn gradient change_pass">
                    <span class="btn-txt add_to_cart add_add_to_cart" 
                          data-productname="<?= $productDetail->item_name ?>" 
                           data-productprice="<?= $productDetail->price_one ?>" 
                           data-productpriceoff="<?= $productDetail->price_one_off ?>" 
                           data-productpriceeigth="<?= $productDetail->price_eigth ?>" 
                           data-productpriceeigthoff="<?= $productDetail->price_eight_off ?>" 
                           data-productpricegram="<?= $productDetail->price_gram ?>" 
                           data-productpricegramoff="<?= $productDetail->price_gram_off ?>" 
                           data-isearlyadopter="<?= $productDetail->is_early_adopter ?>" 
                           data-limited="<?= $productDetail->limited ?>" 
                          data-attribute="addtocart-pop">ADD TO CART
                    </span>
                </button>
            </div>
            <div class="driver_detail">
                <div class="lab-group">
                    <label class="bab-lable">Recommended Uses:</label>
                    <p class="lab-deta"><?= $productDetail->recommended_uses?$productDetail->recommended_uses:"-NA-" ?></p>
                    <label class="bab-lable">Flavor:</label>
                    <p class="lab-deta"><?=$productDetail->flavor?$productDetail->flavor:"-NA-"?></p>
                    <label class="bab-lable">Smell:</label>
                    <p class="lab-deta"><?=$productDetail->smell?$productDetail->smell:"-NA-"?></p>
                    <label class="bab-lable">Effect:</label>
                    <p class="lab-deta"><?=$productDetail->effect?$productDetail->effect:"-NA-"?></p>

                </div>
                <button class="btn gradient change_pass">
                    <span class="btn-txt add_to_cart add_add_to_cart" 
                          data-productname="<?= $productDetail->item_name ?>" 
                           data-productprice="<?= $productDetail->price_one ?>" 
                           data-productpriceoff="<?= $productDetail->price_one_off ?>" 
                           data-productpriceeigth="<?= $productDetail->price_eigth ?>" 
                           data-productpriceeigthoff="<?= $productDetail->price_eight_off ?>" 
                           data-productpricegram="<?= $productDetail->price_gram ?>" 
                           data-productpricegramoff="<?= $productDetail->price_gram_off ?>" 
                           data-isearlyhttps://instacraft1.s3.amazonaws.com//med%201_263187_1515365389.jpgadopter="<?= $productDetail->is_early_adopter ?>" 
                           data-limited="<?= $productDetail->limited ?>" 
                     https://instacraft1.s3.amazonaws.com//med%201_263187_1515365389.jpg     data-attribute="addtocart-pop">ADD TO CART
                    </span>
<!--                    <span class="btn-txt">Add to cart</span>-->
                </button>
            </div>
        </div>

    </div>
</section>
<div style="display:none">
    <div id="image_fullscreen" class="modal">
      <img src="<?= $this->config->item('globalassets') ?>img/close_button.png" onclick="parent.$.colorbox.close()" style="width:30px;float: right;border-left: 1px solid #777777;border-bottom: 1px solid #777777;cursor: pointer;position: absolute;right: 0px;    margin-top: 10px;margin-right: 5px;border: 0px !important;" />
      <img src="<?=$productDetail->item_image?>" style="width:100%;height:100%;"/>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.tabs_menu li').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
            $(".detail_tab > div").eq($(this).index()).show().siblings().hide()
        });
        if ($('.profile_img img').length && $('.profile_img img').get(0).naturalWidth > $('.profile_img img').get(0).naturalHeight) {
            $('.profile_img').addClass('vertical');
        } else {
            $('.profile_img').addClass('horizontal');
        }
        $('.container').enscroll(); 
        $(".inline").colorbox({inline:true, width:"100%",height:"auto", scrolling:true});
    });
</script>
<style>
.modal {
    position: relative !important;
    top: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    z-index: 1 !important;
    display: block !important;
    overflow: hidden;
    outline: 0;
}
</style>