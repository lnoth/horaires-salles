<?php
include('connect.php');

function remove_spaces($s) {
    $s2 = str_replace(chr(160), '', $s);
    $s3 = str_replace(chr(194), '', $s2);
    return trim($s3);
}

$roomTable = array();
foreach($bdd->query('SELECT name FROM rooms') as $result) {
    array_push($roomTable, $result['name']);
}

$result = array();
foreach ($roomTable as $keyRoomTable=>$elementRoomTable){
    // get cURL resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, 'https://webapp.heia-fr.ch/horaire/bloc-jsp/horaire_par_salle.jsp');

    // set method
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

    // return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // set headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic bGVvbmFyZG4ubm90aDpFdG5AMjAxMw==',
        'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        'Cookie: JSESSIONID=1E8C1BF44B67E5FD45DFC9581AB42D20',
    ]);

    // form body
    $body = [
        'salle' => $elementRoomTable,
        'Submit1' => 'Chercher',
    ];
    $body = http_build_query($body);

    // set body
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

    // send the request and save response to $response
    $response = curl_exec($ch);

    $response = str_replace('.write("<div', '.write("', $response);

    $response = str_replace('</div>");', '");"', $response);

    // stop if fails
    if (!$response) {
        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }

    // close curl resource to free up system resources
    curl_close($ch);


    // Parsing the DOM
    $dom = new DOMDocument();
    $dom->loadHTML($response. PHP_EOL);

    $xpath = new DOMXpath($dom);
    $table = $xpath->query(".//table//table")->item(0);
    // echo $table->ownerDocument->saveXML($table);
    $trs=$table->getElementsByTagName('tr');

    $dataToInsert = Array();
    $tempStockedDay = "";

    foreach ($trs as $key=>$element){
        // echo htmlspecialchars($element->ownerDocument->saveXML($element)) . "<br><br>";
        $tdTable = Array();
        if ($key != 0) {
            foreach ($element->getElementsByTagName('td') as $key2=>$element2) {
                // echo  $key2 . htmlspecialchars($element2->ownerDocument->saveXML($element2)) . "<br><br>";
                $tempInsertElement = $element2->nodeValue;
                switch ($key2) {
                    case 0:
                        if ($tempInsertElement != "") {
                            $tempStockedDay = $tempInsertElement;
                        }
                        $tdTable["Jour"] = remove_spaces($tempStockedDay);
                        break;
                    case 1:
                        $tempInsertElement = str_replace(chr(194), ' ', $tempInsertElement);
                        $tdTable["Heures"] = remove_spaces($tempInsertElement);
                        break;
                    case 2:
                        $tdTable["Cours"] = remove_spaces($tempInsertElement);
                        break;
                    case 3:
                        $tempInsertElement = str_replace(chr(194), ' ', $tempInsertElement);
                        $tdTable["Classe"] = remove_spaces($tempInsertElement);
                        break;
                    case 4:
                        $tempInsertElement = str_replace(chr(194), ' ', $tempInsertElement);
                        $tdTable["Prof"] = remove_spaces($tempInsertElement);
                        break;
                }
            }
            $tdTable["Salle"] = remove_spaces($elementRoomTable);
            array_push($dataToInsert, $tdTable);
        }
    }

    //print_r($dataToInsert);
    //file_put_contents('raw_data.bin', serialize($dataToInsert));
    array_push($result, $dataToInsert);
}

$data_cleaned = array();
function clean_data($data) {
    global $data_cleaned;

    if (count($data) == 0) {
        return;
    }

    if (array_key_exists('Heures', $data)) {
        array_push($data_cleaned, $data);
        return;
    }

    for ($i = 0; $i < count($data); $i++) {
        clean_data($data[$i]);
    }
}
clean_data($result);

file_put_contents('raw_data.txt', var_export($data_cleaned, true));
