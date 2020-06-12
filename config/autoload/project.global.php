<?php

$config = [
    /**
     * Allow schema responses are plainJson, HAL , JsonSchema, JsonApi, OpenAPI
     * policy: 1 = strict, 2 = medium , 3 = normal
     */
    'responseSchema' => [
        'default' => 'plain-json' ,
        'policy' => 1,
        'allowed' => ['plain-json' , 'hal' , 'json-schema' , 'json-api' , 'open-api'] ,
        'disallowed' => []
     ]
];

return $config ;