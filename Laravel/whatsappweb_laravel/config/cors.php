<?php
return [
    'paths' => ['api/*', '/*', 'sanctum/csrf-cookie'], // Aggiungi qui i percorsi che devono supportare CORS
    'allowed_methods' => ['*'], // Permette tutti i metodi HTTP
    'allowed_origins' => ['http://localhost:3001', 'http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Permette tutti gli headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];