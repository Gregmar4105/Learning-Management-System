<?php

return [
    'use_jwt' => env('JITSI_USE_JWT', false),
    'jwt_secret' => env('JITSI_JWT_SECRET'),
    'jwt_issuer' => env('JITSI_JWT_ISSUER'),
    'jwt_expiration' => env('JITSI_JWT_EXPIRATION', 3600), // In seconds (e.g., 1 hour)
];