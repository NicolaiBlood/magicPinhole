<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(int $code, bool $ok, string $message): void
{
    http_response_code($code);
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

function field(string $key, int $max): string
{
    $value = isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
    $value = trim($value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $value) ?? '';
    $length = function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
    if ($length > $max) {
        respond(422, false, 'One of the fields is too long.');
    }
    return $value;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, false, 'Orders are submitted through the website form.');
}

if (!empty($_POST['website'])) {
    respond(200, true, 'Thanks! Your order has been received.');
}

$name = field('name', 100);
$email = field('email', 254);
$address = field('address', 600);

if ($name === '' || $address === '') {
    respond(422, false, 'Please enter your name and shipping address.');
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(422, false, 'Please check the email address you entered.');
}

$csv_guard = static function (string $value): string {
    if ($value !== '' && strpbrk($value[0], '=+-@') !== false) {
        return "'" . $value;
    }
    return $value;
};

$file = __DIR__ . '/orders.csv';
$handle = fopen($file, 'c+');
if ($handle === false) {
    respond(500, false, 'Orders storage is unavailable right now. Please try again later.');
}

flock($handle, LOCK_EX);
if (fstat($handle)['size'] === 0) {
    fputcsv($handle, ['date', 'name', 'email', 'address']);
}
fputcsv($handle, [date('c'), $csv_guard($name), $csv_guard($email), $csv_guard($address)]);
flock($handle, LOCK_UN);
fclose($handle);

respond(200, true, 'Thanks! Your spot on the order list is saved.');
