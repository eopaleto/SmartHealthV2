document.addEventListener('DOMContentLoaded', (event) => {
    let selectedInterval = "all";
    const charts = [];
    const pieCharts = [];

    for (let i = 1; i <= 4; i++) {
        const ctx = document.getElementById(`ChartPasien${i}`).getContext('2d');
        const ctxPie = document.getElementById(`ChartPiePasien${i}`).getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Detak Jantung',
                        data: [],
                        borderColor: 'lightblue',
                        backgroundColor: 'rgba(173, 216, 230, 0.2)',
                        fill: true,
                        tension: 0.3,
                        spanGaps: true,
                        skipNull: true
                    },
                    {
                        label: 'Saturasi Oksigen',
                        data: [],
                        borderColor: 'lightgreen',
                        backgroundColor: 'rgba(144, 238, 144, 0.2)',
                        fill: true,
                        tension: 0.3,
                        spanGaps: true,
                        skipNull: true
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 150,
                        ticks: {
                            stepSize: 50
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Grafik Pie
        const pieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Sehat', 'Tidak Sehat', 'Kurang Sehat'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: ['lightgreen', 'lightcoral', '#FFB347', 'lightgrey']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label} : ${value.toFixed(2)}%`;
                            }
                        },
                        displayColors: false
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            return value !== 0 ? value.toFixed(2) + '%' : null;
                        }
                    }      
                }
            },
            plugins: [ChartDataLabels]
        });

        charts.push(chart);
        pieCharts.push(pieChart);
    }

    // Event listener untuk filter
    document.getElementById('filterDropdown').addEventListener('click', function(e) {
        if (e.target && e.target.nodeName === "A") {
            const dropdownItems = document.querySelectorAll('#filterDropdown a');
            dropdownItems.forEach(item => {
                item.classList.remove('active');
            });

            e.target.classList.add('active');

            selectedInterval = e.target.getAttribute('data-interval');
            fetchData(); // Panggil fungsi fetchData
        }
    });

    function fetchData() {
        for (let i = 1; i <= 4; i++) { // Sesuaikan jumlah kamar
            fetch(`GrafikPasien/DataKamar${i}.php?interval=${selectedInterval}`)
                .then(response => response.json())
                .then(data => {
                    updateChart(charts[i - 1], data); // Update grafik garis
                    updatePieChart(pieCharts[i - 1], data); // Update grafik pie
                })
        }
    }

    function updateChart(chart, data) {
        if (data.message === "Tidak ada pasien di kamar" || data.message === "No data available.") {
            chart.data.labels = [];
            chart.data.datasets[0].data = [];
            chart.data.datasets[1].data = [];
            chart.update();
            return;
        }

        let filteredData;

        if (selectedInterval == "all") {
            filteredData = data;
        } else if (selectedInterval == 15) {
            filteredData = data.slice(-60); 
        } else if (selectedInterval == 30) {
            filteredData = data.slice(-120);
        } else if (selectedInterval == 60) {
            filteredData = data.slice(-240);
        }

        let waktu = [];  // Menyimpan waktu lengkap
        let detakJantung = [];
        let saturasiOksigen = [];

        filteredData.forEach(item => {
            const date = new Date(item.Waktu);
            
            const formattedDate = date.toLocaleDateString('id-ID', { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });

            const formattedTime = date.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });

            const formattedDateTime = `${formattedDate} ${formattedTime}`;
            
            waktu.push(formattedDateTime);
            detakJantung.push(item.DetakJantung);
            saturasiOksigen.push(item.SaturasiOksigen);
        });        

        chart.data.labels = waktu;
        chart.data.datasets[0].data = detakJantung;
        chart.data.datasets[1].data = saturasiOksigen;

        chart.options.scales.x.ticks.callback = function(value, index, values) {
            const date = new Date(filteredData[index].Waktu);
            return date.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        };

        chart.update();
    }    
    
    function updatePieChart(chart, data) {
        let sehatCount = 0;
        let tidakSehatCount = 0;
        let kurangSehatCount = 0;

        let filteredData;

        if (selectedInterval == "all") {
            filteredData = data;
        } else if (selectedInterval == 15) {
            filteredData = data.slice(-60); 
        } else if (selectedInterval == 30) {
            filteredData = data.slice(-120);
        } else if (selectedInterval == 60) {
            filteredData = data.slice(-240);
        }

        filteredData.forEach(item => {
            if (item.KondisiJantung) {
                if (item.KondisiJantung === 'SEHAT') {
                    sehatCount++;
                } else if (item.KondisiJantung === 'TIDAK SEHAT') {
                    tidakSehatCount++;
                } else if (item.KondisiJantung === 'KURANG SEHAT') {
                    kurangSehatCount++;
                }
            }
        });

        const total = sehatCount + tidakSehatCount + kurangSehatCount; 
        const sehatPercentage = total > 0 ? (sehatCount / total) * 100 : 0;
        const tidakSehatPercentage = total > 0 ? (tidakSehatCount / total) * 100 : 0;
        const kurangSehatPercentage = total > 0 ? (kurangSehatCount / total) * 100 : 0;

        chart.data.datasets[0].data = [sehatPercentage, tidakSehatPercentage, kurangSehatPercentage];
        chart.update();
    }    

    fetchData(); // Panggil fungsi fetchData saat halaman dimuat
    setInterval(fetchData, 3000); // Refresh data setiap 3 detik
});
