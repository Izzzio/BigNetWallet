<?php
$faqs = \App\Lib\FAQ::get();
?>
<section class="cab-sec">
    <h2 class="cab-sec-header"><?= __('FAQ') ?></h2>
    <div class="cab-blc cab-faq">
        <div class="cab-faq__wrap js-accordion">
            <div class="cab-faq__col">
            <?php
            $cntFAQInFirstCol = ceil(count($faqs) / 2);
            foreach ($faqs as $key => $faq){
                if($cntFAQInFirstCol == $key){
                ?>
                </div>
                <div class="cab-faq__col">
                <?php
                }
                ?>
                <div class="cab-faq__item">
                    <div class="cab-faq__title js-accordion-btn"><?=$faq['q']?></div>
                    <div class="cab-faq__hide js-accordion-hide"><?=$faq['a']?></div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
        <!--
        <a href="#" class="btn cab-btn--blue cab-faq__btn">Learn more</a>
        -->
    </div>
</section>