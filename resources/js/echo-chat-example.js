/**
 * Browser-side Echo + Reverb example for the chat API.
 *
 * Install:
 *   npm install --save-dev laravel-echo pusher-js
 *
 * Usage in resources/js/app.js (or your entry):
 *   import { setupChat } from './echo-chat-example.js';
 *   setupChat({ roomId: 1, token: '<sanctum-token>' });
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

/**
 * Build a fresh Echo instance bound to a Sanctum bearer token.
 * The token is sent on the /api/broadcasting/auth request that
 * Echo fires when subscribing to private/presence channels.
 */
export function buildEcho(token) {
    return new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
        // Critical: Echo's auth endpoint uses Sanctum, not the default web auth.
        authEndpoint: '/api/broadcasting/auth',
        auth: {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json',
            },
        },
    });
}

export function setupChat({ roomId, token }) {
    const echo = buildEcho(token);

    // ---- 1. Public channel ---------------------------------------------------
    echo.channel(`chat.room.public.${roomId}`)
        .listen('.message.sent', (e) => {
            console.log('[public] new message:', e);
        });

    // ---- 2. Private channel --------------------------------------------------
    echo.private(`chat.room.${roomId}`)
        .listen('.message.sent', (e) => {
            console.log('[private] new message:', e);
        });

    // ---- 3. Presence channel (online users + typing) ------------------------
    echo.join(`chat.room.presence.${roomId}`)
        .here((users) => {
            console.log('[presence] currently online:', users);
        })
        .joining((user) => {
            console.log('[presence] joined:', user);
        })
        .leaving((user) => {
            console.log('[presence] left:', user);
        })
        .listen('.message.sent', (e) => {
            console.log('[presence] new message:', e);
        })
        .listen('.user.typing', (e) => {
            console.log('[presence] typing:', e);
        });

    // ---- 4. Global "user came online" (public) -----------------------------
    echo.channel('users.online')
        .listen('.user.online', (e) => {
            console.log('[global] user online:', e);
        });

    return echo;
}
