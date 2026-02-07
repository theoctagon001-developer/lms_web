/**
 * API Helper with Extended Timeout
 * Default timeout: 120 seconds (for slow backend)
 */

const API_TIMEOUT = 120000; // 120 seconds in milliseconds

/**
 * Fetch with extended timeout
 * @param {string} url - The URL to fetch
 * @param {object} options - Fetch options (method, body, headers, etc.)
 * @param {number} timeout - Timeout in milliseconds (default: 120000)
 * @returns {Promise<Response>}
 */
async function fetchWithTimeout(url, options = {}, timeout = API_TIMEOUT) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), timeout);

    try {
        const response = await fetch(url, {
            ...options,
            signal: controller.signal
        });
        clearTimeout(timeoutId);
        return response;
    } catch (error) {
        clearTimeout(timeoutId);
        if (error.name === 'AbortError') {
            throw new Error(`Request timeout after ${timeout / 1000} seconds`);
        }
        throw error;
    }
}

/**
 * GET request with extended timeout
 */
async function apiGet(url, timeout = API_TIMEOUT) {
    return fetchWithTimeout(url, { method: 'GET' }, timeout);
}

/**
 * POST request with extended timeout
 */
async function apiPost(url, data = {}, timeout = API_TIMEOUT) {
    return fetchWithTimeout(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            ...data.headers
        },
        body: JSON.stringify(data.body || data)
    }, timeout);
}

// Make functions available globally
if (typeof window !== 'undefined') {
    window.fetchWithTimeout = fetchWithTimeout;
    window.apiGet = apiGet;
    window.apiPost = apiPost;
}
