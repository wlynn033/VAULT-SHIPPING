<?php

use App\Support\Auth;

require_once __DIR__ . '/../app/bootstrap.php';

Auth::logout();

redirect('login.php');

