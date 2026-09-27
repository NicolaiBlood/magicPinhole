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

$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$origin_ok = false;
foreach (['HTTP_ORIGIN', 'HTTP_REFERER'] as $key) {
    $value = $_SERVER[$key] ?? '';
    if ($value === '') {
        continue;
    }
    $parsed = parse_url(strtolower($value));
    if ($parsed !== false && ($parsed['host'] ?? '') === $host) {
        $origin_ok = true;
    }
}
if (!$origin_ok) {
    respond(403, false, 'Orders are submitted through the website form.');
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_file = __DIR__ . '/.rate.php';
$now = time();
$window = 3600;
$limit = 5;
$attempts = [];
if (is_file($rate_file)) {
    $raw = (string) file_get_contents($rate_file);
    $raw = preg_replace('/^<\?php exit; /', '', $raw) ?? '';
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $attempts = $decoded;
    }
}
$recent = [];
foreach ($attempts as $stored_ip => $timestamps) {
    if (!is_array($timestamps)) {
        continue;
    }
    $kept = array_values(array_filter(
        $timestamps,
        static fn($ts): bool => is_int($ts) && $now - $ts < $window
    ));
    if ($kept !== []) {
        $recent[$stored_ip] = $kept;
    }
}
if (isset($recent[$ip]) && count($recent[$ip]) >= $limit) {
    respond(429, false, 'Too many requests. Please try again in a little while.');
}
$recent[$ip][] = $now;
$handle = fopen($rate_file, 'c');
if ($handle !== false) {
    flock($handle, LOCK_EX);
    ftruncate($handle, 0);
    fwrite($handle, '<?php exit; ' . json_encode($recent));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
}

if (!empty($_POST['website'])) {
    respond(200, true, 'Thanks! Your order has been received.');
}

$name = field('name', 100);
$email = field('email', 254);
$street = field('street', 200);
$apt = field('apt', 30);
$city = field('city', 100);
$zip = field('zip', 20);

if ($name === '' || $street === '' || $city === '' || $zip === '') {
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
$address = $street . ($apt !== '' ? ' Apt ' . $apt : '') . ', ' . $city . ' ' . $zip;
fputcsv($handle, [date('c'), $csv_guard($name), $csv_guard($email), $csv_guard($address)]);
flock($handle, LOCK_UN);
fclose($handle);

respond(200, true, 'Thanks! Your spot on the order list is saved.');
