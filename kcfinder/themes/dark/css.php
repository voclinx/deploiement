<?php

namespace kcfinder;

chdir("..");
chdir("..");
require "core/autoload.php";
$theme = basename(__dir__);
$min = new minifier("css");
$min->minify("cache/theme_$theme.css");

?>