<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class ControllerBase extends Controller
{
    public $t;

    public function beforeExecuteRoute() {

        // ビューに、NativeArrayインスタンスを渡している
        // リクエスト単位で多言語対応する必要があるから、アクションのたびにgetTranslation()を実行する必要がある。
        $t = $this->getTranslation();
        $this->t = $t; 
        $this->view->t = $t;
        // $this->session->set("t", $t);
    }
    
    // NativeArrayインスタンス(「_()」メソッドを持つ)を返す
    protected function getTranslation() {
        $lang = $this->request->getBestLanguage();
        $translation_file = APP_PATH."/messages/".$lang.".php";
        
        if (file_exists($translation_file)) {
            require $translation_file;
        } else {
            //　デフォルト
            require APP_PATH."/messages/en.php";
        }
        
        return new NativeArray([
            "content" => $messages, // $messagesは、文字列変換用の連想配列
            ]);
        }
    }
