<?php
// Nel blocco try si mette la funzione da richiamare
// Nel blocco catch si gestisce l'eccezione in caso di errore
// Nel blocco finally si mette il codice che verrà sempre eseguito, che si passi per il catch o meno
function getFileContent($filename = '')
{
    if (!file_exists($filename)) {
        throw new Exception("$filename does not exist", -20);
    }
    return file_get_contents($filename);
}

try {
    getFileContent();
} catch (Exception $e) {
    $arr['success'] = false;
    $arr['message'] = $e->getMessage();
    $arr['code'] = $e->getCode();
    echo json_encode($arr);
} finally {
    echo 'Finally called';
}