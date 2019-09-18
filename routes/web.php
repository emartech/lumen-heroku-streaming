<?php

use Symfony\Component\HttpFoundation\StreamedResponse;

$router->get('/small', function () use ($router) {
    $response = new StreamedResponse(function () {
        $ticks = 45;
        echo '[';
        for ($index = 0; $index < $ticks; $index++) {
            echo json_encode(['name' => 'bla', 'index' => $index]);
            if ($index < $ticks - 1) {
                echo ",\n";
            }
            flush();
            sleep(1);
        }

        echo ']';
    }, 200, [
        'Content-Type' => 'application/json',
    ]);
    return $response->send();
});

$router->get('/big-without-headers', function () use ($router) {
    $response = new StreamedResponse(function () {
        $ticks = 45;
        echo '[';
        for ($index = 0; $index < $ticks; $index++) {
            echo json_encode(['name' => 'bla', 'index' => $index, 'a' => array_fill(1, 5000, rand())]);
            if ($index < $ticks - 1) {
                echo ",\n";
            }
            flush();
            sleep(1);
        }

        echo ']';
    }, 200, [
        'Content-Type' => 'application/json',
    ]);
    return $response->send();
});

$router->get('/big-with-headers', function () use ($router) {
    $response = new StreamedResponse(function () {
        $ticks = 45;
        echo '[';
        for ($index = 0; $index < $ticks; $index++) {
            echo json_encode(['name' => 'bla', 'index' => $index, 'a' => array_fill(1, 5000, rand())]);
            if ($index < $ticks - 1) {
                echo ",\n";
            }
            flush();
            sleep(1);
        }

        echo ']';
    }, 200, [
        'Content-Type' => 'application/json',
    ]);
    $response->headers->set('X-Accel-Buffering', 'no');

    return $response->send();
});

$router->get('/big-not-streamed', function () use ($router) {
    $data = [];
    for ($index = 0; $index < 45; $index++) {
        $data[] = ['name' => 'bla', 'index' => $index, 'a' => array_fill(1, 5000, rand())];
    }
    return response()->json($data);
});

$router->get('/big-not-streamed-with-headers', function () use ($router) {
    $data = [];
    for ($index = 0; $index < 45; $index++) {
        $data[] = ['name' => 'bla', 'index' => $index, 'a' => array_fill(1, 5000, rand())];
    }
    return response()->json($data)->withHeaders(['X-Accel-Buffering' => 'no']);
});
