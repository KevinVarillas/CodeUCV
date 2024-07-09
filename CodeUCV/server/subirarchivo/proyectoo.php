<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['projectFile'])) {
    $zipFile = $_FILES['projectFile']['tmp_name'];
    $zip = new ZipArchive;
    $zip->open($zipFile);

    $content = '';
    $code = '';

    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $content .= '<h2>' . $filename . '</h2>';
        $fileContent = $zip->getFromIndex($i);
        $content .= '<pre>' . htmlspecialchars($fileContent, ENT_QUOTES) . '</pre>';
        $code .= $fileContent . "\n\n";
    }

    $zip->close();

    echo json_encode(['content' => $content, 'code' => $code]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió ningún archivo']);
}
?>



