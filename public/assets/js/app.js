document.addEventListener('DOMContentLoaded', () => {
    const activityFeed = document.querySelector('#activity-feed');
    const shipmentCards = document.querySelectorAll('[data-tracking]');
    const trackingPanel = document.querySelector('.tracking-details[data-tracking]');

    const escapeSelector = (value) => {
        if (window.CSS && typeof window.CSS.escape === 'function') {
            return window.CSS.escape(value);
        }

        return `${value}`.replace(/[^a-zA-Z0-9_-]/g, '\\$&');
    };

    const updateShipments = (shipments) => {
        shipments.forEach((shipment) => {
            const card = document.querySelector(`[data-tracking="${escapeSelector(shipment.tracking_number)}"]`);
            if (!card) {
                return;
            }

            const statusBadge = card.querySelector('.badge');
            if (statusBadge) {
                statusBadge.textContent = shipment.status;
            }

            const timeline = card.querySelector('.timeline');
            if (timeline && shipment.events) {
                timeline.innerHTML = shipment.events.map((event) => (
                    `<div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <p class="timeline-time">${formatDate(event.event_time)}</p>
                            <h4>${escapeHtml(event.status)}</h4>
                            ${event.location ? `<p class="muted">Location: ${escapeHtml(event.location)}</p>` : ''}
                            ${event.details ? `<p>${escapeHtml(event.details)}</p>` : ''}
                        </div>
                    </div>`
                )).join('');
            }
        });
    };

    const updateActivityFeed = (shipments) => {
        if (!activityFeed) {
            return;
        }

        const events = [];
        shipments.forEach((shipment) => {
            shipment.events.forEach((event) => {
                events.push({
                    ...event,
                    shipment: shipment.title,
                });
            });
        });

        events.sort((a, b) => new Date(b.event_time) - new Date(a.event_time));
        const recent = events.slice(0, 8);

        activityFeed.innerHTML = recent.map((event) => (
            `<li>
                <div>
                    <p class="muted">${formatDate(event.event_time)}</p>
                    <strong>${escapeHtml(event.status)}</strong>
                    <p>${escapeHtml(event.shipment)}</p>
                    ${event.location ? `<span class="muted">${escapeHtml(event.location)}</span>` : ''}
                </div>
            </li>`
        )).join('');
    };

    const fetchActivity = () => {
        if (!shipmentCards.length) {
            return;
        }

        fetch('api/activity.php', {
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
            },
        })
            .then((response) => response.ok ? response.json() : Promise.reject())
            .then((data) => {
                if (!data.shipments) {
                    return;
                }

                updateShipments(data.shipments);
                updateActivityFeed(data.shipments);
            })
            .catch(() => {
                /* Silent fail: keep existing content */
            });
    };

    const fetchTracking = () => {
        if (!trackingPanel) {
            return;
        }

        const trackingNumber = trackingPanel.getAttribute('data-tracking');
        if (!trackingNumber) {
            return;
        }

        fetch(`api/track.php?tracking=${encodeURIComponent(trackingNumber)}`, {
            headers: {
                'Accept': 'application/json',
            },
        })
            .then((response) => response.ok ? response.json() : Promise.reject())
            .then((data) => {
                if (!data.shipment || !data.events) {
                    return;
                }

                const statusBadge = trackingPanel.querySelector('.badge');
                if (statusBadge) {
                    statusBadge.textContent = data.shipment.status;
                }

                const lastUpdated = trackingPanel.querySelector('.tracking-meta article:nth-child(3) p:nth-child(2)');
                if (lastUpdated) {
                    lastUpdated.textContent = formatDate(data.shipment.last_status_at);
                }

                const timeline = trackingPanel.querySelector('.timeline');
                if (timeline) {
                    timeline.innerHTML = data.events.map((event) => (
                        `<div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <p class="timeline-time">${formatDate(event.event_time)}</p>
                                <h3>${escapeHtml(event.status)}</h3>
                                ${event.location ? `<p class="muted">Location: ${escapeHtml(event.location)}</p>` : ''}
                                ${event.details ? `<p>${escapeHtml(event.details)}</p>` : ''}
                            </div>
                        </div>`
                    )).join('');
                }
            })
            .catch(() => {
                /* Ignore errors */
            });
    };

    if (shipmentCards.length) {
        fetchActivity();
        setInterval(fetchActivity, 30000);
    }

    if (trackingPanel) {
        fetchTracking();
        setInterval(fetchTracking, 30000);
    }
});

function formatDate(value) {
    if (!value) {
        return '';
    }

    const date = new Date(value.replace(' ', 'T'));
    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return date.toLocaleString();
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.innerText = value ?? '';
    return div.innerHTML;
}

