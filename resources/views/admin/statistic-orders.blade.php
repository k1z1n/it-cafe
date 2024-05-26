@extends('admin.template')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container">
        <h2 class="text-3xl font-bold my-6">Статистика по количеству заказов</h2>
    <canvas id="myChart"></canvas>
    </div>

    <script>
        // Получаем данные о самых популярных продуктах по месяцам
        let popularProductsByMonth = {!! $popularProductsByMonth !!};

        // Преобразуем данные в формат, подходящий для Chart.js
        let chartData = {
            labels: [],
            datasets: []
        };

        let productIds = [];

        popularProductsByMonth.forEach((row) => {
            let month = row.month + '/' + row.year;

            if (!chartData.labels.includes(month)) {
                chartData.labels.push(month);
            }

            if (!productIds.includes(row.product_id)) {
                productIds.push(row.product_id);
                chartData.datasets.push({
                    label: 'Product ' + row.product_id,
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                });
            }

            let index = productIds.indexOf(row.product_id);
            chartData.datasets[index].data.push(row.total_orders);
        });

        // Создаем график с помощью Chart.js
        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
