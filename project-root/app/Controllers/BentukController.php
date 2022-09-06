<?= $this->extend('layout/main') ?>

<?= $this->section('header') ?>
<!--swiper-->
<link rel="stylesheet" href="/assets/vendor/node_modules/css/choices.min.css">
<link rel="stylesheet" href="/assets/vendor/node_modules/css/swiper-bundle.min.css">
<style>
    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .swiper {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .mySwiper2 {
        height: 80%;
        width: 100%;
    }

    .mySwiper {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .mySwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('mainContent') ?>
<section class="position-relative bg-white mt-8">
    <div class="container py-9 py-lg-11 position-relative">
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-6 mx-auto mx-lg-0 mb-5 mb-lg-0">
                <div class="row justify-content-center">
                    <div class=" swiper mySwiper2" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">

                        <div class="swiper-wrapper"><?php
                                                    foreach ($productImages as $pis) : ?>

                                <div class="swiper-slide">
                                    <img class="img-fluid" src="/assets/img/products/<?= $pis['img_file'] ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                        <?php foreach ($productImages as $pis) : ?>
                            <div class="swiper-slide">
                                <img class="img-thumbnail" src="/assets/img/products/<?= $pis['img_file'] ?>" />
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mx-auto col-lg-6">
                <!-- Product Description -->
                <div class="mb-3 pb-3 border-bottom">
                    <div class="mb-3">
                        <h2 class="mb-4 display-4" id="productName"><?= $products['name'] ?></h2>
                    </div>
                    <div class="mb-3">
                        <h2 class="mb-4 display-4" id="productName"><?= $products['brand_name'] ?></h2>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="maxPrice" class="form-label">Varian Produk</label>
                            <?php if($products['variant_flag']==0) : echo 'Product ini tidak memiliki varian produk'; else:?>
                            <select id="prodVariant" class="form-select">
                                <option value="" selected>Pilih varian</option>
                                <?php foreach ($productVariants as $pv) : ?>
                                <option value="<?= $pv['id'] ?>" data-price="<?= $pv['price'] ?>"><?= $pv['variant_product'] ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" onclick="orderWa()" id="btnFilter" style="color:white;font-weight: bold;" class="btn btn-success mb-2 me-1 form-control">Beli Via whatsapp</button>
                            <button type="button" onclick="switchUrl('<?= $products['url_tokped'] ?>')" id="btnFilter" style="color:white;font-weight: bold;" class="btn btn-success mb-2 me-1 form-control">Beli Via Tokopedia</button>
                            <!--<button type="button" onclick="switchUrl('<?= $products['url_shopee'] ?>')" id="btnFilter" style="color:white;font-weight: bold;" class="btn btn-warning mb-2 me-1 form-control">Beli Via Shopee</button>-->
                            <!--<button type="button" onclick="switchUrl('<?= $products['url_lazada'] ?>')" id="btnFilter" style="color:white;font-weight: bold;" class="btn btn-danger mb-2 me-1 form-control">Beli Via Lazada</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>

    </div>
    </div>
</section>
<section class="bg-light">
    <div class="container py-9 py-lg-11">
        <div class="row justify-content-center">
            <div class="col-lg-9 mb-5">
                <nav class="nav nav-pills">
                    <a href="#description" class="nav-link active" data-bs-toggle="tab" aria-haspopup="false" aria-expanded="true">
                        Deskripsi
                    </a>
                    <a href="#information" class="nav-link" data-bs-toggle="tab" aria-haspopup="false" aria-expanded="false">
                        Spesifikasi
                    </a>
                </nav>
            </div>
            <!--/.col-->
            <div class="col-lg-9 col-md-8">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="description">
                        <p class="mb-5">
                        <?= $products['description'] ?>
                        </p>
                    </div>
                    <!--Tab-pane-->
                    <div class="tab-pane fade" id="information">
                        <div class="tab-pane fade active show" id="information">
                        <?= $products['specification'] ?>
                        </div>
                    </div>
                    <!--Tab-pane-->
                </div>
                <!--Tab-pane-->
            </div>
        </div>
    </div>
</section>
<section class="bg-light">
    <div class="container">
        <div class="row">
        <div class="d-flex align-items-center mb-4">
            <h6 class="mb-0 me-3 me-md-4">Produk Lainya</h6>
            <div class="border-bottom flex-grow-1"></div>
        </div>

        <div class="container py-9 py-lg-11">
            <div class="row mb-4">
            <?php
            foreach ($productList as $pl) : ?>
                <div class="col-sm-12 col-md-4" onclick="location.href='/produk/<?= $pl['id'] ?>'" style="cursor:pointer;">
                    <img src="/assets/img/products/<?= $pl['img_file'] ?>" class="mb-2 img-thumbnail">
                    <a href="/produk/<?= $pl['id'] ?>">
                        <h5><span class="badge bg-warning" style="width:100%"><?= $pl['name'] ?></span></h5>
                    </a>
                </div>
            <?php
            endforeach; ?>
            </div>
        </div>
    </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script src="/assets/vendor/node_modules/js/choices.min.js"></script>
<script src="/assets/vendor/node_modules/js/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>

<script>
    //Swiper thumbnail demo
    var swiperThumbnails = new Swiper(".mySwiper", {
        spaceBetween: 30,
        slidesPerView: "auto",
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true
    });
    var swiperThumbnailsMain = new Swiper(".mySwiper2", {
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiperThumb-next",
            prevEl: ".swiperThumb-prev"
        },
        thumbs: {
            swiper: swiperThumbnails
        }
    });
    var el = document.querySelectorAll("[data-choices]");
    el.forEach(e => {
        const t = {
            ...e.dataset.choices ? JSON.parse(e.dataset.choices) : {},
            ...{
                classNames: {
                    containerInner: e.className,
                    input: "form-control",
                    inputCloned: "form-control-xs",
                    listDropdown: "dropdown-menu",
                    itemChoice: "dropdown-item",
                    activeState: "show",
                    selectedState: "active"
                }
            }
        }
        new Choices(e, t)
    });

    function orderWa() {
        var qty = $("#qty").val();
        var harga = $("#price").val();
        var namaItem = $("#productName").text();
        if (harga == "" || harga == null) {
            alert("Silahkan pilih varian produk!");
        }else if (qty == "" || qty == null) {
            alert("Jumlah tidak boleh kosong!");
        } else {
            var stringMessage = "";
            stringMessage = "Halo%20saya%20" + "%0A" +
                "ingin%20memesan%20%3A%20" + namaItem + "%0A" +
                "jumlah%20%3A%20" + qty + "%0A";
            var url = "https://wa.me/<?= preg_replace('/\s+/', '', (preg_replace('/[+-]/', '', $main_phone_no['value']))); ?>?text=" + stringMessage;
            var win = window.open(url, "_blank");
        }
    }

function switchUrl(url){
    var win = window.open(url, "_blank");
}
</script>

<?= $this->endSection() ?>