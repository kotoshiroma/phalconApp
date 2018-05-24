<?php

class PostController extends ControllerBase {

    public function indexAction() {

    }

    public function mypage_indexAction() {
        // 記事一覧の表示
        $posts          = Posts::find();
        $categories     = Categories::find();
        $sub_categories = SubCategories::find();

        $this->view->posts          = $posts;
        $this->view->categories     = $categories;
        $this->view->sub_categories = $sub_categories;
    }


    /* Ajaxメソッド ------------------------------------*/

    // 「投稿する」ボタン押下時に、記事をDBへ保存した後、記事を再取得し画面へ渡す
    public function addAction() {

        $post = new Posts();
        $post->title            = $this->request->getPost("title");
        $post->body             = $this->request->getPost("body");
        // $post->category_id      = $this->request->getPost("body");
        // $post->sub_category_id  = $this->request->getPost("body");
        error_log($this->request->getPost());

        if ($post->save()) {

        } else {
            $messages = $post->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $posts = Posts::find();

        $array_posts = array();
        $i = 0;
        foreach ($posts as $post) {

            $array_post = get_object_vars($post);
            $array_post["category_name"]     = $post->getCategories()->category_name;
            $array_post["sub_category_name"] = $post->getSubCategories()->sub_category_name;

            $array_posts[$i] = $array_post;
            $i++;
        }
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($array_posts);
    }

    // 「保存する」ボタン押下時のDB保存処理
    public function edit() {

    }
}
