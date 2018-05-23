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
}