import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const EmberMap = {
    map: null,
    markerLayer: null,
    locations: [],
    language: 'id',

    init() {
        const mapElement = document.getElementById('ember-map');
        const dataElement = document.getElementById('ember-map-data');

        if (!mapElement || !dataElement || mapElement.dataset.initialized === 'true') {
            return;
        }

        mapElement.dataset.initialized = 'true';
        const payload = JSON.parse(dataElement.textContent || '{}');
        const locations = Array.isArray(payload) ? payload : (payload.locations || []);
        this.locations = locations;
        this.language = payload.language === 'en' ? 'en' : 'id';

        this.map = L.map(mapElement, {
            scrollWheelZoom: false,
        }).setView([-2.5, 118], 5);

        L.tileLayer(
            'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
            {
                maxZoom: 20,
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            },
        ).addTo(this.map);

        this.markerLayer = L.layerGroup().addTo(this.map);
        this.renderMarkers(locations, { fitView: true });
        this.initializeYearFilter();
    },

    renderMarkers(locations, { fitView = false } = {}) {
        this.markerLayer.clearLayers();

        const bounds = [];

        locations.forEach((location) => {
            const latitude = Number(location.latitude);
            const longitude = Number(location.longitude);

            if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
                return;
            }

            const confidence = location.confidence;
            const status = this.statusFor(confidence);
            const marker = L.circleMarker([latitude, longitude], {
                radius: 10,
                color: '#ffffff',
                weight: 3,
                fillColor: status.color,
                fillOpacity: 1,
                interactive: true,
                bubblingMouseEvents: false,
            });

            marker.on('click', () => this.showLocationDetail(location, status));
            marker.bindTooltip(
                `${location.desa || (this.language === 'en' ? 'Location point' : 'Titik lokasi')} · ${this.language === 'en' ? 'Click for details' : 'Klik untuk detail'}`,
                { direction: 'top', offset: [0, -8] },
            );
            marker.addTo(this.markerLayer);
            bounds.push([latitude, longitude]);
        });

        const countElement = document.getElementById('map-result-count');
        const emptyElement = document.getElementById('map-filter-empty');

        if (countElement) {
            countElement.textContent = `${locations.length} ${this.language === 'en' ? 'locations' : 'lokasi'}`;
        }

        emptyElement?.classList.toggle('hidden', locations.length > 0);

        if (fitView && bounds.length > 0) {
            this.map.fitBounds(bounds, {
                padding: [36, 36],
                maxZoom: 10,
            });
        } else if (fitView) {
            this.map.setView([-2.5, 118], 5);
        }
    },

    initializeYearFilter() {
        const yearRange = document.getElementById('map-year-range');
        const yearLabel = document.getElementById('map-year-label');
        const yearControl = document.querySelector('.map-year-slider-control');
        const yearMarks = document.querySelectorAll('[data-year-mark]');
        const years = yearRange?.dataset.yearValues
            ? yearRange.dataset.yearValues.split(',').filter(Boolean)
            : [];

        if (!yearRange || !yearLabel || !yearControl) {
            return;
        }

        yearRange.addEventListener('input', () => {
            const selectedIndex = Number(yearRange.value);
            const selectedYear = selectedIndex === years.length ? 'all' : years[selectedIndex];
            const filteredLocations = selectedYear === 'all'
                ? this.locations
                : this.locations.filter((location) =>
                    location.date && String(location.date).slice(0, 4) === selectedYear
                );
            const ratio = Number(yearRange.max) > 0
                ? selectedIndex / Number(yearRange.max)
                : 1;
            const progress = ratio * 100;
            const edgeOffset = (1 - (2 * ratio)) * 1.125;

            yearControl.style.setProperty('--slider-progress', `calc(${progress}% + ${edgeOffset}rem)`);
            yearMarks.forEach((mark) => {
                mark.dataset.active = mark.dataset.yearMark === selectedYear ? 'true' : 'false';
            });
            yearLabel.textContent = selectedYear === 'all'
                ? (this.language === 'en' ? 'All' : 'Semua')
                : selectedYear;
            yearRange.setAttribute('aria-valuetext', yearLabel.textContent);
            this.renderMarkers(filteredLocations, { fitView: false });
            this.closeLocationDetail();
        });

        yearRange.setAttribute('aria-valuetext', yearLabel.textContent);

        document.getElementById('map-detail-close')?.addEventListener('click', () => this.closeLocationDetail());
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                this.closeLocationDetail();
            }
        });
    },

    statusFor(confidence) {
        if (confidence === null || String(confidence).trim() === '') {
            return { label: this.language === 'en' ? 'Unrated' : 'Belum dinilai', color: '#64748b' };
        }

        const value = String(confidence).trim().toLowerCase();
        const numericValue = Number(value);

        if (['high', 'tinggi'].includes(value) || (Number.isFinite(numericValue) && numericValue >= 80)) {
            return { label: this.language === 'en' ? 'High' : 'Tinggi', color: '#ef4444' };
        }

        if (['nominal', 'medium', 'sedang'].includes(value) || (Number.isFinite(numericValue) && numericValue >= 50)) {
            return { label: this.language === 'en' ? 'Medium' : 'Sedang', color: '#f59e0b' };
        }

        return { label: this.language === 'en' ? 'Low' : 'Rendah', color: '#10b981' };
    },

    showLocationDetail(location, status) {
        const panel = document.getElementById('map-detail-panel');

        if (!panel) {
            return;
        }

        const values = {
            title: location.desa || (this.language === 'en' ? 'Village not available' : 'Desa belum tersedia'),
            region: [location.kecamatan, location.kabupaten_kota, location.provinsi].filter(Boolean).join(', ') || '-',
            confidence: location.confidence ?? '-',
            status: status.label,
            province: location.provinsi || '-',
            regency: location.kabupaten_kota || '-',
            district: location.kecamatan || '-',
            village: location.desa || '-',
            date: this.formatDate(location.date),
            coordinates: `${location.latitude}, ${location.longitude}`,
        };

        Object.entries(values).forEach(([key, value]) => {
            const element = document.getElementById(`map-detail-${key}`);

            if (element) {
                element.textContent = value;
            }
        });

        const link = document.getElementById('map-detail-link');
        if (link) {
            link.href = location.detail_url;
        }

        panel.dataset.open = 'true';
        panel.setAttribute('aria-hidden', 'false');
        panel.scrollTop = 0;
        document.getElementById('map-detail-close')?.focus({ preventScroll: true });
    },

    closeLocationDetail() {
        const panel = document.getElementById('map-detail-panel');

        if (!panel) {
            return;
        }

        panel.dataset.open = 'false';
        panel.setAttribute('aria-hidden', 'true');
    },

    formatDate(date) {
        if (!date) {
            return '-';
        }

        return new Intl.DateTimeFormat(this.language === 'en' ? 'en-US' : 'id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        }).format(new Date(`${date}T00:00:00`));
    },
};

