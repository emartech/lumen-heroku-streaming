<?php

use Symfony\Component\HttpFoundation\StreamedResponse;

$router->get('/small', function () use ($router) {
    $response = new StreamedResponse(function () {
        $ticks = 15;
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
        $ticks = 15;
        echo '[';
        for ($index = 0; $index < $ticks; $index++) {
            ob_start();
            phpinfo();
            $phpinfo = ob_get_flush();
            echo json_encode(['name' => 'bla', 'index' => $index, 'phpinfo' => $phpinfo]);
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
        $ticks = 15;
        echo '[';
        for ($index = 0; $index < $ticks; $index++) {
            ob_start();
            phpinfo();
            $phpinfo = ob_get_flush();
            echo json_encode(['name' => 'bla', 'index' => $index, 'phpinfo' => $phpinfo]);
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