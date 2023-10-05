<?php
namespace Phppot;

use Phppot\Captcha;

session_start();

require_once "./Model/Captcha.php";
$captcha = new Captcha();

$captcha_code = $captcha->getCaptchaCode(6);

$captcha->setSession('captcha_code', $captcha_code);

$imageData = $captcha->createCaptchaImage($captcha_code);
 print_r($_SESSION);
$captcha->renderCaptchaImage($imageData);

?>