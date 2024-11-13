<?php
class EmptyFileException extends Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        $code = -40;
        echo "No file name specified\n";
        $message = 'An expception has been thrown at ' . $this->getFile() . ' at line ';
        $message .= $this->getLine() . ' with code ' . $code;
        parent::__construct($message, $code, $previous);
    }
}
function getFileContent($filename = '')
{
    if (!$filename) {
        throw new EmptyFileException();
    }
    if (!file_exists($filename)) {
        throw new Exception("$filename does not exist", -20);
    }
    return file_get_contents($filename);
}

try {
    getFileContent(); // Se ci inserisco una stringa, non passa per la custom exception
} catch (EmptyFileException $e) {
    $arr['success'] = false;
    $arr['message'] = $e->getMessage();
    $arr['code'] = $e->getCode();
    echo json_encode($arr);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
} finally {
    echo 'Finally called';
}