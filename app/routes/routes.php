<?php
Router::get("/", [HomeController::class, "index"]);
Router::get("/login/", [HomeController::class, "login"]);