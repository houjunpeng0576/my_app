<?php
//分类栏目
return [
    'lists' => [
        '1' => '推荐',
        '2' => '科技',
        '3' => '体育',
        '4' => '娱乐',
        '5' => '搞笑',
        '6' => '情感',
        '7' => '动漫',
        '8' => '游戏',
        '9' => '旅游',
        '10' => '时尚',
        '11' => '汽车',
        '12' => '财经',
        '13' => '星座',
        '14' => '健康',
        '15' => '美食',
        '16' => '军事',
        '17' => '教育',
        '18' => 'NBA',
        '19' => 'IT'
    ]
];
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