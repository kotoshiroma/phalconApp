<?php

use Phalcon\Mvc\Model;

class SubCategories extends Model {

    public $id;
    public $sub_category_name;
    public $category_id;
    public $created;
    public $modified;
    public $deleted;

    public function initialize() {

        $this->setSource('sub_categories');

        $this->hasMany(
            "id",
            "Posts",
            "sub_category_id"
        );
        $this->belongsTo(
            "category_id",
            "Categories",
            "id"
        );
    }
}