document.addEventListener('DOMContentLoaded', () => EmberMap.init());
document.addEventListener('livewire:navigated', () => EmberMap.init());

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy-url]');

    if (!button) {
        return;
    }

    const originalLabel = button.textContent;

    try {
        await navigator.clipboard.writeText(button.dataset.copyUrl);
        button.textContent = 'URL tersalin';
        window.setTimeout(() => {
            button.textContent = originalLabel;
        }, 1600);
    } catch {
        window.prompt('Salin URL foto berikut:', button.dataset.copyUrl);
    }
});

const initializeBackToTop = () => {
    const button = document.getElementById('back-to-top');

    if (!button || button.dataset.initialized === 'true') {
        return;
    }

    button.dataset.initialized = 'true';

    const updateVisibility = () => {
        const isVisible = window.scrollY > 400;

        button.classList.toggle('pointer-events-none', !isVisible);
        button.classList.toggle('opacity-0', !isVisible);
        button.classList.toggle('translate-y-3', !isVisible);
        button.classList.toggle('opacity-100', isVisible);
        button.classList.toggle('translate-y-0', isVisible);
    };

    button.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    window.addEventListener('scroll', updateVisibility, { passive: true });
    updateVisibility();
};

document.addEventListener('DOMContentLoaded', initializeBackToTop);
document.addEventListener('livewire:navigated', initializeBackToTop);

const initializeLocationDetailMap = () => {
    const mapElement = document.getElementById('location-detail-map');
    const dataElement = document.getElementById('location-detail-map-data');

    if (!mapElement || !dataElement || mapElement.dataset.initialized === 'true') {
        return;
    }

    const location = JSON.parse(dataElement.textContent || '{}');
    const latitude = Number(location.latitude);
    const longitude = Number(location.longitude);

    if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
        return;
    }

    mapElement.dataset.initialized = 'true';
    const detailMap = L.map(mapElement, { scrollWheelZoom: false }).setView([latitude, longitude], 11);

    L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        {
            maxZoom: 20,
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        },
    ).addTo(detailMap);

    const confidence = location.confidence;
    const status = EmberMap.statusFor(confidence);

    L.circleMarker([latitude, longitude], {
        radius: 10,
        color: '#ffffff',
        weight: 3,
        fillColor: status.color,
        fillOpacity: 1,
    }).addTo(detailMap);
};

document.addEventListener('DOMContentLoaded', initializeLocationDetailMap);
document.addEventListener('livewire:navigated', initializeLocationDetailMap);
