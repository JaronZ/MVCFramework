<?php
abstract class Controller {
	public function model(string $model, array $params = []){
		$model = ucwords($model)."Model";
		require_once(APP_ROOT."/models/".$model.".php");
		return new $model(...$params);
	}

	public function view(string $view, array $data = []){
		$body = APP_ROOT."/views/".$view.".php";
		if(file_exists($body)){
			require_once(APP_ROOT."/views/shared/layout.php");
			return;
		}
		die("View does not exist");
	}
}