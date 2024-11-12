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

            let sehatCount = 0;
            let tidakSehatCount = 0;
            let kurangSehatCount = 0;

            filteredData.forEach(item => {
                if (item.KondisiJantung === 'SEHAT') {
                    sehatCount++;
                } else if (item.KondisiJantung === 'TIDAK SEHAT') {
                    tidakSehatCount++;
                } else if (item.KondisiJantung === 'KURANG SEHAT') {
                    kurangSehatCount++;
                }
            });

            const total = sehatCount + tidakSehatCount + kurangSehatCount;
            const sehatPercentage = total > 0 ? (sehatCount / total) * 100 : 0;
            const tidakSehatPercentage = total > 0 ? (tidakSehatCount / total) * 100 : 0;
            const kurangSehatPercentage = total > 0 ? (kurangSehatCount / total) * 100 : 0;

            chartStatusKesehatan.data.datasets[0].data = [sehatPercentage, tidakSehatPercentage, kurangSehatPercentage];
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
