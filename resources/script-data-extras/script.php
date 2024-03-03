<?php

// Datos de conexión a la base de datos
$host = 'db_host';
$dbname = 'db_name';
$username = 'db_user';
$password = 'db_password';

$path = 'original-data/countries+states+cities.json';
$jsonString = file_get_contents($path);

// Decodificar el JSON a un array de PHP
$jsonData = json_decode($jsonString, true);

// Calcular el tamaño de cada grupo
$totalElements = count($jsonData);
$elementsPerGroup = ceil($totalElements / 4);

// Crear los arrays para almacenar los grupos
$group1 = [];
$group2 = [];
$group3 = [];
$group4 = [];

// Rellenar los grupos
foreach ($jsonData as $index => $item) {

    if ($index < $elementsPerGroup) {

        $group1[] = $item;

    } elseif ($index < $elementsPerGroup * 2) {

        $group2[] = $item;

    } elseif ($index < $elementsPerGroup * 3) {

        $group3[] = $item;

    } else {

        $group4[] = $item;
    }
}

// var_dump(count($group4));

$file_path = 'splitted-data';

// Checking whether file exists or not
if (! file_exists($file_path)) {

    // Create a new file or direcotry
    mkdir($file_path, 0777, true);
}

file_put_contents('splitted-data/countries+states+cities-group1.json', json_encode($group1));
file_put_contents('splitted-data/countries+states+cities-group2.json', json_encode($group2));
file_put_contents('splitted-data/countries+states+cities-group3.json', json_encode($group3));
file_put_contents('splitted-data/countries+states+cities-group4.json', json_encode($group4));

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$files = [
    'splitted-data/countries+states+cities-group1.json',
    'splitted-data/countries+states+cities-group2.json',
    'splitted-data/countries+states+cities-group3.json',
    'splitted-data/countries+states+cities-group4.json'
];

foreach ($files as $file) {

    $data = json_decode(file_get_contents($file), true);

    foreach ($data as $country) {

        $statement = $pdo->prepare(
            "INSERT INTO countries
                (name,iso3,iso2,numeric_code,phone_code,capital,currency,currency_name,currency_symbol,tld,native,region,region_id,subregion,subregion_id,nationality,latitude,longitude)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $statement->execute([
            $country['name'],
            $country['iso3'],
            $country['iso2'],
            $country['numeric_code'],
            $country['phone_code'],
            $country['capital'],
            $country['currency'],
            $country['currency_name'],
            $country['currency_symbol'],
            $country['tld'],
            $country['native'],
            $country['region'],
            $country['region_id'],
            $country['subregion'],
            $country['subregion_id'],
            $country['nationality'],
            $country['latitude'],
            $country['longitude']
        ]);

        $countryId = $pdo->lastInsertId();

        foreach ($country['states'] as $state) {

            $statement = $pdo->prepare(
                "INSERT INTO states
                    (country_id, name, state_code, latitude, longitude, type)
                VALUES
                    (?, ?, ?, ?, ?, ?)"
            );

            $statement->execute([
                $countryId,
                $state['name'],
                $state['state_code'],
                $state['latitude'],
                $state['longitude'],
                $state['type']]
            );

            $stateId = $pdo->lastInsertId();

            foreach ($state['cities'] as $city) {

                $statement = $pdo->prepare(
                    "INSERT INTO cities
                        (state_id, name, latitude, longitude)
                    VALUES
                        (?, ?, ?, ?)
                ");

                $statement->execute([
                    $stateId,
                    $city['name'],
                    $city['latitude'],
                    $city['longitude']]
                );

            }
        }
    }
}

echo "All processes completed.";
