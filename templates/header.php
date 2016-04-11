<?php

if (!isset($title)) {
    $title = 'Unknown';
}

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
        
    <!--
    
     /$$$$$$ /$$  /$$$$$$$ /$$$$$$$ /$$$   /$$$
    |  $$$$$|   $ \____  $ \____  $ \  $  /  $
    |  $    |   $    /  $     /  $   \  $/  $
    |  $$$$$|   $   /  $     /  $     \    $
    |  $    |   $  /  $     /  $       |   $ 
    |  $    |   $ /  $$$$$ /  $$$$$    |   $
     \_$     \_/  \______/ \______/     \_/

    -->
    <!--<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">-->

    <title>Fizzy &#8213; Hello</title>

    <!-- Make it responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--     <script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:1457819669,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/dok3v=1613a3a185/"},atok:"b93913d5890f79f957487d71b396f452",petok:"a1087eb38a72ac1b221a74008499aae8924393d7-1457821017-1800",zone:"scotch.io",rocket:"m",apps:{},sha2test:0}];document.write('<script type="text/javascript" src="//ajax.cloudflare.com/cdn-cgi/nexp/dok3v=fb690a32f5/cloudflare.min.js"><'+'\/script>');}}catch(e){};
//]]>
</script>-->
    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64 96x96" href="/img/icons/favicon.ico">
    <!--<link rel="apple-touch-icon" sizes="57x57" href="/img/icons/favicons/favicon-57.png">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/icons/favicons/favicon-57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/icons/favicons/favicon-60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/icons/favicons/favicon-72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/icons/favicons/favicon-76.png">
    <link rel="apple-touch-icon" sizes="96x96" href="/img/icons/favicons/favicon-96.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/icons/favicons/favicon-114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/icons/favicons/favicon-120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/icons/favicons/favicon-144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/icons/favicons/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icons/favicons/favicon-180.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/img/icons/favicons/favicon-192.png">
    <link rel="apple-touch-icon" sizes="194x194" href="/img/icons/favicons/favicon-194.png">
    <link rel="apple-touch-icon" sizes="228x228" href="/img/icons/favicons/favicon-228.png">-->
    <meta name="application-name" content="Fizzy">
    <!--<meta name="msapplication-TileImage" content="/img/icons/favicons/favicon-144.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#222">-->

        <!--<link rel="alternate" hreflang="en" type="application/rss+xml" href="http://pub.scotch.io/feed" title="Scotch Pub RSS Feed">-->

    <!-- SOCIAL -->
    <!--<meta name="author" content="Scotch">
    <meta name="description" content="Scotch Pub">

            <link rel="canonical" href="http://pub.scotch.io">-->
    
    <!-- SOCIAL: TWITTER -->
    <!--<meta name="twitter:title" content="The+Pub">
    <meta name="twitter:description" content="Scotch Pub">
    <meta name="twitter:image" content="https://scotch.io/wp-content/uploads/2016/02/1500x500.png">
    <meta name="twitter:creator" content="@scotch_io">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@scotch_io">-->

    <!-- SOCIAL: FACESPACE -->
    <!-- <meta property="og:title" content="The+Pub">
    <meta property="og:image" content="https://scotch.io/wp-content/uploads/2016/02/1500x500.png">
    <meta property="og:description" content="Scotch Pub">
    <meta property="article:author" content="Scotch">
    <meta property="fb:admins" content="579622216,709634581">
    <meta property="fb:app_id" content="1389892087910588">
    <meta property="og:url" content="http://pub.scotch.io">
    <meta property="og:type" content="website">
    <meta property="article:publisher" content="https://www.facebook.com/scotchdevelopment">
    <meta property="og:site_name" content="Scotch Pub"> -->

    <!-- SOCIAL: G+ -->
    <!-- <link rel="publisher" href="https://plus.google.com/b/113854128330570384219">
    <link rel="author" href="https://plus.google.com/b/113854128330570384219">
    <meta itemprop="name" content="The+Pub">
    <meta itemprop="description" content="Scotch Pub">
    <meta itemprop="image" content="https://scotch.io/wp-content/uploads/2016/02/1500x500.png"> -->

    <!-- CSS -->
    <!-- MAKING BOB ROSS PROUD -->
    <!-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:400,700|Quattrocento+Sans:400,400italic,700,700italic">
    <link rel="stylesheet" href="/build/pub/css/styles.min.css">
    <link rel="stylesheet" href="/build/pub/css/scrolls.min.css"> -->

        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- <script src="/build/pub/js/scripts.min.js"></script>
    <script src="/build/pub/js/spells.min.js"></script> -->

    <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css"> -->
    <!--<link rel="stylesheet" href="assets/css/knacss.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

    <link rel="stylesheet" href="assets/css/home.css">-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <?php
        foreach ($css as $file) {
            $path = 'assets/css/' . $file . '.css';
            $args = "$path?". filemtime($path);
            $fullPath = ROOT_PATH . $path;
        ?>
            <link rel="stylesheet" media="screen" type="text/css" title="Style" href="<?php echo $fullPath; ?>" />
        <?php
        }
    ?>
