<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cow->name ?? $cow->tag_number }} - Quick View</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-8">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ $cow->status }}</div>
            <h1 class="block mt-1 text-lg leading-tight font-medium text-black">{{ $cow->name ?? 'Cow ' . $cow->tag_number }}</h1>
            <p class="mt-2 text-gray-500">Tag: {{ $cow->tag_number }}</p>
            
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <span class="block text-xs text-blue-600 font-bold uppercase">Breed</span>
                    <span class="block text-lg font-semibold">{{ $cow->breed ?? 'N/A' }}</span>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                     <span class="block text-xs text-green-600 font-bold uppercase">Latest Milk</span>
                     <span class="block text-lg font-semibold">{{ $latestMilk ? $latestMilk->total_yield . ' L' : 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <h2 class="text-gray-900 font-bold">Health Status</h2>
                <div class="mt-2 text-gray-600">
                    Next Heat: {{ $cow->next_expected_heat ? $cow->next_expected_heat->format('d M Y') : 'N/A' }}
                </div>
                 <div class="mt-2 text-gray-600">
                    Last Calving: {{ $cow->last_calving_date ? $cow->last_calving_date->format('d M Y') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
