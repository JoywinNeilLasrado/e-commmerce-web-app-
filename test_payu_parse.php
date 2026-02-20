<?php
$str = 'a:6:{s:6:"status";i:1;s:3:"msg";s:21:"Refund Request Queued";s:10:"request_id";s:9:"919424840";s:10:"error_code";i:102;}';
$data = unserialize($str);
print_r($data);
