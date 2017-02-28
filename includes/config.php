<?php

return [
    // Public subdir, must end with a slash. Must be empty for root dir.
    'publicSubdir' => '',
    
    
    // Public path (normally you don't need to change this line)
    'publicPath' => 'http' . (($_SERVER['SERVER_PORT'] == 443) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/',
    
    
    // Target folder for created files. Should not be accessible from web.
    'targetFolder' => BASEDIR . 'files/'
];
