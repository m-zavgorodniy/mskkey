<!DOCTYPE html>
<html class="no-js" lang="<?=$_SITE['html_lang']?>">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?	//  define SEO_ constants in inner template ?>
	<title><?=$_SITE['seo_title']?$_SITE['seo_title']:(defined('SEO_PAGE_TITLE')?SEO_PAGE_TITLE . ' — ' . $_SITE['site_title']:$_SITE['page_title'])?></title>
<?	if (defined('SEO_PAGE_NOINDEX')) { ?>
	<meta name="robots" content="NOINDEX, NOFOLLOW">
<?	} else { ?>
	<meta name="robots" content="NOODP">
<?	} ?>
<?	if ($_SITE['seo_description']) { ?>
	<meta name="description" content="<?=$_SITE['seo_description']?>">
<?	} else if (defined('SEO_DESCRIPTION')) { ?>
	<meta name="description" content="<?=SEO_DESCRIPTION?>">
<?	}
	if ($_SITE['seo_keywords']) { ?>
	<meta name="keywords" content="<?=$_SITE['seo_keywords']?>">
<?	} else if (defined('SEO_KEYWORDS')) { ?>
	<meta name="keywords" content="<?=SEO_KEYWORDS?>">
<?	} ?>
    <meta name="yandex-verification" content="ab33d391608ad078">
    <meta name="facebook-domain-verification" content="oay0t4fqenuf8hmjcgh5czr372tnwf">

	<link href="/css/styles.css?r=6" rel="stylesheet">
    <link href="/css/styles_responsive.css?r=6" rel="stylesheet">
	<!--[if lte IE 8]><link rel="stylesheet" href="/css/ie.css" media="screen" /><![endif]-->
	<link href="/css/content.css" rel="stylesheet">

	<link rel="stylesheet" href="/fonts/font-awesome.min.css">
	<script src="/js/modernizr.js"></script>
    <!--[if lte IE 8]><script src="/js/respond.min.js"></script><![endif]-->

	<script src="/js/jquery-1.11.1.min.js"></script>
	<script src="/js/jquery.easing.js"></script>
	<script src="/js/jquery.mousewheel.js"></script>
	<script src="/js/placeholder.fix.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox.css">
    <script type="text/javascript" src="/js/fancybox/jquery.fancybox.js"></script> 
	<script defer src="/js/flexslider/jquery.flexslider-min.js"></script>
	<link href="/js/flexslider/flexslider.css" rel="stylesheet" media="screen">
	<script src="https://maps.googleapis.com/maps/api/js?language=ru"></script>
	<link rel="stylesheet" type="text/css" href="/paginator/paginator3000.css">
	<script type="text/javascript" src="/paginator/paginator3000.js"></script>

	<script src="/js/script.js?r=5"></script>

    <script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-225111-4bUTF';</script>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2816344165296397');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2816344165296397&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
