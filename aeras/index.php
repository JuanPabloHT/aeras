<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aeras - Monitor de Calidad del Aire</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2C3E50; 
            color: white;
            text-align: center;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin: 0;
            font-size: 66px;
        }
        p {
            font-size: 18px;
            margin-top: 10px;
            font-weight: 300;
        }
        main {
            padding: 30px;
        }
        section {
            margin-bottom: 30px;
        }
        .data-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            margin-top: 15px;
            color: #34495E; 
        }
        .status-safe {
            color: #27AE60; 
        }
        .status-warning {
            color: #F39C12; 
        }
        .status-danger {
            color: #E74C3C; 
        }
        h2 {
            color: #2C3E50; 
            font-size: 24px;
            margin-bottom: 15px;
        }
        .data-box strong {
            color: #2980B9; 
        }
        .data-box div {
            margin-bottom: 10px;
        }
        .data-box span {
            font-weight: bold;
        }
        .footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }
    </style>
    <script>
     
        async function fetchCurrentData() {
            const response = await fetch('getCurrentData.php');
            const data = await response.json();
            const display = document.getElementById('current-data');

            if (data.error) {
                display.innerText = "No hay datos disponibles";
            } else {
                const ppm = data.co2;
                const status = getAirQualityStatus(ppm);

                display.innerHTML = `
                    <strong>Midiendo:</strong> Concentración de gases <br>
                    <strong>Nivel:</strong> ${ppm} ppm <br>
                    <strong>Estado:</strong> <span class="${status.class}">${status.message}</span> <br>
                    <strong>Fecha y hora:</strong> ${data.timestamp}
                `;
            }
        }


        function getAirQualityStatus(ppm) {
            if (ppm > 5000) {
                return { message: "Exposición prolongada peligrosa", class: "status-danger" };
            } else if (ppm > 2000) {
                return { message: "Efectos negativos para la salud", class: "status-danger" };
            } else if (ppm > 1200) {
                return { message: "Ventilación necesaria", class: "status-warning" };
            } else if (ppm > 1000) {
                return { message: "Ventilación requerida", class: "status-warning" };
            } else if (ppm > 800) {
                return { message: "Nivel aceptable", class: "status-safe" };
            } else if (ppm > 600) {
                return { message: "Clima interior saludable", class: "status-safe" };
            } else {
                return { message: "Nivel de aire exterior saludable", class: "status-safe" };
            }
        }

        
        async function fetchHistory() {
            const response = await fetch('getHistory.php');
            const data = await response.json();
            const display = document.getElementById('history');

            if (data.error) {
                display.innerText = "No hay datos históricos disponibles";
            } else {
                display.innerHTML = data.map(row => `
                    <div>
                        <strong>Midiendo:</strong> Concentración de gases - 
                        <strong>Nivel:</strong> ${row.co2} ppm - 
                        <strong>Fecha:</strong> ${row.timestamp}
                    </div>
                `).join('');
            }
        }

        window.onload = () => {
            fetchCurrentData();
            fetchHistory();
        };
    </script>
</head>
<body>
    <header>
        <h1>Aeras</h1>
        <p>Monitor de Calidad del Aire</p>
    </header>
    <main>
        <section>
            <h2>Dispositivo 1 - Estado Actual</h2>
            <div id="current-data" class="data-box">Cargando...</div>
        </section>
        <section>
            <h2>Dispositivo 1 - Historial</h2>
            <div id="history" class="data-box">Cargando...</div>
        </section>
    </main>
</body>
</html>
