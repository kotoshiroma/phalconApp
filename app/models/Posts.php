<?php

use Phalcon\Mvc\Model;

class Posts extends Model {

    public $id;
    public $title;
    public $body;
    public $category_id;
    public $sub_category_id;
    public $created;
    public $modified;
    public $deleted;


    public $category_name;
    public $sub_category_name;

    public function initialize() {

        $this->belongsTo(
            "category_id",
            "Categories",
            "id"
        );
        $this->belongsTo(
            "sub_category_id",
            "SubCategories",
            "id"
        );
    }
}
