<?php
echo '<link rel="manifest" href="/manifest.json">';
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