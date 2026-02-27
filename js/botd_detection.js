/**
 * BotD (Bot Detection) Integration for YellowCloaker
 * Detects automation tools, browser spoofing, and virtual machines
 *
 * Uses FingerprintJS BotD library (free, open-source)
 * CDN: https://openfpcdn.io/botd/v2
 */

(function() {
    'use strict';

    // Load BotD from CDN and run detection
    function runBotDetection() {
        import('https://openfpcdn.io/botd/v2')
            .then(function(Botd) {
                return Botd.load({ monitoring: false }); // Disable telemetry
            })
            .then(function(botDetector) {
                return botDetector.detect();
            })
            .then(function(result) {
                // Send bot detection result to server
                sendBotDetectionResult(result);
            })
            .catch(function(error) {
                console.error('BotD detection failed:', error);
            });
    }

    // Send bot detection result to server
    function sendBotDetectionResult(result) {
        var data = {
            bot: result.bot ? 1 : 0,
            botKind: result.botKind || '',
            components: JSON.stringify(result.components || {})
        };

        // Send via beacon API (non-blocking)
        if (navigator.sendBeacon) {
            var formData = new FormData();
            for (var key in data) {
                formData.append(key, data[key]);
            }
            navigator.sendBeacon('/botd_result.php', formData);
        } else {
            // Fallback to XHR
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/botd_result.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            var params = [];
            for (var key in data) {
                params.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
            }
            xhr.send(params.join('&'));
        }
    }

    // Run detection when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runBotDetection);
    } else {
        runBotDetection();
    }
})();
