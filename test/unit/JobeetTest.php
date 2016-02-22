<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.02.16
 * Time: 10:37
 */

require_once __DIR__.'/../bootstrap/unit.php';

$test = new lime_test(8);
$test->comment('::slugify()');
$test->is(Jobeet::slugify('Sensio'), 'sensio', '::slugify() converts all characters to lower case');
$test->is(Jobeet::slugify('sensio labs'), 'sensio-labs', '::slugify() replaces a white space by a -');
$test->is(Jobeet::slugify('sensio   labs'), 'sensio-labs', '::slugify() replaces several white spaces by a single -');
$test->is(Jobeet::slugify('  sensio'), 'sensio', '::slugify() removes - at the beginning of a string');
$test->is(Jobeet::slugify('sensio  '), 'sensio', '::slugify() removes - at the end of a string');
$test->is(Jobeet::slugify('paris,france'), 'paris-france', '::slugify() replaces non-ASCII characters by a -');
$test->is(Jobeet::slugify(' - '), 'n-a', '::slugify() converts a string that only contains non-ASCII characters to n-a');
if (function_exists('iconv')){
    $test->is(Jobeet::slugify('Développeur Web'), 'developpeur-web', '::slugify() removes accents');
} else {
    $test->skip('::slugify() removes accents - iconv not installed');
}