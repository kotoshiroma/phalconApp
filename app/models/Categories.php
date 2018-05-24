<?php

use Phalcon\Mvc\Model;

class Categories extends Model {

    public $id;
    public $category_name;
    public $created;
    public $modified;
    public $deleted;

    public function initialize() {

        $this->hasMany(
            "id",
            "Posts",
            "category_id"
        );

        $this->hasMany(
            "id",
            "SubCategories",
            "category_id"
        );
    }
}