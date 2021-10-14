<?php
Router::default(function(){
	echo "default page";
});
Router::get("/login/", [HomeController::class, "login"]);