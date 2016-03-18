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
        $applicationsResource = "/api/v3/applications/" . $username;

        $client = new GuzzleHttp\Client();

        $applications = json_decode($client->request($method, "$protocol://$domain/$applicationsResource/?token=$token")->getBody(), true);

        $buildsFailed = 0;
        $deploysFailed = 0;

        $frames = [];
        $frameNo = 1;

        foreach( $applications as $application ) {
            $applicationBuildsResource = $application["url"] . "/builds/?branch=master&status=finished&limit=1&token=$token";
            $applicationDeploysResource = $application["url"] . "/deploys/?status=finished&limit=1&token=$token";
            $builds = json_decode($client->request($method, $applicationBuildsResource)->getBody(), true);
            $deploys = json_decode($client->request($method, $applicationDeploysResource)->getBody(), true);
            foreach ( $builds as $build ) {
                if ( $build["result"] !== "passed" ) {
                    $details = json_decode($client->request($method, $build["url"] . "?token=$token")->getBody(), true);
                    array_push($frames, [ "index" => $frameNo++, "text" => $details["application"]["name"], "icon" => "i2514" ]);
                    $buildsFailed++;
                }
            }
            foreach ( $deploys as $deploy ) {
                if ( $deploy["result"] !== "passed" ) {
                    $details = json_decode($client->request($method, $deploy["url"] . "?token=$token")->getBody(), true);
                    array_push($frames, [ "index" => $frameNo++, "text" => $details["application"]["name"], "icon" => "i195" ]);
                    $deploysFailed++;
                }
            }
        }

        header("Content-Type: application/json");

        if ( $buildsFailed === 0 && $deploysFailed === 0 ) {
            $default = [
                "frames" => [
                    [ "index" => 0, "text" => "healthy",  "icon" => "i59"]
                ]
            ];
        } else if ($buildsFailed !== 0 && $deploysFailed === 0) {

            $default = [
                "frames" => array_merge(
                    [
                        [ "index" => 0, "text" => "b $buildsFailed",  "icon" => "a609"]
                    ], $frames
                )
            ];
        } else if ($buildsFailed === 0 && $deploysFailed !== 0) {
            $default = [
                "frames" => array_merge(
                    [
                        [ "index" => 0, "text" => "d $deploysFailed",  "icon" => "a609"]
                    ], $frames
                )
            ];
        } else {
            $default = [
                "frames" => array_merge(
                    [
                        [ "index" => 0, "text" => "b $buildsFailed d $deploysFailed",  "icon" => "a609"]
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
