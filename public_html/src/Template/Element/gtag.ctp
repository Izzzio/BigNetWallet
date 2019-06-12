<?php
/**
 * @var \App\Model\Entity\User $user
 */
if (empty(\App\Lib\Misc::tcfg('gtm'))) {
    return;
}
?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= \App\Lib\Misc::tcfg('gtm') ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '<?=\App\Lib\Misc::tcfg('gtm')?>');
</script>


<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', '<?=\App\Lib\Misc::tcfg('gtm')?>');</script>
<!-- End Google Tag Manager -->

<script>
    try {
        dataLayer.push({
            'attributes': {
                'userid': '<?=\App\Lib\CurrentUser::get('id')?>',
                'timestamp': <?=time()?>
            }
        });
    } catch (e) {
    }
</script>