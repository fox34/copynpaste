<!DOCTYPE html>
<html>
<head>
    <base href="<?=htmlspecialchars($GLOBALS['configuration']['publicPath'] . $GLOBALS['configuration']['publicSubdir'])?>">
    <title><? if (isset($entry->id)) : echo htmlspecialchars($entry->id) . ' - '; endif; ?>Copy &amp; Paste</title>
    <!-- script src="taboverride.min.js"></script -->
    <style type="text/css">
        body {
            color: #555;
            font: 0.8em 'Lucida Grande', Verdana, Tahoma, sans-serif;
        }
        pre, code, pre span {
            font-size: 12px;
        }
        h1 {
            font-size: 1.2em;
            font-weight: bold;
            margin: 1em 0;
            padding: 0;
        }
        small {
            font-size: 0.8em;
        }
        fieldset {
            border: 1px dotted #A6A6A6;
            padding: 10px;
            margin: 5px;
            margin-bottom: 20px;
        }
        fieldset legend {
            font-weight: bold;
        }
        a:link, a:visited, a:active {
            border-bottom: 1px dotted #555;
            color: #555;
            text-decoration: none;
        }
        a:hover {
            border-bottom: 1px dotted #999;
            color: #999;
            text-decoration: none;
        }
        textarea {
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            height: 500px;
            width: 100%;
        }
        .jsOnly {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Copy &amp; Paste-Tool</h1>
