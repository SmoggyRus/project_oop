<?php
require_once "classes/Session.php";
session_start();

echo Session::flash("success");