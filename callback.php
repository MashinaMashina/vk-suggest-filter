<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('TOP_FILE', true);

$input = json_decode(file_get_contents('php://input'));

if (empty($input)) {
	die('empty input');
}

file_put_contents(__FILE__ . '.log', json_encode($input));

include __DIR__ . '/config.php';
include __DIR__ . '/functions.php';
include __DIR__ . '/request.php';
include __DIR__ . '/vk.php';

if ($input->type === 'confirmation')
{
	die(getConfig('confirmation'));
}

if ($input->type === 'wall_post_new')
{
	include __DIR__ . '/wall_post_new.php';
}

echo 'ok';