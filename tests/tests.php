<?php

require_once '../vendor/phutility/src/Test.php';

foreach(glob('*Test.php') as $file) require_once $file;

\Phutility\Test::totals();