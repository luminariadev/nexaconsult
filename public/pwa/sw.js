const CACHE_NAME = "nexa-v1";
const OFFLINE_URL = "/offline.html";

self.addEventListener("install", event => {
    console.log("Service Worker installed");

    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll([
                "/",
                "/home",
                "/chatbot",
                "/project",
                "/profile",
                "/css/app.css",
                "/css/auth.css",
                "/js/app.js",
                "/js/auth.js",
                "/js/protect.js",
                OFFLINE_URL
            ]);
        })
    );

    self.skipWaiting();
});

self.addEventListener("activate", event => {
    console.log("Service Worker activated");

    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
            );
        })
    );

    self.clients.claim();
});

self.addEventListener("fetch", event => {
    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Jika online, kembalikan response dan cache bila perlu
                return response;
            })
            .catch(() => {
                // Jika offline, cek cache
                return caches.match(event.request).then(cached => {
                    // Jika ada file di cache → kembalikan
                    if (cached) {
                        return cached;
                    }

                    // Jika tidak ada di cache → tampilkan offline page
                    return caches.match(OFFLINE_URL);
                });
            })
    );
});
