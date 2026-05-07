<?php

/**
 * Enhanced Utility script to create storage link and DIAGNOSE image issues.
 * Upload this to your project root or 'public' folder and visit it.
 */

// 1. Detect where we are
if (file_exists(__DIR__ . '/storage/app/public')) {
    $basePath = __DIR__;
} elseif (file_exists(__DIR__ . '/../storage/app/public')) {
    $basePath = dirname(__DIR__);
} else {
    echo "<p style='color: red;'>Could not find project structure. Upload to project root.</p>";
    exit;
}

$targetStorage = $basePath . '/storage/app/public';
$publicFolder = $basePath . '/public';
$publicStorage = $publicFolder . '/storage';

echo "<h1>Laravel Storage Diagnostic Tool</h1>";

echo "<h3>System Paths:</h3>";
echo "<ul>
        <li>Base Path: <code>$basePath</code></li>
        <li>Public Folder: <code>$publicFolder</code></li>
        <li>Storage Target: <code>$targetStorage</code></li>
      </ul>";

// 2. Symlink Check
echo "<h3>Symlink Status:</h3>";

function checkSymlinkEnabled() {
    if (!function_exists('symlink')) return "DISABLED (function does not exist)";
    $disabled = explode(',', ini_get('disable_functions'));
    if (in_array('symlink', array_map('trim', $disabled))) return "DISABLED (in disable_functions)";
    return "ENABLED";
}

echo "<p>PHP <code>symlink()</code> status: " . checkSymlinkEnabled() . "</p>";

if (file_exists($publicStorage)) {
    if (is_link($publicStorage)) {
        $actualTarget = readlink($publicStorage);
        echo "<p style='color: green;'>SYMLINK EXISTS: <code>$publicStorage</code> -> <code>$actualTarget</code></p>";
        if (!file_exists($actualTarget)) {
            echo "<p style='color: red;'>WARNING: The target directory does not exist!</p>";
        }
    } else {
        echo "<p style='color: red;'>ERROR: 'storage' exists but is a REAL FOLDER. Delete <code>$publicStorage</code> manually first.</p>";
    }
} else {
    echo "<p>Link does not exist. Attempting to create...</p>";
    
    $success = false;
    if (checkSymlinkEnabled() === "ENABLED") {
        if (@symlink($targetStorage, $publicStorage)) {
            $success = true;
            echo "<p style='color: green;'>Successfully created link using PHP <code>symlink()</code>!</p>";
        } else {
            $error = error_get_last();
            echo "<p style='color: red;'>PHP symlink failed: " . ($error['message'] ?? 'Unknown error') . "</p>";
        }
    }

    if (!$success && function_exists('shell_exec')) {
        echo "<p>Trying fallback: <code>shell_exec(ln -s)</code></p>";
        @shell_exec("ln -s " . escapeshellarg($targetStorage) . " " . escapeshellarg($publicStorage));
        if (file_exists($publicStorage) && is_link($publicStorage)) {
            echo "<p style='color: green;'>Successfully created link using <code>shell_exec</code>!</p>";
            $success = true;
        } else {
            echo "<p style='color: red;'>Shell fallback failed.</p>";
        }
    }

    if (!$success) {
        echo "<p style='color: orange;'><b>CRITICAL:</b> Hosting provider has disabled symbolic link creation.</p>";
        echo "<p><b>Solution for Hostinger:</b> Create a <b>Cron Job</b> in your Control Panel with this command:</p>";
        echo "<code>ln -s $targetStorage $publicStorage</code>";
        echo "<p>Run it once, then delete the cron job.</p>";
    }
}

// 3. File Existence Check
echo "<h3>File Diagnostic:</h3>";
$sampleFile = '/cows/thumbnails/01KDAZH1M4W9VGJ0APP7WZZ645.png';
$fullPath = $targetStorage . $sampleFile;

if (file_exists($fullPath)) {
    echo "<p style='color: green;'>FILE FOUND: <code>$sampleFile</code> exists in target storage.</p>";
    echo "<p>Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "</p>";
} else {
    echo "<p style='color: red;'>FILE NOT FOUND: <code>$fullPath</code> does not exist.</p>";
    
    // Scan directory to see what IS there
    $dirToScan = dirname($fullPath);
    if (is_dir($dirToScan)) {
        echo "<p>Found directory <code>$dirToScan</code>. Contents:</p><ul>";
        $files = scandir($dirToScan);
        foreach($files as $file) {
            if ($file != "." && $file != "..") echo "<li>$file</li>";
        }
        echo "</ul>";
    } else {
         echo "<p style='color: red;'>Directory <code>$dirToScan</code> NOT FOUND.</p>";
    }
}

echo "<hr><p>Verify <b>APP_URL</b> in <b>.env</b> matches: <code>" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]</code></p>";
