<?php

class PostController extends ControllerBase {

    public function indexAction() {

    }

    public function mypage_indexAction() {
        // 記事一覧の表示
        $this->view->posts          = Posts::find();
        $this->view->categories     = Categories::find();
        // $this->view->sub_categories = SubCategories::find();
    }


    /* Ajaxメソッド ------------------------------------*/

    /* 新規投稿モーダルの「投稿する」ボタン押下時の処理 */
    public function addAction() {

        // HTTPメソッドのチェック
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "post",
                    "action"     => "mypage_index",
                ]
            );
        }
        // require(BASE_PATH . "/app/Lib/DEBUG/ChromePhp.php");
        // ChromePhp::log($this->request->getPost());

        // ①記事をDBへ保存する
        $post = new Posts();
        $post->title            = $this->request->getPost("title");
        $post->body             = $this->request->getPost("body");
        if ($this->request->getPost("category_id")) {
            $post->category_id      = $this->request->getPost("category_id");
        }
        if ($this->request->getPost("sub_category_id")) {
            $post->sub_category_id  = $this->request->getPost("sub_category_id");
        }

        $post->created  = date('Y-m-d H:i:s');
        $post->modified = date('Y-m-d H:i:s');


        if ($post->save()) {

        } else {
            $messages = $post->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全記事を再取得し画面へ渡す
        $posts = Posts::find();
        $array_posts = $this->getArrayPosts($posts);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($array_posts);
    }

    /* 記事編集モーダルの「保存する」ボタン押下時の処理 */
    public function editAction() {
        
        // HTTPメソッドのチェック
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "post",
                    "action"     => "mypage_index",
                ]
            );
        }
        // ①記事の変更をDBへ保存する        
        $post = Posts::findFirstById($this->request->getPost("id"));
        $post->title = $this->request->getPost("title");
        $post->body  = $this->request->getPost("body");
        if ($this->request->getPost("category_id")) {
            $post->category_id      = $this->request->getPost("category_id");
        }
        if ($this->request->getPost("sub_category_id")) {
            $post->sub_category_id  = $this->request->getPost("sub_category_id");
        }
        $post->modified = date('Y-m-d H:i:s');

        if ($post->save()) {

        } else {
            $messages = $post->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全記事を再取得し画面へ渡す
        $posts = Posts::find();
        $array_posts = $this->getArrayPosts($posts);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($array_posts);
    }

    /* カテゴリーidをもとにサブカテゴリーを取得し返却するメソッド */
    public function getSubCategoryAction() {
        $sub_categories = SubCategories::find([
            "conditions" => "category_id = :category_id:",
            "bind"       =>[
                "category_id"     => $this->request->getPost("category_id"),
            ]
        ]);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($sub_categories);
    }

    /* privateメソッド ------------------------------------*/

    /* $postsを配列にし、リレーションによって取得したカテゴリー名とサブカテゴリー名を追加して返すメソッド */
    private function getArrayPosts($posts) {
        $array_posts = array();
        for ($i = 0; $i < count($posts); $i++) {
            $array_post = get_object_vars($posts[$i]);
            $array_post["category_name"]     = $posts[$i]->getCategories()->category_name;
            $array_post["sub_category_name"] = $posts[$i]->getSubCategories()->sub_category_name;

            $array_posts[$i] = $array_post;
        }

        return $array_posts;
    }
}
