<?php
// echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">';
echo '<link rel="manifest" href="/manifest.json">';
echo '<meta name="apple-mobile-web-app-capable" content="yes">';
echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
echo '<meta name="apple-mobile-web-app-title" content="Road Luxury">';
echo '<link rel="apple-touch-icon" sizes="192x192" href="img/icon-192x192.png">';
echo '<link rel="apple-touch-icon" sizes="512x512" href="img/icon-512x512.png">';
echo '<link rel="apple-touch-icon" sizes="72x72" href="img/hd_hi.ico">';
echo '<link rel="apple-touch-icon" sizes="96x96" href="img/hd_hi.ico">';
echo '<link rel="apple-touch-icon" sizes="128x128" href="img/hd_hi.ico">';
echo '<link rel="apple-touch-icon" sizes="256x256" href="img/hd_hi.ico">';
echo '<link rel="apple-touch-icon" sizes="180x180" href="img/icon-180x180.png">';
echo '<script>';
echo 'if ("serviceWorker" in navigator) {';
echo '  navigator.serviceWorker.register("/service-worker.js").then(function(registration) {';
echo '    console.log("Service Worker registered with scope:", registration.scope);';
echo '  }).catch(function(error) {';
echo '    console.log("Service Worker registration failed:", error);';
echo '  });';
echo '}';
echo '</script>';
?>