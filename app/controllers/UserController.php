<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    //configファイルから各値を取得
    // const CLIENT_ID              = $this->config->yahoo_id->client_id;
    // const CLIENT_SECRET          = $this->config->yahoo_id->client_secret;
    // const AUTHORIZATION_ENDPOINT = $this->config->yahoo_id->authorization_endpoint;
    // const CALLBACK_URI           = $this->config->yahoo_id->callback_url;
    // const TOKEN_ENDPOINT         = $this->config->yahoo_id->token_endpoint;
    // const REDIRECT_URL           = $this->config->yahoo_id->redirect_url;

    // require_once('Net/URL2.php');
    // require_once('HTTP/Request2.php');

    public function initialize() {
        define('CLIENT_ID',              $this->config->yahoo_id->client_id);
        define('CLIENT_SECRET',          $this->config->yahoo_id->client_secret);
        define('AUTHORIZATION_ENDPOINT', $this->config->yahoo_id->authorization_endpoint);
        define('CALLBACK_URI',           $this->config->yahoo_id->callback_url);
        define('TOKEN_ENDPOINT',         $this->config->yahoo_id->token_endpoint);
        define('REDIRECT_URL',           $this->config->yahoo_id->redirect_url);
    }

    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new Users();

        // saveメソッドの仕様を確認すること
        $is_success = $user->save(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        if ($is_success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";
            $messages = $user->getMessage();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>"; //カンマでいいのか
                // echo $message->getMessage()."<br/>";
            }
        }

        $this->view->disable();
    }

    public function signIn_by_yahooIdAction() {

        // リクエストパラメータを添字配列に格納
        $req_param = [
            'response_type' . "=" . 'code',
            'client_id'     . "=" . CLIENT_ID,
            'redirect_uri'  . "=" . CALLBACK_URI,
            'scope'         . "=" . 'openid profile email' // openidとemailの2つを指定
        ];

        $query = implode("&", $req_param);
        $url = sprintf("Location:%s?%s", AUTHORIZATION_ENDPOINT, $query);
        // Yahooの Authorizationエンドポイントへリダイレクト
        header($url);
        exit;        
    }

    // public function yahoo_callback() {
    public function yahoo_callbackAction() {
        
        require_once('Net/URL2.php');
        require_once('HTTP/Request2.php');

        // リクエストのヘッダとパラメータをセット
        $req = new HTTP_Request2();
        $req->setUrl(TOKEN_ENDPOINT);
        $req->setMethod(HTTP_Request2::METHOD_POST);

        $req->setHeader('Connection',     'keep-alive');
        $req->setHeader('Content-Type',   'application/x-www-form-urlencoded');
        $req->setHeader('Accept-Charset', 'UTF-8');

        $req->addPostParameter('client_id',     CLIENT_ID);
        $req->addPostParameter('client_secret', CLIENT_SECRET);
        $req->addPostParameter('code',          $_REQUEST['code']);
        $req->addPostParameter('redirect_uri',  CALLBACK_URI);
        $req->addPostParameter('grant_type',    'authorization_code');

        // リクエスト
        try {
            $res = $req->send();
            // var_dump($res->getBody());
            // exit;

            // エラー
            if ($res->getStatus() != 200) {
                error_log('HttpRequestError: yahoo_callback(): '.$res->getStatus());
                echo 'HttpRequestError: yahoo_callback(): '.$res->getStatus();
                return false;
            }
            // 成功。トークンを取得する
            $res_body = json_decode($res->getBody());
            $access_token = $res_body->access_token;
            // get_userinfo_by_yahooAPI($access_token);
            // $userinfo = get_userinfo_by_yahooApiAction($access_token);
            // $userinfo = get_userinfo_by_yahooApiAction();

            $userinfo = $this->get_userinfoAction();
            // return xdebug_print_function_stack('stop here!');
            // $userinfo = "userinfo";
            echo $userinfo;
            exit;

            // TODO:IDトークンの検証
            $id_token = explode(".", $res_body->id_token);
            list($signature, $payload, $header) = $id_token;
            $payload = json_decode(base64_decode($payload));

            var_dump($res_body);
            echo "<br>";
            var_dump($access_token);
            echo "<br>";
            var_dump($id_token);
            echo "<br>";
            var_dump($payload);
            exit;

        } catch (\HTTP_Request2_Exception $e) {
            $err_msg = $this->getMessageByHttpRequest2ExceptionCode($e->getCode());
            error_log('HTTP_Request2_Exception: ' . $err_msg);
            exit;
        }
    }

    // public function get_userinfo_by_yahooApiAction($access_token) {
    // public function get_userinfo_by_yahooApiAction() {
    // public function get_userinfoAction() {
    public function get_userinfoAction() {



        return 'userinfo';

    }
}