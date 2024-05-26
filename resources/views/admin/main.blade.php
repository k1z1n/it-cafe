@extends('admin.template')
@section('content')
    <div class="container mt-3 flex flex-col gap-5">
        <div class="grid grid-cols-4 gap-5 mt-5">
            <div class="flex flex-col items-start shadow-custom bg-white rounded-2xl px-4 py-4 gap-2">
                <img src="{{ asset('/img/see.svg') }}" alt="" class="h-5">
                <div class="font-bold text-2xl text-black">{{ $totalVisits }}</div>
                <div class="text-sm font-medium text-[#64748b]">Количество посещений</div>
            </div>
            <div class="flex flex-col items-start shadow-custom bg-white rounded-2xl px-4 py-4 gap-2">
                <img src="{{ asset('/img/buy-admin.svg') }}" alt="" class="h-5">
                <div class="font-bold text-2xl text-black">{{ $totalDeliveredOrders }} ₽</div>
                <div class="text-sm font-medium text-[#64748b]">Общая прибыль</div>
            </div>
            <div class="flex flex-col items-start shadow-custom bg-white rounded-2xl px-4 py-4 gap-2">
                <img src="{{ asset('/img/cart-admin.svg') }}" alt="" class="h-5">
                <div class="font-bold text-2xl text-black">{{ $productsCount }}</div>
                <div class="text-sm font-medium text-[#64748b]">Всего товаров</div>
            </div>
            <div class="flex flex-col items-start shadow-custom bg-white rounded-2xl px-4 py-4 gap-2">
                <img src="{{ asset('/img/users.svg') }}" alt="" class="h-5">
                <div class="font-bold text-2xl text-black">{{ $usersCount }}</div>
                <div class="text-sm font-medium text-[#64748b]">Всего пользователей</div>
            </div>
        </div>
        <div class="w-full h-[500px] flex gap-5">
            <div class="w-3/4 h-full shadow-custom bg-white rounded-2xl px-4 py-4">
                <canvas id="weeklyChart"></canvas>
            </div>
            <div class="w-1/4 h-full shadow-custom bg-white rounded-2xl px-4 py-4">
                <canvas id="dailyChart" class="h-full"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('weeklyChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($weeklyVisits as $visit)
                        '{{ $visit->dayOfWeek }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Посещения',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [
                        @foreach($weeklyVisits as $visit)
                            {{ $visit->count }},
                        @endforeach
                    ]
                }]
            },
            options: {}
        });

        var ctx = document.getElementById('dailyChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Сегодня'],
                datasets: [{
                    label: 'Посещения',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    data: [{{ $dailyVisits ? $dailyVisits->count : 0 }}]
                }]
            },
            options: {}
        });
    </script>
@endsection
