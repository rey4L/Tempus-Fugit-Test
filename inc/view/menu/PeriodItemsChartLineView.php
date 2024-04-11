<?php
    include __DIR__."/../NavbarView.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Line Chart</title>
    <link rel="stylesheet" href="<?=CSS_URL."graph-view.css"?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>


    <input type="hidden" name="data" id="data" value="<?=$data['data']?>">
    <input type="hidden" name="labels" id="labels" value="<?=$data['labels']?>">
    <input type="hidden" name="start" id="start" value="<?=$data['start']?>">
    <input type="hidden" name="end" id="end" value="<?=$data['end']?>">



    <div class="graph-div">
        <form action="<?=BASE_URL."/menuitem/showMostSoldWithinPeriod"?>" method="POST">
            <input type="hidden" name="start-date" id="start-date" value="<?=$data['start']?>">
            <input type="hidden" name="end-date" id="end-date" value="<?=$data['end']?>">
            <button class="switch-graph-button" type="submit">Switch Graph</button>
        </form>
       
        <canvas id="myChart"></canvas>
    </div>

    <form class="back-to-register-form" action="<?=BASE_URL."/menuitem"?>">
        <button class="graph-back-button" type="submit">Back to Menu</button>
    </form>

    <script>

        let rawData = document.getElementById('data').value;
        let data = rawData.split(",");

        let rawLabels = document.getElementById('labels').value;
        let labels = rawLabels.split(",");

        let start = document.getElementById('start').value;
        let end = document.getElementById('end').value;

        let dataArr = []

        for(let i = 0; i < data.length; i++){
            let dataObj = {
                label: labels[i],
                borderColor: generateRandomColor(),
                data: data[i].split("-"),
                fill: false,
            }

            dataArr.push(dataObj);
        }

        var dataConfig = {
            labels: fillArrayWithDates(start, end),
            datasets: dataArr
        };

        var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Multi-Line Chart Example'
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        ticks: {
                            maxRotation: 0, 
                            minRotation: 0 
                        }
                    }
                }
            }
        };

        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: dataConfig,
            options: options
        });

        function fillArrayWithDates(startDate, endDate) {
            var dateArray = [];
            var currentDate = new Date(startDate);

            function formatDate(date) {
                var year = date.getFullYear();
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                var day = ('0' + (date.getDate() + 1)).slice(-2);
                return year + '-' + month + '-' + day;
            }

            while (currentDate <= new Date(endDate)) {
                dateArray.push(formatDate(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return dateArray;
        }

        function generateRandomColor() {
            var r = Math.floor(Math.random() * 256);
            var g = Math.floor(Math.random() * 256);
            var b = Math.floor(Math.random() * 256);

            // Ensure a minimum brightness level
            var brightness = 0.7;
            var minBrightness = 255 * brightness;

            // Adjust values to meet minimum brightness
            while ((r + g + b) < minBrightness) {
                r = Math.floor(Math.random() * 256);
                g = Math.floor(Math.random() * 256);
                b = Math.floor(Math.random() * 256);
            }

            return 'rgb(' + r + ', ' + g + ', ' + b + ')';
        }



    </script>
</body>
</html>
