<?php

namespace Student\Model;
use Think\Model;

class BookModel extends Model {

    public function __construct() {
        $this->_db_book = M('subject');
    }

    public function booksCanBuy() {
        return $this->_db_book->where('can_book=1')->select();
    }
}