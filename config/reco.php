<?php
return [

    'cache_ttl_minutes' => 30,

    'weights' => [
        'view' => 1,
        'add_to_cart' => 3,
        'purchase' => 5,
        'review' => 4,
    ],

    'hybrid_weights' => [
        'interaction' => 0.5,
        'rating' => 0.3,
        'content' => 0.2,
    ],

];
