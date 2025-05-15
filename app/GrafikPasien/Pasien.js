document.addEventListener('DOMContentLoaded', (event) => {
    const showChart = document.getElementById('ChartPasien').getAttribute('data-showchart') === 'true';

    if (showChart) {
        let selectedInterval = "all"; 
        const ctx = document.getElementById('ChartPasien').getContext('2d');
        const chartJantung = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Detak Jantung',
                    data: [],
                    borderColor: 'lightblue',
                    backgroundColor: 'rgba(173, 216, 230, 0.2)',
                    fill: true,
                    tension: 0.3,
                    spanGaps: true
                },
                {
                    label: 'Saturasi Oksigen',
                    data: [],
                    borderColor: 'lightgreen',
                    backgroundColor: 'rgba(144, 238, 144, 0.2)',
                    fill: true,
                    tension: 0.3,
                    spanGaps: true
                }]
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

        const ctxPie = document.getElementById('ChartPiePasien').getContext('2d');
        const chartStatusKesehatan = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Normal', 'Tidak Normal', 'Kurang Normal'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['lightgreen', 'lightcoral', '#FFB347']
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

        document.getElementById('filterDropdown-pasien').addEventListener('click', function(e) {
            if (e.target && e.target.nodeName === "A") {
                const dropdownItems = document.querySelectorAll('#filterDropdown-pasien a');
                dropdownItems.forEach(item => {
                    item.classList.remove('active');
                });

                e.target.classList.add('active');
                selectedInterval = e.target.getAttribute('data-interval');
                fetchDataAndUpdate();
            }
        });

        function updateChart(chart, data) {
            let filteredData = filterDataByInterval(data);

            let waktu = [];
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

        function updatePieChart(data) {
            let filteredData = filterDataByInterval(data);

            let normalCount = 0;
            let tidakNormalCount = 0;
            let kurangNormalCount = 0;

            filteredData.forEach(item => {
                if (item.KondisiJantung === 'Normal') {
                    normalCount++;
                } else if (item.KondisiJantung === 'Tidak Normal') {
                    tidakNormalCount++;
                } else if (item.KondisiJantung === 'Kurang Normal') {
                    kurangNormalCount++;
                }
            });

            const total = normalCount + tidakNormalCount + kurangNormalCount;
            const normalPercentage = total > 0 ? (normalCount / total) * 100 : 0;
            const tidakNormalPercentage = total > 0 ? (tidakNormalCount / total) * 100 : 0;
            const kurangNormalPercentage = total > 0 ? (kurangNormalCount / total) * 100 : 0;

            chartStatusKesehatan.data.datasets[0].data = [normalPercentage, tidakNormalPercentage, kurangNormalPercentage];
            chartStatusKesehatan.update();
        }

        function filterDataByInterval(data) {
            const now = new Date();
            if (selectedInterval === "all") {
                return data;
            } else if (selectedInterval == 15) {
                return data.slice(-60);
            } else if (selectedInterval == 30) {
                return data.slice(-120);
            } else if (selectedInterval == 60) {
                return data.slice(-240);
            }
        }

        function fetchDataAndUpdate() {
            fetch('GrafikPasien/DataPasien.php')
                .then(response => response.json())
                .then(data => {
                    updateChart(chartJantung, data);
                    updatePieChart(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        fetchDataAndUpdate();
        setInterval(fetchDataAndUpdate, 3000);        
    }
});
