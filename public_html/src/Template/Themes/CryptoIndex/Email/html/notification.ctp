<html>
<head><title><?= $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
</head>
<body style="background-color: #efefef; font-family: arial; font-size: 13px; font-weight: 200; line-height: 20px; color: #606060;">
<div style="padding: 5px;" itemscope itemtype="http://schema.org/EmailMessage">
    <div style="width: 550px; margin: 0 auto; border-radius: 4px; box-shadow: 0 0 5px #d6d6d6; margin-bottom: 10px; background-color: #ffffff; padding: 5px;">

        <div style="width: 50%; margin: 0; padding: 0; float: left;">
            <img src="http://old.bitcoen.io/images/logo.png"/>
        </div>

        <div style="width: 50%; margin: 0; padding: 0; float: right; text-align: right">
            <div style="font-size: 26px;padding: 12px 0 5px 0;border-bottom: 1px dashed #b3b3b3; display: inline-block;">+ 7 495 77-8888-4</div>
            <div style="padding: 3px 12px 3px 0px; font-size: 12px;  color: #606060;">Горячая линия</div>
        </div>

        <div style="clear: both; padding-bottom: 5px;"></div>

        <div><?= $content_for_layout; ?></div>
    </div>

    <div itemprop="author" itemscope itemtype="http://schema.org/Organization" style="width: 10px; height: 1px;">
        <meta itemprop="name" content="BitCoen"/>
        <link itemprop="url" href="http://old.bitcoen.io/"/>
        <link itemprop="logo" href="http://old.bitcoen.io/images/logo.png"/>
        <meta itemprop="telephone" content="+ 7 495 77-8888-4"/>
        <meta itemprop="email" content="sales@bitcoen.co.il"/>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressLocality" content="Москва"/>
            <meta itemprop="streetAddress" content="Красная площадь 1"/>
        </div>
    </div>


</div>
</body>
</html>

