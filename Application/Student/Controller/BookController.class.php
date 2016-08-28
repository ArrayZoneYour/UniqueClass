<?php
namespace Student\Controller;
use Think\Controller;

class BookController extends Controller {

    public function BuyBook() {
        $books = D('Book')->booksCanBuy();
        $this->assign('books', $books);
        $this->display();
    }
}