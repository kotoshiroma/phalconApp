<?php

use Phalcon\Mvc\Controller;

class CategoryController extends ControllerBase
{
    public function initialize() {
    }

    public function indexAction() {

        $this->view->categories = Categories::find();     
    }

    /* -- Ajaxメソッド ------------------------------------------------------- */
    public function addAction() {

        // ①カテゴリーをDBへ保存する
        $category = new Categories();
        $category->category_name = $this->request->getPost("category_name");
        $category->created  = date('Y-m-d H:i:s');
        $category->modified = date('Y-m-d H:i:s');

        if ($category->save()) {

        } else {
            $messages = $category->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全カテゴリーを再取得し画面へ渡す
        $categories = Categories::find();
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($categories);
    }

    public function editAction() {
        
        // ①カテゴリーをDBへ保存する        
        $category = Categories::findFirstById($this->request->getPost("id"));
        $category->category_name = $this->request->getPost("category_name");
        $category->modified = date('Y-m-d H:i:s');

        if ($category->save()) {

        } else {
            $messages = $category->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全カテゴリーを再取得し画面へ渡す
        $categories = Categories::find();
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($categories);
    }
}
