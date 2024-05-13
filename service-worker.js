const CACHE_NAME = 'road-luxury-cache-v1';
const urlsToCache = [
    '/projet-php-e-commerce/',
    '/projet-php-e-commerce/index.php',
    '/projet-php-e-commerce/style.css',
    '/projet-php-e-commerce/script.js',
    '/projet-php-e-commerce/img/icon-192x192.png',
    '/projet-php-e-commerce/img/icon-512x512.png',
    // Ajoutez ici toutes les autres ressources que vous souhaitez mettre en cache
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                if (response) {
                    return response;
                }
                return fetch(event.request).then(function (response) {
                    // Ne cache que les réponses "basic" (même origine)
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }
                    var responseToCache = response.clone();
                    caches.open(CACHE_NAME).then(function (cache) {
                        cache.put(event.request, responseToCache);
                    });
                    return response;
                });
            })
    );
});

self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});