<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Settings
    |--------------------------------------------------------------------------
    |
    | Configure your CORS settings here for cross-origin resource sharing.
    |
    */

    'paths' => ['api/*'], // Define the paths where CORS should be enabled. Example: 'api/*', or add specific endpoints.

    'allowed_methods' => ['*'], // Allow all methods (GET, POST, PUT, DELETE, etc.) or specify ['GET', 'POST'].

    'allowed_origins' => ['*'], // Allow requests from all origins. Replace '*' with specific origins as needed (e.g., 'https://example.com').

    'allowed_origins_patterns' => [], // Use regex patterns to allow origins.

    'allowed_headers' => ['*'], // Allow all headers or specify only necessary headers.

    'exposed_headers' => [], // Specify headers you want to expose in the response (if any).

    'max_age' => 0, // Set how long (in seconds) the response from a preflight request is cached. Use 0 for no caching.

    'supports_credentials' => false, // Set to true to include cookies or authorization headers in the request.

];
