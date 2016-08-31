<?php

namespace Student\Model;
use Think\Model;

class BookModel extends Model {

    public function __construct() {
        $this->_db_book = M('book');
        $this->_db_buy = M('buy');
    }

    public function booksCanBuy() {
        return $this->_db_book->where('can_book=1')->select();
    }

    public function buyBook($student_number, $book_id) {
        $data['book_id'] = $book_id;
        $data['student_number'] = $student_number;
        $condition = $this->_db_buy->where($data)->find();
        $data['status'] = 0;
        return $this->_db_book->add($data);
    }
}