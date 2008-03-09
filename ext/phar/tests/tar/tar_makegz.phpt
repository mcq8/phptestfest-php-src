--TEST--
Phar: tar-based phar, make new gzipped tar
--SKIPIF--
<?php if (!extension_loaded('phar')) die('skip'); ?>
<?php if (!extension_loaded("spl")) die("skip SPL not available"); ?>
<?php if (!extension_loaded("zlib")) die("skip zlib not available"); ?>
--INI--
phar.readonly=0
--FILE--
<?php

$fname = dirname(__FILE__) . '/tar_makebz2.phar.tar';
$fname2 = dirname(__FILE__) . '/tar_makebz2.phar.tar.gz';
$fname3 = dirname(__FILE__) . '/tar_makebz2_b.phar.tar.gz';

$phar = new Phar($fname);
$phar['test'] = 'hi';
var_dump($phar->isTar());
$phar->compressAllFilesGZ();

copy($fname2, $fname3);

$phar2 = new Phar($fname3);
var_dump($phar2->isTar());
var_dump($phar2->isCompressed() == Phar::GZ);

?>
===DONE===
--CLEAN--
<?php
@unlink(dirname(__FILE__) . '/tar_makebz2.phar.tar.gz');
@unlink(dirname(__FILE__) . '/tar_makebz2_b.phar.tar.gz');
?>
--EXPECTF--
bool(true)
bool(true)
bool(true)
===DONE===