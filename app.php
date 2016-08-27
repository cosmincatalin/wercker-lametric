<?php

require_once __DIR__ . '/vendor/autoload.php';

try {

    $username = trim(strtolower(preg_replace("/[^A-Za-z0-9\-]/", '', isset($argv[1]) ? $argv[1] : $_GET["username"])));
    $token = trim(strtolower(preg_replace("/[^A-Za-z0-9]/", '', isset($argv[2]) ? $argv[2] : $_GET["token"])));

    if ( strlen($username) === 0 || strlen( $token) === 0 ) {
        $default = [
            "frames" => [
                [ "index" => 0, "text" => "configure the application on your phone.",  "icon" => "a2361"]
            ]
        ];
    } else {
        $method = "GET";
        $protocol = "https";
        $domain = "app.wercker.com";

        $client = new GuzzleHttp\Client();

        $applications = json_decode($client->request($method, "$protocol://$domain/api/v3/applications/$username/?token=$token")->getBody(), true);

        $runsFailed = 0;

        $frames = [];
        $frameNo = 1;

        foreach( $applications as $application ) {
            $applicationRunsResource = "$protocol://$domain/api/v3/runs/?applicationId=" . $application["id"] . "&branch=master&limit=1&status=finished&token=$token";
            $runs = json_decode($client->request($method, $applicationRunsResource)->getBody(), true);
            foreach ( $runs as $run ) {
                if ( $run["result"] !== "passed" ) {
                    $details = json_decode($client->request($method, $run["url"] . "?token=$token")->getBody(), true);
                    array_push($frames, [ "index" => $frameNo++, "text" => $details["application"]["name"] . " ", "icon" => "i2514" ]);
                    $runsFailed++;
                }
            }
        }

        header("Content-Type: application/json");

        if ( $runsFailed === 0 ) {
            $default = [
                "frames" => [
                    [ "index" => 0, "text" => "healthy",  "icon" => "i59"]
                ]
            ];
        } else {
            $default = [
                "frames" => array_merge(
                    [
                        [ "index" => 0, "text" => "$runsFailed",  "icon" => "a609"]
                    ], $frames
                )
            ];
        }
    }

    header("Content-Type: application/json");
    echo json_encode($default);

} catch ( \Exception $ex ) {
    $default = [
        "frames" => [
            [ "index" => 0, "text" => "error",  "icon" => "i555"]
        ]
    ];
    header("Content-Type: application/json");
    echo json_encode($default);
}
