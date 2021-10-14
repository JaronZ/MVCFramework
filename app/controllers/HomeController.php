<?php
class HomeController extends Controller {
	public function __construct(){
		
	}

	public function index(){
		$this->view("home/index", (new PageSettings())
			// ->addAuthorization("user")
			->setTitle("Home")
			->addHeader()
			->addFooter());
	}

	public function login(){
		
	}
}