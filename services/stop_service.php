<?php

function getStops($line) {
    $json = file_get_contents("../data/stops.json");
    $data = json_decode($json, true);
    $result = array_filter($data, function($item) use ($line) {
        return $item['fields']['mode'] === 'METRO' && $item['fields']['indice_lig'] === "$line";
    });
    return $result;
}
