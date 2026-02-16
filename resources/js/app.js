import './bootstrap';

// Chart.js (render charts on dashboard)
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    // Line chart: tickets per day (dashboard)
    const waitingEl = document.getElementById('waitingChart');
    if (waitingEl) {
        const waitingData = JSON.parse(document.getElementById('waiting-data').textContent || '{}');
        new Chart(waitingEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: waitingData.labels || [],
                datasets: [{
                    label: 'Tickets / jour',
                    data: waitingData.values || [],
                    borderColor: 'rgba(99,102,241,1)',
                    backgroundColor: 'rgba(99,102,241,0.08)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Doughnut chart: queue composition
    const compEl = document.getElementById('compositionChart');
    if (compEl) {
        const compData = JSON.parse(document.getElementById('composition-data').textContent || '{}');
        new Chart(compEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: compData.labels || [],
                datasets: [{
                    data: compData.values || [],
                    backgroundColor: ['#06b6d4','#6366f1','#10b981','#f59e0b','#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Render Lucide icons if available (we inject lucide via CDN in layout)
    if (window.lucide && typeof lucide.replace === 'function') {
        lucide.replace();
    }
});
