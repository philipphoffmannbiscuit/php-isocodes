<?php

define('DATABASES_DIR', rtrim($argv[1], '/'));
define('SOURCE_DATABASE_PATH', DATABASES_DIR . '/iso_3166-2.json');
define('TARGET_DATABASE_DIR', DATABASES_DIR . '/iso_3166-2');

if (!is_dir(DATABASES_DIR)) {
    throw new \InvalidArgumentException('Invalid databases dir specified');
}

if (!is_writable(DATABASES_DIR)) {
    throw new \InvalidArgumentException('Databases dir is not writable');
}

// parse database
$database = json_decode(file_get_contents(SOURCE_DATABASE_PATH), true);

$countryAlpha2ToSubdivisionsMap = [];

foreach ($database['3166-2'] as $countrySubdivision) {
    [$countryAlpha2, $countrySubdivisionCode] = explode('-', $countrySubdivision['code']);
    $countryAlpha2ToSubdivisionsMap[$countryAlpha2][] = [
        'code' => $countrySubdivisionCode,
        'name' => $countrySubdivision['name'],
        'type' => $countrySubdivision['type'],
    ];
}

// store splitted database
if (!file_exists(TARGET_DATABASE_DIR)) {
    mkdir(TARGET_DATABASE_DIR, 0775);
}

foreach ($countryAlpha2ToSubdivisionsMap as $countryAlpha2 => $countrySubdivisions) {
    file_put_contents(
        sprintf('%s/%s.php', TARGET_DATABASE_DIR, $countryAlpha2),
        sprintf('return %s;', var_export($countrySubdivisions, true))
    );
}