</head>
<body class="app">
    <!-- Header -->
    <!--<header class="site-header site-header-pub">
    <div class="banner">
        <div class="family-dropdown">
            <a href="http://pub.scotch.io" class="brand the-pub current">
                <img src="/img/logo-pub.png" alt="Scotch.io Logo">
                <span class="text">
                    <img src="/img/logo-pub-text-small.png" alt="Scotch Pub Logo">
                </span>
            </a>
            <a href="#" class="toggle-family">
                <span class="left"></span>
                <span class="right"></span>
            </a>
            <div class="siblings">
                <a href="http://scotch.io" class="brand scotch-logo">
                    <img src="/img/logo.png" alt="Scotch Pub Logo">
                    <span class="text">
                        <img src="/img/logo-text-small.png" alt="Scotch.io Logo">
                    </span>
                </a>
                <a href="http://school.scotch.io" class="brand school">
                    <img src="/img/logo-school.png" alt="Scotch Pub Logo">
                    <span class="text">
                        <img src="/img/logo-school-text-small.png" alt="Scotch School Logo">
                    </span>
                </a>
            </div>
        </div>
        <nav class="main-nav">
            <ul>
                <li>
                    <a href="http://pub.scotch.io">Posts</a>
                </li>
                <li class="separator"></li>
                <li>
                    <a href="http://pub.scotch.io/about">About</a>
                </li>
                <li>
                    <a href="http://pub.scotch.io/ideas">Post Ideas</a>
                </li>
                <li>
                    <a href="http://pub.scotch.io/writing-guide">Writing Guide</a>
                </li>
                <li class="about-li">
                    <a href="https://scotch.io/about" class="about">
                        <span class="iconic iconic-heart"></span>
                    </a>
                    <ul>
                        <li><a href="https://digital.scotch.io">Scotch Digital</a></li>
                        <li><a href="https://shop.scotch.io">Scotch Store</a></li>
                        <li><a href="https://scotch-slack.herokuapp.com">Scotch Slack</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    </header>-->
    <header>
        <div id="banner" class="pure-menu-horizontal">
            <div class="fizzy-title">
                <span class="pure-menu-title">Fizzy</span>
            </div>

            <nav class="main-nav">
                <ul class="pure-menu-list">
                    <li class="pure-menu-item">
                        <a href="<?php echo ROOT_PATH . 'web'?>">
                            <span class="fa fa-html5"></span>
                            &nbsp; Web
                        </a>
                    </li>
                    <li class="pure-menu-item">
                        <a href="<?php echo ROOT_PATH . 'life'?>">
                            <span class="fa fa-heart"></span>
                            &nbsp; Life
                        </a>
                    </li>
                    <li class="pure-menu-item">
                        <a href="<?php echo ROOT_PATH . 'music'?>">
                            <span class="fa fa-music"></span>
                            &nbsp; Music
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="Languages">
                <!-- Put languages here -->
            </div>
        </div>
    </header>

    <div id="app-container">