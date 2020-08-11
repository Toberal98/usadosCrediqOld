 <?php
  require_once('include/recaptchalib.php');
  $privatekey = "6Le9fdQSAAAAAHz4Gn9WIt-SvCBtOmndBZT2hs66";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if ($resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo "success";
  } else {
    // Your code here to handle a successful verification
    echo "C&oacute;digo incorrecto."; 
  }
  ?>