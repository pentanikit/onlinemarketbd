<?php

return [
    'route_prefix' => 'classifieds',
    'default_status' => 'pending', // pending or published
    'max_images' => 5,
    'image_disk' => 'public',
    'image_directory' => 'classifieds/ads',
    'session_key' => 'classified_ad_user_id',
];