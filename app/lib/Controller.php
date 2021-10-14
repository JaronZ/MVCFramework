<?php
abstract class Controller {
	public final function view(string $view, ?PageSettings $settings = null, array $data = []){
		$settings ??= new PageSettings();
		$body = APP_ROOT."/views/".$view.".php";
		if(file_exists($body)){
			require_once(APP_ROOT."/views/shared/layout.php");
			return;
		}
		die("View does not exist");
	}
}