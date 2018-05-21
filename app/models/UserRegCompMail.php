<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple as ViewSimple;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserRegCompMail extends Mail {

    // 引数に取ったテンプレートで、メールを送信する
    public function send($mail_template) {
        
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
            $mail->Subject     = 'ユーザ登録完了';
            $mail->isHTML(true);
            // $mail->Body        = $this->getTemplate();
            $mail->Body        = $mail_template;
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

        // $config = new ConfigIni(BASE_PATH . "/app/config/config.ini");
        
        // $view = new View();
        // $view->setPartialsDir(BASE_PATH . "/app/views/mail");
        // $content = $view->getPartial('/user_reg_comp');
        // return $content;     
        // $view->setDI(new Phalcon\DI\FactoryDefault());
        // $view->setViewsDir($config->application->viewsDir);
        // $view->setViewsDir(BASE_PATH . "/app/views");
        // $view->registerEngines([
        //     '.volt'  => 'Phalcon\Mvc\View\Engine\Volt'
        // ]);
        // $view->start();
        // $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        // $view->render('mail', 'user_reg_comp');
        // $view->render('user', 'mail_user_reg_comp');
        // return $view->render('/mail/user_reg_comp');
        // return $view->render('/mail/user_reg_comp');
        // $view->finish();
        // return $view->getContent();

        // $template = $view->getRender('mail', 'user_reg_comp');
        // $template = $view->getRender('user', 'mail_user_reg_comp');
        // return $template;
    }
}

