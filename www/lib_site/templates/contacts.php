<?
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/lib');

require "mail.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$params = get_post();

    if (!captcha_validate($params['rctoken'])) {
        exit;
    }

	$from_property = ($_SITE['config']['MAIL_CONTENT_HTTP_HOST'] . '/contacts/' != $_SERVER['HTTP_REFERER']);

	if ($from_property) {
		if (!$params['name']) $error[1] = 'Не заполнено обязательное поле.';
		if (!$params['phone']) $error[2] = 'Не заполнено обязательное поле.';
		
	
		//if (!$params['email']) $error[2] = 'Не заполнено обязательное поле.';
		//else if (!valid_email($params['email'])) $error[2] = 'Неправильно указан адрес электронной почты.';
	}

	//if (!$params['message']) $error[3] = 'Не заполнено обязательное поле.';

	if (!$error) {
		$mail_message = $params['message'];
		if ($from_property) {
			$property = $params['property']?$params['property']:$_SERVER['HTTP_REFERER'];
			$mail_message = "От: " . $params['name'] . "\nТелефон: " . $params['phone'] .  ($property?"\nИнтересует объект (ID=" . $params['property_id'] . '): ' . $property:'') . "\n\n"
				. $mail_message; // "От: " . $params['name'] . " (" . $params['email'] . ")" ...
		}
		$mail_recepients = make_mail_recepients($_SITE['settings']['email_feedback']);
		foreach ($mail_recepients as &$rcpt) {
			if (true !== @mail_send($rcpt, 'Сообщение с сайта mskkey.ru', $mail_message)) {
				$error[0] = 'Непредвиденная ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз чуть позже.';
			}
		}
		unset($rcpt);

		if (!$error) {
			$message = 'Спасибо! Ваше сообщение принято.';
		} else {
			$message = $error[0];
		}
		unset($params); ?>
<?	}
}
?>
<script src="https://www.google.com/recaptcha/api.js?render=6Ld2xacUAAAAAKpjYm3t5GzLCuVy2pzP8MAr56wY"></script>
<script>
    grecaptcha.ready(function() {
      grecaptcha.execute('6Ld2xacUAAAAAKpjYm3t5GzLCuVy2pzP8MAr56wY', {action: 'inquiry'}).then(function(token) {
        $("#contact_form form").append('<input type="hidden" name="rctoken" value="' + token + '"/>');
      })
    });
</script>
<div class="body-content-main <?=$_SITE['config']['CONTENT_CSS_CLASS_NAME']?>">
	<style>
		.body-content-main p {margin-bottom:  5px !important;}
		.contact-map {margin-top: 2em;}
    </style>
    <article>
        <h1>Контакты</h1>
        <h3>Агентство недвижимости "МСК ключ"</h3>
        <p>Телефон: <span class="detail-order-phone-number"><a href="tel:<?=$_SITE['settings']['phone']?>"><?=$_SITE['settings']['phone']?></a></span> &nbsp; <span class="detail-order-phone-number"><a href="tel:<?=$_SITE['settings']['phone_mobile']?>"><?=$_SITE['settings']['phone_mobile']?></a></span></p>
        <p>Эл. почта: &nbsp;<span id="hm"></span></p>
        <p>Адрес: &nbsp;г. Москва, ул. Профсоюзная, д. 96</p>
    </article>
    <script>
        function initialize() {
            var myLatlng = new google.maps.LatLng(55.647459, 37.528016);
            var mapOptions = {
                center: myLatlng,
                zoom: 16,
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
    <div class="contact-map">
        <div id="map_canvas"></div>
    </div>
</div>
<?
out_aside();
?>
