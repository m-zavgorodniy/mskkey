<?
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/lib');

require "mail.php";

if (isset($_GET['success'])) {
    $message = 'Спасибо, мы получили ваше сообщение.<br>Мы ответим вам в ближайшее время на тот контакт, который вы нам оставили.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$params = get_post();

    if (!captcha_validate($params['rctoken'])) {
        exit;
    }

	$from_property = $params['from_property'];

    if (!$params['name']) $error[1] = 'Не заполнено обязательное поле Имя.';
	if ($from_property) {
		if (!$params['phone']) $error[2] = 'Не заполнено обязательное поле Телефон.';
	} else {
		if (!$params['phone'] && !$params['email']) $error[2] = 'Не заполнено обязательное поле Телефон или Email.';
		else if ($params['email'] !== '' && !valid_email($params['email'])) $error[2] = 'Ошибка в адресе электронной почты.';
    	if (!$params['message']) $error[3] = 'Не заполнено обязательное поле Сообщение.';
    }

	if (!$error) {
        $mail_message = "От: " . $params['name'] . "\nТелефон: " . $params['phone'] . (!$from_property?"\nEmail: " . $params['email'] :'')
        . ($from_property?"\nИнтересует объект (ID=" . $params['property_id'] . '): ' . ($params['property']?$params['property']:$_SERVER['HTTP_REFERER']):'')
        . "\nСообщение:\n" . $params['message'];

        $mail_recepients = make_mail_recepients($_SITE['settings']['email_feedback']);
		foreach ($mail_recepients as &$rcpt) {
			if (true !== @mail_send($rcpt, 'Сообщение с сайта mskkey.ru', $mail_message)) {
				$error[0] = 'Непредвиденная ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз чуть позже.';
			}
		}
		unset($rcpt);

		if (!$error) {
            header("Location: ?" . (isset($_GET['source'])?'source='.$_GET['source'].'&':'') . "success");
            exit;

		} else {
			$message = $error[0];
		}
		unset($params); ?>
<?	} else {
        $message = implode("<br>", $error);
    }
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
    <h1>Отправьте нам сообщение</h1>
    <div id="contact_form">
    <?  if (isset($message)) {
            print $message;
        } else {
            out_contact_form($listing['id']);
        } ?>
    </div>
</div>
<?
out_aside();
?>
