@php
    $record = $record ?? $getRecord();
    $tree = $record->pedigree_tree;
    
    $getAncestorInfo = function ($entity) {
        if (!$entity) return [
            'name' => 'Unknown',
            'breed' => '-',
            'photo' => null,
            'location' => '-',
            'age' => '-',
            'details' => '-',
            'is_local' => false
        ];
        
        if (is_array($entity)) {
            return [
                'name' => $entity['name'] ?? 'Unknown Outside',
                'breed' => $entity['breed'] ?? '-',
                'photo' => ($entity['photo'] ?? null) ? asset('storage/' . $entity['photo']) : null,
                'location' => $entity['location'] ?? '-',
                'age' => $entity['age'] ?? '-',
                'details' => $entity['description'] ?? '-',
                'is_local' => false
            ];
        }
        
        return [
            'name' => $entity->name ?? $entity->tag_number,
            'breed' => $entity->breed->name ?? '-',
            'photo' => $entity->thumbnail ? asset('storage/' . $entity->thumbnail) : null,
            'location' => 'Local Farm',
            'age' => $entity->age ?? '-',
            'details' => $entity->tag_number,
            'is_local' => true
        ];
    };

    $sire = $getAncestorInfo($tree['sire']);
    $pGrandSire = $getAncestorInfo($tree['p_grand_sire']);
    $dam = $getAncestorInfo($tree['dam']);
    $mGrandMother = $getAncestorInfo($tree['m_grand_mother']);
@endphp

<div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
    <div class="overflow-x-auto">
        <div class="min-w-[800px] py-8">
            <div class="flex items-center justify-between gap-8 relative">
                
                {{-- Column 1: Grandparents --}}
                <div class="flex flex-col justify-between gap-12 w-64 z-10">
                    {{-- Paternal Grand Father --}}
                    <div class="bg-gray-50 border border-blue-100 p-3 rounded-lg text-center relative">
                        <div class="text-[10px] font-bold text-blue-500 uppercase mb-1">Grand Father (P)</div>
                        @if($pGrandSire['photo'])
                            <img src="{{ $pGrandSire['photo'] }}" class="w-10 h-10 rounded-full mx-auto mb-1 object-cover border border-blue-200">
                        @endif
                        <div class="text-xs font-bold truncate">{{ $pGrandSire['name'] }}</div>
                        <div class="text-[9px] text-gray-500">{{ $pGrandSire['breed'] }}</div>
                        <div class="absolute -right-4 top-1/2 w-4 border-t border-gray-300"></div>
                    </div>

                    {{-- Maternal Grand Mother --}}
                    <div class="bg-gray-50 border border-pink-100 p-3 rounded-lg text-center relative mt-24">
                        <div class="text-[10px] font-bold text-pink-500 uppercase mb-1">Grand Mother (M)</div>
                        @if($mGrandMother['photo'])
                            <img src="{{ $mGrandMother['photo'] }}" class="w-10 h-10 rounded-full mx-auto mb-1 object-cover border border-pink-200">
                        @endif
                        <div class="text-xs font-bold truncate">{{ $mGrandMother['name'] }}</div>
                        <div class="text-[9px] text-gray-500">{{ $mGrandMother['breed'] }}</div>
                        <div class="absolute -right-4 top-1/2 w-4 border-t border-gray-300"></div>
                    </div>
                </div>

                {{-- Vert Lines for Parents --}}
                <div class="absolute left-64 top-[15%] bottom-[15%] w-px border-l border-gray-300 hidden sm:block"></div>

                {{-- Column 2: Parents --}}
                <div class="flex flex-col justify-around gap-20 w-72 z-10">
                    {{-- Father --}}
                    <div class="bg-blue-50 border-2 border-blue-200 p-4 rounded-xl text-center relative">
                        <div class="text-[11px] font-black text-blue-600 uppercase mb-2">Father (Sire)</div>
                        @if($sire['photo'])
                            <img src="{{ $sire['photo'] }}" class="w-14 h-14 rounded-full mx-auto mb-2 object-cover border-2 border-white shadow-sm">
                        @endif
                        <div class="text-base font-bold">{{ $sire['name'] }}</div>
                        <div class="text-xs text-gray-600">{{ $sire['breed'] }} | {{ $sire['location'] }}</div>
                        <div class="mt-1 text-[10px]"><span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">{{ $sire['is_local'] ? 'Local' : 'External' }}</span></div>
                        <div class="absolute -right-4 top-1/2 w-4 border-t-2 border-gray-300"></div>
                    </div>

                    {{-- Mother --}}
                    <div class="bg-pink-50 border-2 border-pink-200 p-4 rounded-xl text-center relative">
                        <div class="text-[11px] font-black text-pink-600 uppercase mb-2">Mother (Dam)</div>
                        @if($dam['photo'])
                            <img src="{{ $dam['photo'] }}" class="w-14 h-14 rounded-full mx-auto mb-2 object-cover border-2 border-white shadow-sm">
                        @endif
                        <div class="text-base font-bold">{{ $dam['name'] }}</div>
                        <div class="text-xs text-gray-600">{{ $dam['breed'] }} | {{ $dam['location'] }}</div>
                        <div class="mt-1 text-[10px]"><span class="bg-pink-100 text-pink-700 px-2 py-0.5 rounded-full">{{ $dam['is_local'] ? 'Local' : 'External' }}</span></div>
                        <div class="absolute -right-4 top-1/2 w-4 border-t-2 border-gray-300"></div>
                    </div>
                </div>

                {{-- Vert Line for Self --}}
                <div class="absolute left-[545px] top-[25%] bottom-[25%] w-px border-l-2 border-gray-300 hidden sm:block"></div>

                {{-- Column 3: Self --}}
                <div class="w-80 z-10">
                    <div class="bg-green-50 border-4 border-green-400 p-6 rounded-2xl text-center shadow-lg transform scale-110">
                        <div class="text-xs font-black text-green-700 uppercase tracking-widest mb-3">Target Animal</div>
                        @if($record->thumbnail)
                            <img src="{{ asset('storage/' . $record->thumbnail) }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-4 border-white shadow-md">
                        @endif
                        <div class="text-2xl font-black text-green-900 leading-tight">{{ $record->name ?? $record->tag_number }}</div>
                        <div class="text-sm text-green-700 font-medium mb-2">{{ $record->breed->name ?? '-' }}</div>
                        <div class="inline-block bg-white text-green-800 text-[10px] font-bold px-3 py-1 rounded-full border border-green-200">
                            TAG: {{ $record->tag_number }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
