<?php
include('connect.php');

function remove_linebreaks($s) {
    return str_replace(chr(10), '', $s);
}

$allTeacherData = array();

foreach($bdd->query('SELECT teacher_id, acronym FROM teachers') as $result) {
    if ($result['teacher_id'] >= 1698) {
        // get cURL resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, 'https://webapp.heia-fr.ch/horaire/jsp/profParAbreviation.jsp?hefrAcronyme=' . $result['acronym']);

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
        $tds = $xpath->query('//td[@width="281"]');
        $teacherData = array();
        $teacherData['teacher_id'] = $result['teacher_id'];
        $teachersFields = array('name', 'desktop', 'phone', 'email');

        for ($i = 0; $i < $tds->length; $i++) {
            $teacherData[$teachersFields[$i]] = remove_linebreaks($tds->item($i)->textContent);
        }

        $updateQuery = 'UPDATE teachers SET name = :name, desktop = :desktop, phone = :phone, email = :email WHERE teacher_id = :teacher_id';
        $bdd->prepare($updateQuery)->execute($teacherData);
        array_push($allTeacherData, $teacherData);
    }
}

file_put_contents('raw_teachers.txt', var_export($allTeacherData, true));
