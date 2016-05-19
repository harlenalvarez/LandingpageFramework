<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?php
    $files = scandir(ROOT."views/resources/css");
    foreach ($files as $file)
    {
        if(!is_dir(ROOT."views/resources/css/".$file))
        {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo URL_PATH."views/resources/css/".$file?>"/>
            <?php
        }
    }
    ?>

    <link rel="stylesheet" type="text/css" href="<?php echo URL_PLUGINS?>slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_PLUGINS?>slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_SITE_CSS?>" />
    <base href="<?php echo URL_PATH ?>"/>
    <meta charset="utf-8"/>
    <meta name="keywords" content="<?php echo $params['keywords']?>" />
    <meta name="description" content="<?php echo $params['description']?>" />
    <meta name="title" content="<?php echo $params['title']?>"  />
    <title><?php echo $params['title']?></title>
    <style>

        body{

            color:white;
            padding;0px;
            margin:0px;
            width:100%;
            height:100%;
            background-image:url('<?php echo URL_IMAGES_PATH."under-construction.jpg"?>');
            background-color:rgba(0,0,0,.7);
            background-size: 100% 100%;
            background-blend-mode: multiply;
        }
        h1{
            font-family: open-sans-extra-bold;
        }
        .constructionMsg{
            font-family: open-sans;
            text-align: center;
            vertical-align: middle;
            width:100%;
            height: 80vh;
        }
        .constructionFooter{

            width:100%;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="constructionMsg">
        <h1>Awsome Site Coming Soon</h1>
        <p>We are working hard to bring this awsome site online<br/>Please stay tuned</p>
    </div>
    <hr/>
    <div class='constructionFooter'>
        <div class="container">
            <span class="text-muted">&COPY; Creative, Inc. All rights reserved</span>
        </div>

    </div>
</body>
</html>


