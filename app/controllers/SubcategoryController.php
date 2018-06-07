<?php

use Phalcon\Mvc\Controller;

class SubcategoryController extends ControllerBase
{
    public function initialize() {
    }

    public function indexAction() {
        $this->view->sub_categories = SubCategories::find();   
        $this->view->categories     = Categories::find();   
    }

    /* -- Ajaxメソッド ------------------------------------------------------- */
    public function addAction() {

        // ①サブカテゴリーをDBへ保存する
        $sub_category = new SubCategories();
        $sub_category->sub_category_name = $this->request->getPost("sub_category_name");
        $sub_category->category_id       = $this->request->getPost("category_id");
        $sub_category->created  = date('Y-m-d H:i:s');
        $sub_category->modified = date('Y-m-d H:i:s');

        if ($sub_category->save()) {

        } else {
            $messages = $sub_category->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全サブカテゴリーを再取得し画面へ渡す
        $sub_categories = SubCategories::find();
        $array_sub_categories = $this->getArraySubCategories($sub_categories);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($array_sub_categories);
    }

    public function editAction() {
        
        // ①サブカテゴリーの変更をDBへ保存する        
        $sub_category = SubCategories::findFirstById($this->request->getPost("id"));
        $sub_category->category_id        = $this->request->getPost("category_id");
        $sub_category->sub_category_name  = $this->request->getPost("sub_category_name");
        $sub_category->modified = date('Y-m-d H:i:s');

        if ($sub_category->save()) {

        } else {
            $messages = $sub_category->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        // ②全サブカテゴリーを再取得し画面へ渡す
        $sub_categories = SubCategories::find();
        $array_sub_categories = $this->getArraySubCategories($sub_categories);
        $this->response->setContentType('application/json', 'UTF-8');
        return json_encode($array_sub_categories);
    }

    /* privateメソッド ------------------------------------*/

    /* $sub_categoriesを配列にし、リレーションによって取得したカテゴリー名を追加して返すメソッド */
    // TODO:モデルへの移動を検討する
    private function getArraySubCategories($sub_categories) {
        $array_sub_categories = array();
        for ($i = 0; $i < count($sub_categories); $i++) {
            $array_sub_category = get_object_vars($sub_categories[$i]);
            $array_sub_category["category_name"] = $sub_categories[$i]->getCategories()->category_name;

            $array_sub_categories[$i] = $array_sub_category;
        }

        return $array_sub_categories;
    }
}
