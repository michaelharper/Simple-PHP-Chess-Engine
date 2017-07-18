<?php

$query = require "bootstrap.php";

require "functions.php";

require 'Game.php';

$games = $query->selectAll("games");

require "index.view.php";