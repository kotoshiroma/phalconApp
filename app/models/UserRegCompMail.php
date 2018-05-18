<?php

use Phalcon\Mvc\View;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserRegCompMail extends Mail {


    public function send() {
        
        // 設定ファイル読み込み
        $config = new ConfigIni(BASE_PATH . "/app/config/config.ini");
        // ライブラリ読み込み
        require(BASE_PATH . "/vendor/autoload.php");

        $mail = new PHPMailer(true); // trueを渡すと例外がスローされる
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host        = $config->mail->host_server;
            $mail->Username    = $config->mail->username;
            $mail->Password    = $config->mail->password;
            $mail->SMTPAuth    = true;
            $mail->SMTPSecure  = 'tls';
            $mail->Port        = 587;

            // Recipients
            $mail->CharSet     = "UTF-8";
            $mail->Encoding    = "base64";
            $mail->setFrom($config->mail->from_address, $config->mail->from_user);
            $mail->addAddress('kotoshiroma@yahoo.co.jp'); //TODO:新規登録ユーザのアドレスを動的にセットする
            $mail->Subject     = 'ユーザ登録完了' . date("Y/m/d/H:i:s", time());
            // $mail->Body        = 'ユーザ登録完了しました！';
            $mail->isHTML(true);
            $mail->Body        = $this->getTemplate();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            exit;
        }
    }

    private function getTemplate() {

        $config = new ConfigIni(BASE_PATH . "/app/config/config.ini");
        
        $view = new View();
        $view->setViewsDir($config->application->viewsDir);
        $view->registerEngines([
            '.volt'  => 'Phalcon\Mvc\View\Engine\Volt'
        ]);
        $view->start();
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->render('mail', 'user_reg_comp');
        $view->finish();
        return $view->getContent();
    }
}

