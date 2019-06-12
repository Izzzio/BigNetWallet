<?php
/**
 * @var array $langs
 */

$faqs = \App\Lib\FAQ::get();
?>
<div class="lk-block bottom-block">
    <div class="referal-title"><?= __('FAQ') ?></div>
    <?php
        foreach ($faqs as $faq){
            ?>

            <h3 class="accordion" ><?=$faq['q']?></h3>
            <div class="accordionPanel"><?=$faq['a']?></div>
            <?php
        }
    ?>

</div>

<style>
    .accordionPanel {
        padding: 0 18px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background: rgba(255, 255, 255, 0.23);
    }


</style>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight){
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>