</head>
<body class="page-<?=$_SITE['section_type']?>">
<div class="body">
    <!-- Rating Mail.ru counter -->
    <script type="text/javascript">
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "3211456", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
    (function (d, w, id) {
    if (d.getElementById(id)) return;
    var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
    ts.src = "https://top-fwz1.mail.ru/js/code.js";
    var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
    if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "topmailru-code");
    </script><noscript><div>
    <img src="https://top-fwz1.mail.ru/counter?id=3211456;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
    </div></noscript>
    <!-- //Rating Mail.ru counter -->
	<header>
        <div class="g-container">
            <div class="g-container-box">
            	<div class="header">
                    <div class="header-top">
                        <a href="#" class="header-hamburger" id="hamburger">
                            <i class="fa fa-bars"></i>
                        </a>
                        <a href="/" class="header-logo">
                            <img src="/images/moscow_key_logo.svg" alt="МСК Ключ">
                        </a>
                        <div class="header-moomap">
                            <img src="/images/moomap_logo.gif" title="Московская ассоциация предпринимателей" alt="МАП">
                        </div>
                        <div class="header-contacts">
                            <div class="header-contacts-phone"><a href="tel:<?=$_SITE['settings']['phone']?>"><?=$_SITE['settings']['phone']?></a></div>
                            <div class="header-contacts-request"><a href="<?=$_SITE['section_paths']['contact']['path']?>" class="g-button">Оставьте заявку</a></div>
                        </div>
                    </div>
                    <nav class="header-menu g-clearfix">
                        <ul>
                        <?	foreach ($_SITE['menu']['main'] as $id => &$menu_item) { ?>
                                <li class="header-menu-item<?=$menu_item['submenu']?' w-submenu':''?><?='/property/' == $menu_item['url']?' header-menu-property':''?>">
                                    <a href="<?=$menu_item['url']?>"><?=$menu_item['title']?></a>
                                <?	if ($menu_item['submenu']) { ?>
                                    <div class="header-menu-submenu">
                                        <ul>
                                        <?	foreach ($menu_item['submenu'] as $id => &$submenu_item) { ?>
                                                <li><a href="<?=$submenu_item['url']?>"<?=$submenu_item['target_blank']?' target="_blank"':''?>><?=$submenu_item['title']?></a></li>
                                        <?	}
                                            unset($submenu_item); ?>
                                        </ul>
                                    </div>
                                <?	} ?>
                                </li>
                        <?	}
                            unset($menu_item); ?>
                        </ul>
                        <a href="<?=$_SITE['section_paths']['property']['path']?>" class="header-menu-right"><i class="fa fa-search"></i><span>Найти недвижимость</span></a>
                    </nav>
	            </div>
            </div>
        </div>
    </header>
    <div class="body-content">
    	<div class="g-container">
	        <div class="g-container-box">
            
            	<?=$__CMS__INNER_TEMPLATE_CONTENTS?>

			<?	if ($_SITE['seo_text']) { ?>
            		<div class="body-content-textblock">
                    	<?=$_SITE['seo_text']?>
                    </div>
            <?	} ?>
            </div>
        </div>
    </div>
<?	/*if ($_SITE['is_index_page']) { ?>
    <div class="home-highlights">
    	<div class="home-highlights-box">
	    	<div class="g-container">
    	    	<div class="g-container-box">
        			<div class="highlights-items">
                    	<ul>
                        	<li class="highlights-item">
                            	<div class="highlights-item-image">
                            		<img src="/images/hl_house.png" alt="">
                                </div>
                            	<div class="highlights-item-title">
                                	Свежие предложения 
                                </div>
                                <div class="highlights-item-body">
                                    Список наших объектов недвижимости включает<br>
                                    в себя самые новые предложения<br>
                                    и постоянно обновляется.<br>
                                </div>
                               	<!--<a href="#" class="highlights-item-link">Посмотреть</a> -->
                            </li>
                        	<li class="highlights-item">
                                <div class="highlights-item-image">
                            		<img src="/images/hl_thumb.png" alt="">
                                </div>
                                <div class="highlights-item-title">
                                    Лучшие цены
                                </div>
                                <div class="highlights-item-body">
                                    Мы на вашей стороне. Мы стремимся, чтобы<br>
                                    именно у нас вы смогли найти предложение<br>
                                    с подходящей именно вам ценой.<br>
                                </div>
                                <!--<a href="#" class="highlights-item-link">Искать</a> -->
                            </li>
                        	<li class="highlights-item">
                                <div class="highlights-item-image">
                            		<img src="/images/hl_star.png" alt="">
                                </div>
                                <div class="highlights-item-title">
                                    Гарантированный сервис
                                </div>
                                <div class="highlights-item-body">
                                    Вы всегда сможете обратиться к нам за советом<br>
                                    или консультацией. Вы выбираете - <br>
                                    все остальное делаем мы.<br>
                                </div>
                                <!--<a href="#" class="highlights-item-link">Связатся с нами</a> -->
                            </li>
                        </ul>
                    </div>
        		</div>
	        </div>
        </div>
    </div>
<?	} */ ?>
    <footer>
        <div class="g-container">
            <div class="g-container-box">
            	<div class="footer-main g-clearfix">
                    <div class="footer-col">
                    	<div class="g-big">
                        	Агентство недвижимости
	                    	<div class="footer-company-name">МСК КЛЮЧ</div>
                        </div>
                        <div class="footer-company-text">
                            <p>
	                            Наши цены на вашей стороне - ведь мы заинтересованы в том, чтобы именно у нас вы нашли подходящее вам предложение.
                            </p>
                            <p>
		                        <span class="g-bold">Вы выбираете - все остальное сделаем мы!</span>
                            </p>
                        </div>
                    </div>
                    <div class="footer-col">
                        <div class="g-big">
                        	Вы хотите купить недвижимость?
                        </div>
                        <div class="footer-button">
                        	<a href="<?=$_SITE['section_paths']['contact']['path']?>?source=footer" class="g-button">Оставьте заявку</a>
                        </div>
                        <div class="g-big">
                        	или позвоните нам
                        </div>
                        <div class="footer-phone">
                            <a href="tel:<?=$_SITE['settings']['phone']?>"><?=str_replace(')', ') <span class="footer-phone-number">', $_SITE['settings']['phone']) . '</span>'?></a>
                        </div>
                    </div>
                    <div class="footer-col">
                    	<nav class="footer-menu">
	                        <ul>
	                        	<li><a href="#">Недвижимость</a>
			                        <ul>
                                    	<li><a href="/property/residential/">Жилая недвижимость</a></li>
                                    	<li><a href="/property/country/">Загородная недвижимость</a></li>
                                    	<li><a href="/property/new-build/">Аренда</a></li>
                                    	<li><a href="/property/commercial/">Коммерческая недвижимость</a></li>
                                    	<li><a href="/property/abroad/">Зарубежная недвижимость</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">О компании</a>
                                    <ul>
                                        <li><a href="/contacts/">Контакты</a></li>
                                        <li><a href="/privacy/">Политика конфиденциальности</a></li>
                                    </ul>
                                </li>
    	                    </ul>
                        </nav>
                    </div>
                </div>
                <div class="footer-btl">
                	<div class="footer-col">© 2013&ndash;<?=date('Y')?> МСК Ключ</div>
                	<div class="footer-col">
                        <a href="https://vk.com/mskkey" target="_blank" title="МСК КЛЮЧ вКонтакте"><i class="fa fa-vk"></i></a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="https://www.facebook.com/mskkey/" target="_blank" title="МСК КЛЮЧ в Facebook"><i class="fa fa-facebook-official"></i></a>
                    </div>
                	<div class="footer-col">
                    	<a href="http://e-i.com.ru" target="_blank">Разработка Eclipse</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter42270919 = new Ya.Metrika2({
                    id:42270919,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/42270919" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54162503-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-54162503-1');
</script>
</body>
</html>