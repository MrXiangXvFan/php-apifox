<?php
require __DIR__ . '/vendor/autoload.php';

use OpenApi\Attributes as OA;

#[OA\Info(title: "apifox-php API", version: "1.0.0", description: "A simple PHP API for testing Apifox integration")]
class ApiDoc {
    #[OA\Get(path: "/api/hell11o", summary: "Get Hello Message", description: "Returns a simple hello message.", tags: ["General1"])]
    #[OA\Response(response: 200, description: "Successful operation", content: new OA\JsonContent(type: "object", properties: [
        new OA\Property(property: "status", type: "string", example: "success"),
        new OA\Property(property: "message", type: "string", example: "Hello from apifox-php API!")
    ]))]
    public function hello() {}

    #[OA\Get(path: "/api/search", summary: "Get Hello Message", description: "Returns a simple hello message.", tags: ["General1"])]
    #[OA\Response(response: 200, description: "Successful operation", content: new OA\JsonContent(type: "object", properties: [
        new OA\Property(property: "status", type: "string", example: "success"),
        new OA\Property(property: "message", type: "string", example: "Hello from apifox-php API!")
    ]))]
    public function search() {}
}

// 仅在非命令行模式下运行业务代码，避免 swagger-php 扫描时意外执行并退出
if (php_sapi_name() !== 'cli') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    if ($uri === '/api/hello') {
        echo json_encode([
            'status' => 'success',
            'message' => 'Hello from apifox-php API!'
        ]);
        exit;
    }

    // 默认 404
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ]);
}
