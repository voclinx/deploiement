<?php

namespace kcfinder;

chdir("..");
chdir("..");
require "core/autoload.php";
$theme = basename(__dir__);
$min = new minifier("js");
$min->minify("cache/theme_$theme.js");

?>