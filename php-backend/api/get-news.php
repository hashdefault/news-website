<?php

session_start();

require __DIR__ . '/../functions.php';

// CORS configuration - permite localhost para desenvolvimento
$allowedOrigins = [
  'https://news.bitsbylucas.com',
  'http://localhost:5173',
  'http://localhost:3000',
  'http://127.0.0.1:5173',
  'http://127.0.0.1:3000'
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if (in_array($origin, $allowedOrigins)) {
  header("Access-Control-Allow-Origin: $origin");
} else {
  header("Access-Control-Allow-Origin: https://news.bitsbylucas.com");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}


loadEnv(__DIR__ . '/../.env');

$apiKey = getenv('API_KEY');


$headers = array(
  "Content-Type: application/json",
  "Authorization: {$apiKey}",
);

$keywords = $_GET['keywords'] ??  '';
$categories = $_GET['categories'] ?? '';
$language = $_GET['languages'] ?? '';
$start_date = date('Y-m-01');
$end_date = date('Y-m-31');


$request = [
  'apikey' => $apiKey,
  'category' => $categories ?? NULL,
  'language' => $language,
  'image' => 1,
  //'from_date' => $start_date,
  //'to_date' => $end_date
];


if ($keywords) {
  if (str_contains($keywords, " ")) {
    $keywords = explode(" ", $keywords);

    $keywords = implode(" OR ", $keywords);
  }
  $request['q'] = $keywords;
}

if ($request['category'] == 'search') {
  unset($request['category']);
  unset($_SESSION[$categories]);
}


if (key_exists($categories, $_SESSION) and $_SESSION[$categories][$language] and !empty($_SESSION[$categories][$language]['results'])) {
  echo json_encode($_SESSION[$categories][$language]);
} else {
  $results = array();
  $reqs = 2;
  if ($language == 'en') {
    $reqs = 1;
  }
  for ($i = 1; $i <= $reqs; $i++) {
    if ($i == 2) {
      $request['page'] = $response['nextPage'];
    }
    $queryString = http_build_query($request);
    $ch = curl_init(sprintf('%s?%s', 'https://newsdata.io/api/1/latest', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json_response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($json_response, true);
    if (!key_exists('error', $response) and $response['status'] == 'success') {
      $results = array_merge($response['results'], $results);
    }
  }
  if (!empty($results)) {
    $_SESSION[$categories][$language]['results'] = $results;
    $_SESSION[$categories][$language]['status'] = 'success';
    echo json_encode($_SESSION[$categories][$language]);
  } else if (isset($response['error'])) {
    echo json_encode(array(
      "status" => "error",
      "error" => $response['error']['message'] ?? 'Erro na API externa',
      "message" => $response['error']['message'] ?? 'Erro na API externa'
    ));
  } else {
    echo json_encode(array(
      "status" => "error",
      "error" => 'Nenhuma notícia encontrada.',
      "message" => 'Nenhuma notícia encontrada.'
    ));
  }
}
