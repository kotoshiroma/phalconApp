<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function initialize() {
        //configファイルから各値を取得
        define('CLIENT_ID',              $this->config->yahoo_id->client_id);
        define('CLIENT_SECRET',          $this->config->yahoo_id->client_secret);
        define('AUTHORIZATION_ENDPOINT', $this->config->yahoo_id->authorization_endpoint);
        define('CALLBACK_URI',           $this->config->yahoo_id->callback_url);
        define('TOKEN_ENDPOINT',         $this->config->yahoo_id->token_endpoint);
        define('ATTRIBUTE_ENDPOINT',     $this->config->yahoo_id->attribute_endpoint);
        define('REDIRECT_URL',           $this->config->yahoo_id->redirect_url);
    }

    public function indexAction()
    {

    }

    public function signUpAction() {

        if ($this->request->isPost()) {

            $user = new Users();
            $user->name     = $this->request->getPost("name");
            $user->email    = $this->request->getPost("email");
            $user->password = $this->request->getPost("password");
            $is_success = $user->save();
    
            if ($is_success) {
                $this->flashSession->success("Thanks for registering!");
                $this->dispatcher->setParam("user", $user);
                $this->dispatcher->forward([
                    "controller" => "user",
                    "action" => "mypage",
                ]);

            } else {
                $this->flash->error("Sorry, the following problems were generated: ");                
                $messages = $user->getMessages();
    
                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>"; //カンマでいいのか
                    // echo $message->getMessage()."<br/>";
                }
            }
        }
    }

    public function signInAction() {
        if ($this->request->isPost()) {
            Users::findFirst([
                "conditions" => "email = ?email AND password = "
            ]);
        }
    }

    public function mypageAction() {
        $this->view->user = $this->dispatcher->getParam("user");
    }

    // YahooのAuthorizationエンドポイントへリダイレクト(認可コード取得のため)
    public function redirect_to_yahooAuthEndPointAction() {

        // リクエストパラメータを添字配列に格納
        $req_param = [
            'response_type' . "=" . 'code',
            'client_id'     . "=" . CLIENT_ID,
            'redirect_uri'  . "=" . CALLBACK_URI,
            'scope'         . "=" . 'openid profile email'
        ];

        $query = implode("&", $req_param);
        $url = sprintf("Location:%s?%s", AUTHORIZATION_ENDPOINT, $query);
        // リダイレクト
        header($url);
        exit;        
    }

    // Yahooからのコールバックアクション
    public function yahoo_callbackAction() {
        
        require_once('Net/URL2.php');
        require_once('HTTP/Request2.php');

        // 認可コードをもとに、アクセストークンを取得する
        $access_token = $this->get_access_token($_REQUEST['code']);
        // アクセストークンをもとに、ユーザ情報を取得する 
        $userinfo     = $this->get_userinfo($access_token);
        // Yahooから取得したメールアドレスをもとに、テーブル検索する
        $user = Users::findFirstByEmail($userinfo->email);
        
        if (!$user) {
            // レコードが存在しない場合(未登録の場合)、新規登録フォームへ
            $this->dispatcher->forward([
                "controller" => "user",
                "action"     => "signUp",
            ]);

        } else {
            // レコードが存在する場合(既存会員の場合)、ユーザーページへ
            $this->dispatcher->setParam("user", $user);
            $this->dispatcher->forward([
                "controller" => "user",
                "action"     => "mypage",
            ]);
        }
    }


/* ----------------------------------------------------------------------------------------- */

    /* 認可コードをもとに、アクセストークンを取得する */
    public function get_access_token($auth_code) {

        // ヘッダとパラメータをセット
        $req = new HTTP_Request2();
        $req->setUrl(TOKEN_ENDPOINT);
        $req->setMethod(HTTP_Request2::METHOD_POST);

        $req->setHeader('Connection',     'keep-alive');
        $req->setHeader('Content-Type',   'application/x-www-form-urlencoded');
        $req->setHeader('Accept-Charset', 'UTF-8');

        $req->addPostParameter('client_id',     CLIENT_ID);
        $req->addPostParameter('client_secret', CLIENT_SECRET);
        $req->addPostParameter('code',          $auth_code);
        $req->addPostParameter('redirect_uri',  CALLBACK_URI);
        $req->addPostParameter('grant_type',    'authorization_code');

        // リクエスト
        $res = $req->send();

        // エラー
        if ($res->getStatus() != 200) {
            error_log('HttpRequestError: get_access_token(): '.$res->getStatus());
            echo 'HttpRequestError: get_access_token(): '.$res->getStatus();
            exit;
        }
        // 成功
        $res_body = json_decode($res->getBody());
        
        /*
        TODO:IDトークンの検証

        $id_token = explode(".", $res_body->id_token);
        list($signature, $payload, $header) = $id_token;
        $payload = json_decode(base64_decode($payload));
        */
        
        $access_token = $res_body->access_token;
        return $access_token;
    }

    /* アクセストークンをもとに、ユーザ情報を取得する */
    public function get_userinfo($access_token) {
        $req = new HTTP_Request2();
        $req->setUrl(ATTRIBUTE_ENDPOINT);
        $req->setMethod(HTTP_Request2::METHOD_GET);

        $req->setHeader('Authorization', 'Bearer '.$access_token);
        $req->setHeader('Accept-Charset', 'UTF-8');

        // リクエスト
        $res = $req->send();

        // エラー
        if ($res->getStatus() != 200) {
            error_log('HttpRequestError: get_access_token(): '.$res->getStatus());
            echo 'HttpRequestError: get_access_token(): '.$res->getStatus();
            exit;
        }
        // 成功
        $userinfo = json_decode($res->getBody());
        return $userinfo;
    }
}