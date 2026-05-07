<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Farm Summary</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap');
        
        body { 
            font-family: 'Outfit', 'Segoe UI', sans-serif; 
            line-height: 1.6; 
            color: #1e293b; 
            margin: 0; 
            padding: 0; 
            background-color: #f8fafc; 
        }
        
        .container { 
            max-width: 600px; 
            margin: 30px auto; 
            background: #ffffff; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.08); 
        }
        
        .header { 
            background: linear-gradient(135deg, #059669 0%, #10b981 100%); 
            color: #ffffff; 
            padding: 40px 30px; 
            text-align: center;
            position: relative;
        }
        
        .header h1 { 
            margin: 0; 
            font-size: 26px; 
            font-weight: 700; 
            letter-spacing: -0.02em;
        }
        
        .header p { 
            margin: 10px 0 0; 
            opacity: 0.9; 
            font-size: 15px;
            font-weight: 400;
        }
        
        .content { padding: 35px 30px; }
        
        .section-title { 
            font-size: 13px; 
            font-weight: 700; 
            color: #059669; 
            text-transform: uppercase; 
            letter-spacing: 0.1em; 
            margin: 30px 0 15px;
            display: flex;
            align-items: center;
        }
        
        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
            margin-left: 15px;
        }

        /* KPI Cards */
        .grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0;
        }
        
        .card {
            width: 48%; /* Ensure two cards per row with a small gap */
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 20px 0;
            margin-bottom: 15px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
        }
        
        .card-icon { font-size: 24px; margin-bottom: 8px; display: block; }
        .card-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .card-value { font-size: 20px; color: #0f172a; font-weight: 700; display: block; margin-top: 4px; }
        
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 5px;
        }
        .badge-positive { background: #dcfce7; color: #166534; }
        .badge-negative { background: #fee2e2; color: #991b1b; }

        /* Rows */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 8px;
            box-sizing: border-box;
        }
        
        .info-label { font-size: 14px; color: #475569; font-weight: 500; }
        .info-value { font-size: 14px; color: #0f172a; font-weight: 700; }
        
        .alert-box { 
            background: #fffbeb; 
            border-left: 4px solid #f59e0b; 
            padding: 15px 20px; 
            border-radius: 12px; 
            margin: 20px 0; 
            color: #92400e;
        }
        
        .alert-box strong { display: block; margin-bottom: 5px; font-size: 14px; }
        .alert-box p { margin: 0; font-size: 13px; line-height: 1.4; }

        .footer { 
            background: #f1f5f9; 
            padding: 30px; 
            text-align: center; 
            font-size: 12px; 
            color: #64748b; 
        }
        
        .footer b { color: #0f172a; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1 style="color: #ffffff;">🐄 Daily Farm Summary</h1>
            <p style="color: #ffffff;">{{ $date }} • <b>{{ config('app.name') }}</b></p>
        </div>
        
        <div class="content">
            <!-- Key Performance Indicators -->
            <div class="section-title">Performance Snapshots</div>
            <div class="grid">
                <div class="card">
                    <span class="card-icon">🥛</span>
                    <span class="card-label">Total Milk</span>
                    <span class="card-value">{{ $totalMilk }} L</span>
                    @if($milkDiff != 0)
                        <span class="badge {{ $milkDiff > 0 ? 'badge-positive' : 'badge-negative' }}">
                            {{ $milkDiff > 0 ? '↑' : '↓' }} {{ abs($milkDiff) }}%
                        </span>
                    @endif
                </div>
                <div class="card">
                    <span class="card-icon">💸</span>
                    <span class="card-label">Expenses</span>
                    <span class="card-value">${{ number_format($totalExpenses, 2) }}</span>
                </div>
                <div class="card">
                    <span class="card-icon">🏥</span>
                    <span class="card-label">Active Treatments</span>
                    <span class="card-value">{{ $activeTreatmentsCount }} Cows</span>
                </div>
                <div class="card">
                    <span class="card-icon">🧬</span>
                    <span class="card-label">Pending Inseminations</span>
                    <span class="card-value">{{ $pendingInseminationsCount }}</span>
                </div>
            </div>

            <!-- Detailed Milk Data -->
            <div class="section-title">Milk Production Details</div>
            <div class="info-row">
                <span class="info-label">Morning Shift Total</span>
                <span class="info-value">{{ $morningTotal }} L</span>
            </div>
            <div class="info-row">
                <span class="info-label">Evening Shift Total</span>
                <span class="info-value">{{ $eveningTotal }} L</span>
            </div>
            <div class="info-row">
                <span class="info-label">Daily Average / Cow</span>
                <span class="info-value">{{ $avgMilkPerCow }} L</span>
            </div>
            @if($topPerformer)
            <div class="info-row" style="background: #ecfdf5; border: 1px solid #dcfce7;">
                <span class="info-label" style="color: #065f46;">⭐ Top Performer</span>
                <span class="info-value" style="color: #065f46;">{{ $topPerformer->cow->full_name ?? 'N/A' }} ({{ $topPerformer->total_yield }} L)</span>
            </div>
            @endif

            <!-- Health & Breeding -->
            <div class="section-title">Health & Breeding</div>
            @if(count($treatmentsStarted) > 0)
                @foreach($treatmentsStarted as $treatment)
                <div class="info-row">
                    <span class="info-label">🆕 Treatment: {{ $treatment->cow->full_name }}</span>
                    <span class="info-value">{{ $treatment->diagnosis }}</span>
                </div>
                @endforeach
            @endif
            
            <div class="info-row">
                <span class="info-label">💉 Vaccinations Administered</span>
                <span class="info-value">{{ $vaccinationsCount }} Doses</span>
            </div>
            
            @if(count($withdrawalAlerts) > 0)
            <div class="alert-box">
                <strong>⚠️ MILK WITHDRAWAL ALERT</strong>
                <p>The following cows are currently under withdrawal status: {{ implode(', ', $withdrawalAlerts) }}. Ensure their milk is discarded.</p>
            </div>
            @endif

            @if(count($upcomingCalvings) > 0)
                @foreach($upcomingCalvings as $calving)
                <div class="info-row" style="background: #eff6ff; border: 1px solid #dbeafe;">
                    <span class="info-label" style="color: #1e40af;">👶 Upcoming Calving: {{ $calving->cow->full_name }}</span>
                    <span class="info-value" style="color: #1e40af;">in {{ round(abs($calving->expected_calving_date->diffInDays(now(), false))) }} Days</span>
                </div>
                @endforeach
            @endif

            <!-- Financials -->
            <div class="section-title">Financial Summary</div>
            @if($majorExpense)
            <div class="info-row">
                <span class="info-label">💰 Major: {{ $majorExpense->description ?? ($majorExpense->item->name ?? 'Expense') }}</span>
                <span class="info-value">${{ number_format($majorExpense->amount, 2) }}</span>
            </div>
            @endif
            
            @foreach($otherExpenses as $expense)
            <div class="info-row">
                <span class="info-label">💸 Other: {{ $expense->description ?? ($expense->item->name ?? 'General') }}</span>
                <span class="info-value">${{ number_format($expense->amount, 2) }}</span>
            </div>
            @endforeach
        </div>
        
        <!-- Footer -->
        <div class="footer">
            Sent automatically by <b>{{ config('app.name') }}</b> Dashboard.<br>
            All timestamps are calibrated to your local farm time.<br>
            &copy; {{ date('Y') }} Premium Cow Management.
        </div>
    </div>
</body>
</html>
