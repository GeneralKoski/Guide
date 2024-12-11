<?php
return [
    'paths' => ['api/*', '/isChatAdmin'], // Aggiungi qui i percorsi che devono supportare CORS
    'allowed_methods' => ['*'], // Permette tutti i metodi HTTP
    'allowed_origins' => ['*'], // Permette tutte le origini (dovresti essere più restrittivo in produzione)
    'allowed_headers' => ['*'], // Permette tutti gli headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];