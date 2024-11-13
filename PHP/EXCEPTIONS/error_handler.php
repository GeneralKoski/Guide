<?php
// Serve per catturare e stampare nel log un errore in cui, ad esempio in questo caso, provo a stampare una variabile non dichiarata

error_reporting(E_ALL);
set_error_handler(function ($errorno, $errordesc, $efile, $eline) {
    error_log("$errorno, $errordesc, $efile, $eline");
});

echo "Prova:\n";
echo $prova;
echo "Continua comunque a fare le altre cose (esempio stampare questo echo), ma a fine file mi stampa l'errore";