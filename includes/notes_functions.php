<?php

function notes_file_path() {
    return __DIR__ . '/../data/units_notes.json';
}

function get_all_units() {
    $path = notes_file_path();
    if (!file_exists($path)) return ['units'=>[]];
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    if (!is_array($data)) return ['units'=>[]];
    return $data;
}

function get_unit($id) {
    $data = get_all_units();
    foreach ($data['units'] as $u) {
        if ((int)$u['id'] === (int)$id) return $u;
    }
    return null;
}

function save_units($data) {
    $path = notes_file_path();
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

function quiz_file_path($unitId) {
    return __DIR__ . "/../data/quiz_unit{$unitId}.json";
}

function get_quiz($unitId) {
    $path = quiz_file_path($unitId);
    if (!file_exists($path)) return null;
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : null;
}

function save_quiz($unitId, $data) {
    $path = quiz_file_path($unitId);
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}
