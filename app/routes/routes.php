<?php
Router::default([HomeController::class, "index"]);
Router::get("/login/", [HomeController::class, "login"]);