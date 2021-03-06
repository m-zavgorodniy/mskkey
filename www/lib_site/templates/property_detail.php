<? /*<script type="text/javascript">
    !function(e,t){var a=e.getElementsByTagName("script")[0],n=e.createElement("script"),i=function(){a.parentNode.insertBefore(n,a),n.readyState?n.onreadystatechange=function(){("loaded"==n.readyState||"complete"==n.readyState)&&pb_front_widget.init("http://pb480.profitbase.ru/api/v2/json/sitewidget/widget",{pb_api_key:"8d1cb9dabf36695db5ec4018082ace7d"})}:n.onload=function(){pb_front_widget.init("http://pb480.profitbase.ru/api/v2/json/sitewidget/widget",{pb_api_key:"8d1cb9dabf36695db5ec4018082ace7d"})}};n.type="text/javascript",n.async=!0,n.src="http://pb480.profitbase.ru/assets/js/sw.js","[object Opera]"==t.opera?e.addEventListener("DOMContentLoaded",i,!1):i()}(document,window);
</script>
*/ 

//	print_r($_DATA);
if (!$_DATA['listing']['is_single']) {
	redirect_301($_SITE['section_paths']['property']['path']);
} else {
?>
<script src="https://www.google.com/recaptcha/api.js?render=6Ld2xacUAAAAAKpjYm3t5GzLCuVy2pzP8MAr56wY"></script>
<script>
    grecaptcha.ready(function() {
      grecaptcha.execute('6Ld2xacUAAAAAKpjYm3t5GzLCuVy2pzP8MAr56wY', {action: 'inquiry'}).then(function(token) {
        $("#contact_form form").append('<input type="hidden" name="rctoken" value="' + token + '"/>');
      })
    });
</script>
<div class="body-content-main">
<?	if ($listing = current($_DATA['listing']['items'])) {

	define('IS_RENT', 2 == $listing['listing_type_id']);

	define('IS_ACTUAL_LISTING', $_SITE['config']['ACTUAL_LISTING_STATUS_ID'] == $listing['listing_status_id']);

	define('IS_APARTMENT_TYPE', $_SITE['config']['APARTMENT_TYPE_ID'] == $listing['property_type_id']); 
	define('IS_APARTMENT', $_SITE['config']['APARTMENT_SUBTYPE_ID'] == $listing['property_subtype_id']); 
	define('IS_ROOM', $_SITE['config']['ROOM_SUBTYPE_ID'] == $listing['property_subtype_id']); 
	define('IS_HOUSE_TYPE', $_SITE['config']['HOUSE_TYPE_ID'] == $listing['property_type_id']); 
	define('IS_HOUSE', IS_HOUSE_TYPE and $_SITE['config']['LAND_PLOT_SUBTYPE_ID'] != $listing['property_subtype_id']); 
	define('IS_PART_OF_HOUSE', $_SITE['config']['PART_OF_HOUSE_SUBTYPE_ID'] == $listing['property_subtype_id']); 

	define('IS_DEFAULT_COUNTRY', $_SITE['config']['DEFAULT_COUNTRY_ID'] == $listing['loc_country_id']);
	
	define('USD_RATE', $_DATA['currency']['items']['usd']['rate']);
?>
    <article>
        <div class="detail-title">
            <h1><?=$title = make_title($listing, true)?></h1>
            <?	define('SEO_PAGE_TITLE', $title); ?>
            <div class="detail-title-location">
            	<? out_location($listing) ?>
			</div>
        </div>
        <div class="detail-highlights g-clearfix">
            <ul>
                <?	if (IS_APARTMENT_TYPE) { ?>
		                <li class="detail-highlights-item p-item-amenities-plan"><?=$listing['property_subtype_id'] == $_SITE['config']['ROOM_SUBTYPE_ID']?'??????????????':($listing['bedrooms']?$listing['bedrooms'] . '-??????????????????':'????????????')?></li>
				<?	} else if (IS_HOUSE_TYPE) { ?>
		                <li class="detail-highlights-item p-item-amenities-house"><?=$listing['floor_count'] . ' ' . text_format_quantity_ru($listing['floor_count'], array('????????', '??????????', '????????????'))?></li>
				<?	} ?>
                <li class="detail-highlights-item p-item-amenities-area"><?=$listing['area_total']?> ??<sup>2</sup></li>
                <li class="detail-highlights-item detail-highlights-price">
                    <?=my_number_format($listing['price'], $_SITE['locale'])?> <span class="detail-highlights-price-currency"><?=$listing['currency_id_lookup']?></span>
                <?	if ('' === $listing['currency_id']) { // rub ?>
	                    <span class="detail-highlights-price-usd">($ <?=my_number_format($listing['price'] / USD_RATE, $_SITE['locale'])?>)</span>
                <?	} ?>
                </li>
            </ul>
        </div>
    <?	// don't show images for listings imported from from cian as they are gone
        if (!$listing['agent_source'] and isset($_DATA['listing_image']) or isset($_DATA['listing_video'])) { ?>
        <div class="detail-gallery">
        <?	if (isset($_DATA['listing_image']) and isset($_DATA['listing_video'])) { ?>
            <div class="detail-gallery-bookmarks g-clearfix">
                <a href="javascript:;" id="bookmarks_gallery" class="detail-gallery-bookmarks-item detail-gallery-bookmarks-item-active">????????????????????</a>
                <a href="javascript:;" id="bookmarks_video" class="detail-gallery-bookmarks-item">??????????</a>
            </div>
        <?	} 
			if (isset($_DATA['listing_image'])) { ?>
            <div id="detail_gallery_gallery">
                <div class="detail-gallery-view flexslider">
                    <a href="#" class="detail-gallery-zoom"></a>
                    <ul class="slides">
                    <?	foreach ($_DATA['listing_image']['items'] as &$image) { ?>
                            <li>
                                <img src="<?=$image['img_src']?>" data-src-big="<?=$image['img_src_original']?>" alt="<?=$title?> ??? ???????? <?=++$n_foto?>">
                            </li>
                    <?	}
						unset($image); ?>
                   </ul>
                </div>
            <?	if (count($_DATA['listing_image']['items']) > 1) { ?>
                <div class="detail-gallery-thumbs flexslider">
                    <ul class="slides">
                    <?	foreach ($_DATA['listing_image']['items'] as &$image) { ?>
                            <li>
                                <img src="<?=$image['img_src_thumb']?>" alt="">
                            </li>
                    <?	}
						unset($image); ?>
                    </ul>
                </div>
            <?	} ?>
            </div>
        <?	}
			if (isset($_DATA['listing_video'])) { 
				// ! only one video so far
				$listing_video = current($_DATA['listing_video']['items']); ?>
                <div class="detail-gallery-video" id="detail_gallery_video" style="display: none;">
            <?  if ($listing_video['video_url']) {
                    if (strpos($listing_video['video_url'], 'youtube.com')) {
                        $youtube_code = current(explode('&', next(explode('?v=', $listing_video['video_url']))));
                        $video_embed_url = 'https://www.youtube.com/embed/' . $youtube_code;
                    } else {
                        $video_embed_url = $listing_video['video_url'];
                    } ?>
                    <iframe width="<?=$listing_video['w']?$listing_video['w']:730?>" height="<?=$listing_video['h']?$listing_video['h']:365?>" src="" data-src="<?=$video_embed_url?><?=false===strpos($video_embed_url, '?')?'?':'&'?>rel=0" frameborder="0" allowfullscreen=""></iframe>
            <?  } else { ?>
                    <video style="background: transparent url('<?=$listing_video['poster_img_src']?>') 50% 50% / cover no-repeat" preload="none" controls>
                        <source src="<?=$listing_video['video_src_mp4']?>" type="video/mp4">
                        <source src="<?=$listing_video['video_src_webm']?>" type="video/webm">
                    </video>
        <?      } ?>
                </div>
        <?  } ?>
        </div>
	<?	} ?>
        <div class="detail-overview g-clearfix">
        <?  if ($listing['agent_source']) { ?>
                <dl class="detail-overview-left">
                    <dt class="detail-overview-left-image">
                        <img src="<?=$listing['img_src']?>" alt="">
                    </dt>
                </dl>
        <?  } ?>
            <dl class="detail-overview-left">
                <dt>????????????</dt>
                	<dd class="detail-overview-available detail-overview-main">
                    <?	if (IS_ACTUAL_LISTING) { ?>
							<?=IS_RENT?'??????????????':'??????????????????'?>
                    <?	} else { ?>
                    	<span class="g-error">
                    		?????????????????????? ?????????? ???? ??????????????????????????
                    	</span>
                    <?	} ?>
                    </dd>
                <dt>??????</dt>
                	<dd class="detail-overview-main">
                    <?	if (IS_APARTMENT) { ?>
                    		<?=$listing['property_subtype_id'] == $_SITE['config']['ROOM_SUBTYPE_ID']?'??????????????':($listing['bedrooms']?$listing['bedrooms'] . '-?????????????????? ????????????????':'????????????')?>
                    <?	} else if (IS_PART_OF_HOUSE) { ?>
                    		?????????? <?=$listing['floor_count']?$listing['floor_count'] . '-????????????????':''?> ????????
                    <?	} else if (IS_HOUSE) { ?>
                    		<?=$listing['floor_count']?$listing['floor_count'] . '-??????????????':''?> <?=$listing['property_subtype_id_lookup'];?>
                    <?	} else { ?>
                    		<?=$listing['property_subtype_id_lookup'];?>
                    <?	} ?>
                    </dd>
                <dt>????????</dt><dd class="detail-overview-main"><?=my_number_format($listing['price'], $_SITE['locale'])?> <?=$listing['currency_id_lookup']?></dd>
            <?	if (!IS_DEFAULT_COUNTRY) { ?>
	                <dt>????????????</dt><dd><?=$listing['loc_country_id_lookup']?></dd>
			<?	} ?>
            <?	if (!$listing['is_region_center']) { ?>
	                <dt>????????????</dt><dd><?=$listing['loc_region_id_lookup']?></dd>
			<?	} ?>
            <?	if ($listing['loc_road_id']) { ?>
                <dt>??????????</dt><dd><?=$listing['loc_road_id_lookup']?></dd>
            <?	} ?>
            <?	if ($listing['loc_city_id']) { ?>
	                <dt>??????????</dt><dd><?=$listing['loc_city_id_lookup']?><?=$listing['loc_city_district_id']?', ' . $listing['loc_city_district_id_lookup']:''?></dd>
	            <?	if ($listing['loc_metro_id']) { ?>
    	            <dt>??????????</dt><dd><?=out_metro_w_distance($listing)?></dd>
		        <?	}
				} ?>
            <?	if ($listing['loc_project_id']) { ?>
                <dt>????????????????</dt><dd><?=$listing['loc_project_id_lookup']?></dd>
            <?	} ?>
            <?	if ($listing['address']) { ?>
                <dt>??????????</dt><dd><?=$listing['address']?></dd>
            <?	} ?>
            <?	if ($listing['building_type_id']) { ?>
                <dt>?????? ????????</dt><dd><?=$listing['building_type_id_lookup']?></dd>
            <?	} ?>
            <?	if ($listing['floor_number']) { ?>
                <dt>????????</dt><dd><?=$listing['floor_number']?>-?? ????????<?=$listing['floor_count']?' ' . $listing['floor_count'] . '-???????????????? ????????':''?></dd>
            <?	} ?>
                <dt>??????????????</dt>
			<?	if (IS_APARTMENT) { ?>
                    <dd>
                        <dl>
                            <dt>??????????</dt><dd><?=$listing['area_total']?> ??<sup>2</sup></dd>
                        <?	if ($listing['area_living']) { ?>
                            <dt>??????????</dt><dd><?=$listing['area_living']?> ??<sup>2</sup></dd>
                        <?	} ?>
                        <?	if ($listing['area_room_details']) { ?>
                            <dt>??????????????</dt><dd><?=$listing['area_room_details']?>&nbsp;??<sup>2</sup></dd>
                        <?	} ?>
                        <?	if ($listing['area_kitchen']) { ?>
                            <dt>??????????</dt><dd><?=$listing['area_kitchen']?> ??<sup>2</sup></dd>
                        <?	} ?>
                        </dl>
                    </dd>
            <?	} else if (IS_HOUSE and $listing['area_plot']) { ?>
                    <dd>
                        <dl>
                            <dt>??????</dt><dd><?=$listing['area_total']?> ??<sup>2</sup></dd>
                            <dt>??????????????</dt><dd><?=$listing['area_plot']?> <?=text_format_quantity_ru($listing['area_plot'], array('??????????', '??????????', '??????????'))?></dd>
                        </dl>
                    </dd>
			<?	} else { ?>
            		<dd><?=$listing['area_total']?> ??<sup>2</sup></dd>
            <?	} ?>
            <?	if (IS_APARTMENT or IS_ROOM) { 
					if ($listing['windows_view']) { ?>
                    	<dt>????????</dt><dd><?=$listing['windows_view_lookup']?></dd>
                <?	}
					if ($listing['balcony_details']) { ?>
	                    <dt>????????????</dt><dd><?=$listing['balcony_details']?></dd>
                <?	}
					if ($listing['bathrooms_details']) { ?>
	                    <dt>??????????????</dt><dd><?=$listing['bathrooms_details']?></dd>
                <?	}
					if ($listing['lift_details']) { ?>
	                    <dt>????????</dt><dd><?=$listing['lift_details']?></dd>
                <?	} ?>
                    <dt>???????? ??<sup>2</sup></dt><dd><?=my_number_format(ceil($listing['price'] / $listing['area_total']), $_SITE['locale'])?> <?=$listing['currency_id_lookup']?> / ??<sup>2</sup></dd>
            <?	} ?>
            </dl>
            <div class="detail-overview-right">
            <?	if ($listing['amenity_id']) {
					$amenities = explode(', ', $listing['amenity_id_lookup']); ?>
                    <ul>
					<?	foreach ($amenities as &$amenity) { ?>
                            <li><?=$amenity?></li>
                    <?	}
                        unset($amenity); ?>
                    </ul>
            <?	} ?>
            <?	if ($listing['market_type_id'] or $listing['deal_type_id'] or $listing['mortgage_available']) { ?>
                    <ul class="detail-overview-extra">
                    <?	if ($listing['market_type_id']) { ?>
                        	<li><?=$listing['market_type_id_lookup']?></li>
                    <?	}
						if ($listing['deal_type_id']) { ?>
                        	<li><?=$listing['deal_type_id_lookup']?></li>
                    <?	}
                        if ($listing['mortgage_available']) { ?>
                        	<li>
                                ???????????????? ??????????????
                                <a href="<?=$_SERVER['REQUEST_URI']?>#calc" class="detail-price-calc" title="?????????????????? ??????????????????????"></a>
                            </li>
                    <?	} ?>
                    </ul>
            <?	} ?>
            </div>
        </div>
        <div class="detail-desc <?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>">
            <?=$listing['body']?>
            <?	define('SEO_DESCRIPTION', text_left_cut(strip_tags(str_replace(array('&nbsp;', "\n"), ' ', $listing['body'])), 250, true)); ?>
        </div>
    <?	if ($listing['map_latlng']) { ?>
        <div class="detail-map">
            <script>
                function initialize() {
                    var myLatlng = new google.maps.LatLng(<?=$listing['map_latlng']?>);
                    var mapOptions = {
                        center: myLatlng,
                        zoom: 15,
                        scrollwheel: false
                    }
                    var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map
                    });
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            <div class="g-title">????????????????????????</div>
            <div id="map_canvas"></div>
        </div>
    <?  } 
        if ($listing['mortgage_available']) { ?>
        <div id="calc" class="detail-calc-iframe detail-folded">
            <div class="g-title">
                <div class="detail-folded-control">
                    <a href="#">?????????????????? ??????????????????????</a>
                </div>
            </div>
            <div class="detail-folded-body">
                <iframe id="calc-iframe" width="100%" height="300" style="width:1px; min-width: 100%;" scrolling="no" src="https://calcus.ru/kalkulyator-ipoteki?embed=1&currency_text=<?=$listing['currency_id_lookup']?>&cost=<?=$listing['price']?>" frameborder="0"></iframe>
                <div style="margin-top:5px; font-size: 0.9em; color:#999">?????????????????? ?????????????????????? ???????????????????????? ???????????? <a href="https://calcus.ru" target="_blank">calcus.ru</a></div>
                <script>
                    window.addEventListener('message', function(event) {
                        if(height = event.data['height']) {
                            document.getElementById('calc-iframe').style.height =  height + 'px'
                        }
                    })
                </script>
            </div>
        </div>
    <?  } ?>
    </article>
    <div class="detail-order">
        <div class="g-title">?????????????????? ?? ?????????????? ???? ???????????? ?????????? ??????????????????????</div>
        <? $tel = ($listing['contact_phone']?$listing['contact_phone']:$_SITE['settings']['phone']); ?>
        <div class="detail-order-phone">???? ???????????????? <span class="detail-order-phone-number"><a href="tel:<?=$tel?>"><?=$tel?></a></span></div>
   	    <div class="detail-order-message">?????? ???????????????? ???????? ???????????????????? ????????????, ?? ???? ?????? ????????????????????</div>
        <div id="contact_form">
            <?  out_contact_form($listing['id'], true); ?>
        </div>
    </div>
<?	} ?>
</div>
<?
out_aside();
}
?>