<!-- Tailwind CSS CDN with Custom Configuration -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f0f9ff',
                        100: '#e0f2fe',
                        200: '#bae6fd',
                        300: '#7dd3fc',
                        400: '#38bdf8',
                        500: '#0ea5e9',
                        600: '#0284c7',
                        700: '#0369a1',
                        800: '#075985',
                        900: '#0c4a6e',
                    },
                    secondary: {
                        50: '#f8fafc',
                        100: '#f1f5f9',
                        200: '#e2e8f0',
                        300: '#cbd5e1',
                        400: '#94a3b8',
                        500: '#64748b',
                        600: '#475569',
                        700: '#334155',
                        800: '#1e293b',
                        900: '#0f172a',
                    }
                },
                animation: {
                    'fade-in': 'fadeIn 0.3s ease-in-out',
                    'slide-down': 'slideDown 0.3s ease-out',
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' },
                    },
                    slideDown: {
                        '0%': { transform: 'translateY(-10px)', opacity: '0' },
                        '100%': { transform: 'translateY(0)', opacity: '1' },
                    },
                },
            },
        },
    }

    // API Helper with Extended Timeout (120 seconds for slow backend)
    const API_TIMEOUT = 120000; // 120 seconds
    
    // Enhanced fetch with timeout
    window.fetchWithTimeout = async function(url, options = {}, timeout = API_TIMEOUT) {
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
    };

    // Helper to override default fetch with timeout (optional - use fetchWithTimeout explicitly for better control)
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        // If timeout is not specified, use default extended timeout
        if (!options.signal) {
            return window.fetchWithTimeout(url, options, API_TIMEOUT);
        }
        return originalFetch(url, options);
    };
</script>
