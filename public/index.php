<?php

declare(strict_types = 1);
namespace noecho\copynpaste;

// Basic init
header('Content-Type: text/html; charset=UTF-8');
if (extension_loaded('zlib')) {
    ini_set('zlib.output_compression', 'On');
}
ini_set('html_errors', '0');
error_reporting(E_ALL);


define('BASEDIR', dirname(__DIR__) . '/');

// Load configuration
$configuration = require BASEDIR . 'includes/config.php';
require_once BASEDIR . 'includes/functions.php';


// Check configuration
if (!is_dir($configuration['targetFolder']) || !is_writable($configuration['targetFolder'])) {
    die('Target folder does not exist or is not writeable.');
}


// Parse target
$request = parse_url($_SERVER['REQUEST_URI']);
if (!empty($request['query'])) {
    parse_str($request['query'], $query);
} else {
    $query = [];
}

// Append / overwrite fileID from last part of path (fileID may not consist of non-alphanumerical characters)
$query['fileID'] = basename($request['path']);
$query['action'] = $query['action'] ?? '';

switch ($query['action']) {
    
    
    
    case 'create':
        
        $fields = [
            'year', 'month', 'week', 'dayOfWeek', 'dayOfMonth', 'hour', 'minute',
            'value', 'encrypted'
        ];
        $boolFields = [
            'once'
        ];
        $entry = (object)[];
        foreach ($fields as $fieldName) {
            $entry->{$fieldName} = $_POST[$fieldName] ?? '';
        }
        foreach ($boolFields as $fieldName) {
            $entry->{$fieldName} = isset($_POST[$fieldName]);
        }
        
        if (empty($entry->value) && empty($entry->encrypted)) {
            showErrorPage('Text may not be empty.');
        }
        
        $id = getNextID();
        file_put_contents($configuration['targetFolder'] . 'entry-' . $id . '.json', json_encode($entry));
        
        $justCreated = true;
        
        // show finished entry
        require BASEDIR . 'templates/show.php';
        
        break;
        
        
    
    default:
        
        // show index
        if (empty($query['fileID'])) {
            require BASEDIR . 'templates/create.php';
            
        // show entry if possible
        } else {
            
            $fileName = $configuration['targetFolder'] . 'entry-' . basename($query['fileID']) . '.json';
            
            // File not found
            if (!file_exists($fileName)) {
                http_response_code(404);
                showErrorPage('Requested entry does not exist or has already been deleted.');
            }
            
            $entry = json_decode(file_get_contents($fileName));
            
            // Entry data is invalid json
            if ($entry === null) {
                http_response_code(500);
                showErrorPage('Requested entry contains invalid data. Could not load data.');
            }
            
            
            // Check access time.
            $isValidAccessTime = true;
            $timeFields = ['year', 'month', 'week', 'dayOfWeek', 'dayOfMonth', 'hour', 'minute'];
            $timeCheck = '';
            
            foreach ($timeFields as $field) {
                
                // not restricted
                if ($entry->{$field} === '') {
                    continue;
                }
                
                // time range
                if (($colonPos = strpos($entry->{$field}, ':')) !== false) {
                    $from = (int)substr($entry->{$field}, 0, $colonPos);
                    $to = (int)substr($entry->{$field}, $colonPos + 1);
                
                // single time
                } else {
                    $from = $to = (int)$entry->{$field};
                }
                
                switch ($field) {
            
                    case 'year':
                        $currentValue = date('Y');
                        break;
            
                    case 'month':
                        $currentValue = date('m');
                        break;
            
                    case 'week':
                        $currentValue = date('W');
                        break;
            
                    case 'dayOfWeek':
                        $currentValue = date('N');
                        break;
            
                    case 'dayOfMonth':
                        $currentValue = date('d');
                        break;
            
                    case 'hour':
                        $currentValue = date('H');
                        break;
            
                    case 'minute':
                        $currentValue = date('i');
                        break;
            
                    default:
                        $timeCheck .= "! Unknown field, disabling access for security reasons.\n";
                        $isValidAccessTime = false;
                        continue 2;
                }
                
                $currentValue = (int)$currentValue;
                
                // time is invalid
                if ($currentValue < $from || $currentValue > $to) {
                    $isValidAccessTime = false;
                    $timeCheck .=
                        $field . ' is valid from ' . $from . ' to ' . $to .
                        ', but current value is ' . $currentValue . "\n";
                }
                
            }
            
            if (!$isValidAccessTime) {
                showErrorPage("Access time is invalid:\n" . $timeCheck);
            }
            
            
            // Entry may only be shown once and user has not confirmed request
            if ($entry->once && !isset($query['showOnce'])) {
                require BASEDIR . 'templates/onceWarning.php';
                exit;
            }
            
            // Force delete source file
            if ($entry->once && unlink($fileName) === false) {
                http_response_code(500);
                showErrorPage('Could not delete entry, quitting for security reasons.');
            }
            
            // Finally, show the entry
            require BASEDIR . 'templates/show.php';
        }
        
}
