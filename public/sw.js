self.addEventListener('install', function (e) {
    console.log('[ServiceWorker] Install');
    e.waitUntil(
        caches.open('pwa-cache').then(function (cache) {
            return cache.addAll([
                '/',
                '/css/app.css',
                '/js/app.js',
                // Agrega aquí otras rutas necesarias
            ]);
        })
    );
});

self.addEventListener('fetch', function (e) {
    e.respondWith(
        caches.match(e.request).then(function (response) {
            return response || fetch(e.request);
        })
    );
});
