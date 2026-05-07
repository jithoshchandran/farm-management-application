<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function show($tag_number)
    {
        $cow = Cow::where('tag_number', $tag_number)->firstOrFail();
        
        $latestMilk = $cow->milkProductions()->latest('date')->first();
        
        return view('animal', compact('cow', 'latestMilk'));
    }
}
