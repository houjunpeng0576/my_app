<?php
return [
    'ak' => '0RLZEEaYWWgLtFLr885YKDurpKfesRdKzHTH5m7G',
    'sk' => '9PuRq2hDXTVBd2Em5pG8j8zwalxIPjbHbt0iXv3x',
    'bucket' => 'ceshikongjian',
    'image_url' => 'http://image.pthou.com/',
    'normal_policy' => [
        'saveKey'=>'news/$(etag)$(ext)'
    ],
    'api_policy' => [
        'saveKey' => 'news/$(etag)$(ext)',
        'returnBody' => '{"url": $(key), "hash": $(etag),"size":$(fsize),"type":$(ext),"state":"SUCCESS"}'
    ]
];