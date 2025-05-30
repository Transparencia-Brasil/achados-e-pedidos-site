<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class UCaptchaHelper extends Helper
{
    public function CaptchaScript()
    {
         $siteKey = Configure::read("Recaptcha.Key");

        echo '<script src="https://www.google.com/recaptcha/enterprise.js?render='. $siteKey . '"></script>

            <script>
                grecaptcha.enterprise.ready(function() {
                    grecaptcha.enterprise.execute("'. $siteKey . '", {action: "submit"}).then(function(token) {
                        document.getElementById("recaptcha-token").value = token;
                    });
                });
            </script>
            ';
    }

    public function CaptchaTokenInput() {
        echo '<input type="hidden" name="recaptcha_token" id="recaptcha-token">';
    }
}
?>