const CACHE_NAME = 'sehat-rahbar-v1';
const OFFLINE_URL = '/offline.html';

// Static assets making up the app shell.
const APP_SHELL = [
    '/',
    OFFLINE_URL,
    '/manifest.json',
    '/images/logo.png',
    '/favicon.ico',
];

// Request destinations that are safe to serve cache-first.
const CACHEABLE_DESTINATIONS = ['style', 'script', 'image', 'font'];

self.addEventListener('install', (event) => {
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);

        await cache.addAll(APP_SHELL);

        // Cache the built Vite assets listed in the build manifest, so the
        // cached app shell matches the current build's hashed filenames.
        try {
            const response = await fetch('/build/manifest.json', { cache: 'no-store' });
            if (response.ok) {
                const buildManifest = await response.json();
                const assets = Object.values(buildManifest)
                    .map((entry) => '/build/' + entry.file);
                await cache.addAll(assets);
            }
        } catch (error) {
            // The build manifest is unavailable (e.g. running under `npm run dev`); skip it.
        }

        await self.skipWaiting();
    })());
});

self.addEventListener('activate', (event) => {
    event.waitUntil((async () => {
        const keys = await caches.keys();
        await Promise.all(
            keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
        );

        await self.clients.claim();
    })());
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    // Only handle same-origin GET requests.
    if (request.method !== 'GET' || new URL(request.url).origin !== self.location.origin) {
        return;
    }

    // Page navigations: network first, falling back to the cache, then the offline page.
    if (request.mode === 'navigate') {
        event.respondWith((async () => {
            try {
                return await fetch(request);
            } catch (error) {
                const cache = await caches.open(CACHE_NAME);
                return (await cache.match(request)) || (await cache.match(OFFLINE_URL));
            }
        })());
        return;
    }

    // Dynamic data (XHR/fetch calls) always goes to the network.
    if (!CACHEABLE_DESTINATIONS.includes(request.destination)) {
        return;
    }

    // Static assets: cache first, then network (caching successful responses).
    event.respondWith((async () => {
        const cache = await caches.open(CACHE_NAME);
        const cached = await cache.match(request);
        if (cached) {
            return cached;
        }

        try {
            const response = await fetch(request);
            if (response.ok) {
                cache.put(request, response.clone());
            }
            return response;
        } catch (error) {
            return new Response('Offline', { status: 503, statusText: 'Offline' });
        }
    })());
});
