<?php

class PostController extends ControllerBase {

    public function indexAction() {

    }

    public function mypage_indexAction() {
        // 記事一覧の表示
        $posts = Posts::find();
        $this->view->posts = $posts;
    }


    /* Ajaxメソッド ------------------------------------*/

    // 「投稿する」ボタン押下時に、記事をDBへ保存した後、記事を再取得し画面へ渡す
    public function addAction() {

        $post = new Posts();
        $post->title = $this->request->getPost("title");
        $post->body  = $this->request->getPost("body");

        if ($post->save()) {
            
        } else {
            $messages = $post->getMessages();
    
            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $posts = Posts::find();
        // $posts_json = json_encode($posts);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($posts);
    }

    // 「保存する」ボタン押下時のDB保存処理
    public function edit() {

    }
}