document.addEventListener('DOMContentLoaded', () => {

    const ctx = document.getElementById('ChartJantungSemua').getContext('2d');
    const chartJantung = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Kamar 1',
                    data: [],
                    borderColor: 'lightblue',
                    backgroundColor: 'rgba(173, 216, 230, 0.2)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Kamar 2',
                    data: [],
                    borderColor: 'lightgreen',
                    backgroundColor: 'rgba(144, 238, 144, 0.2)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Kamar 3',
                    data: [],
                    borderColor: 'lightcoral',
                    backgroundColor: 'rgba(240, 128, 128, 0.2)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Kamar 4',
                    data: [],
                    borderColor: 'lightsalmon',
                    backgroundColor: 'rgba(255, 218, 185, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    interaction: {
                        mode: 'nearest',
                        intersect: false,
                    },
                    callbacks: {
                        label: function (context) {
                            const dataPoint = context.raw;
                            const detakJantung = dataPoint.detakJantung;
                            const saturasiOksigen = dataPoint.saturasiOksigen;
                            const idPasien = dataPoint.id_pasien;
                            const namaPasien = dataPoint.nama_pasien;
                            return [
                                `Nama Pasien: ${namaPasien}`,
                                `ID Pasien: ${idPasien}`,
                                `Detak Jantung: ${detakJantung} Bpm`,
                                `Saturasi Oksigen: ${saturasiOksigen} %`
                            ];
                        }
                    }
                },
                legend: {
                    display: false,
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

    let selectedRoom = 'all'; 

    document.getElementById('filterpasien').addEventListener('click', function (e) {
        const selected = e.target.getAttribute('data-interval');
        if (selected) {
            selectedRoom = selected;
            document.querySelectorAll('#filterpasien a').forEach(item => item.classList.remove('active'));
            e.target.classList.add('active');
            fetchData();
        }
    });

    function fetchData() {
        fetch('GrafikPasien/DataAll.php')
            .then(response => response.json())
            .then(data => {
                updateChart(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateChart(data) {
        let waktu = [];

        chartJantung.data.datasets.forEach(dataset => {
            dataset.data = [];
        });

        data.forEach(item => {
            const dataPoint = {
                y: item.DetakJantung,
                x: item.Waktu,
                detakJantung: item.DetakJantung,
                saturasiOksigen: item.SaturasiOksigen,
                id_pasien: item.id_pasien,
                nama_pasien: item.nama_pasien
            };

            if (selectedRoom === 'all' || selectedRoom === getRoomIndex(item.nama_ruang)) {
                if (!waktu.includes(item.Waktu)) {
                    waktu.push(item.Waktu);
                }

                switch (item.nama_ruang) {
                    case 'Melati':
                        chartJantung.data.datasets[0].data.push(dataPoint);
                        break;
                    case 'Mawar':
                        chartJantung.data.datasets[1].data.push(dataPoint);
                        break;
                    case 'Anggrek':
                        chartJantung.data.datasets[2].data.push(dataPoint);
                        break;
                    case 'Copere':
                        chartJantung.data.datasets[3].data.push(dataPoint);
                        break;
                    default:
                        console.log('Ruangan tidak dikenal:', item.nama_ruang);
                }
            }
        });

        waktu.sort();
        chartJantung.data.labels = waktu;
        chartJantung.update();
    }

    function getRoomIndex(roomName) {
        switch (roomName) {
            case 'Melati': return '1';
            case 'Mawar': return '2';
            case 'Anggrek': return '3';
            case 'Copere': return '4';
            default: return 'unknown';
        }
    }

    fetchData(); 
    setInterval(fetchData, 3000);
});
