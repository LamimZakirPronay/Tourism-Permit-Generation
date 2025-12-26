<!DOCTYPE html>
<html>
<head>
    <style>
        /* 80mm is standard thermal width; height: auto allows the page to end when content ends */
        @page { 
            size: 80mm auto; 
            margin: 0; 
        }
        
        body { 
            font-family: 'Courier', monospace; 
            width: 80mm; 
            margin: 0; 
            padding: 0; 
            font-size: 11px;
            line-height: 1.3;
            color: #000;
        }

        .token-container {
            width: 72mm; /* Leave small gutter for printer margins */
            margin: 0 auto;
            text-align: center;
            /* Use 'always' if you want a physical cut between members, 
               otherwise 'avoid' to keep them on one continuous strip */
            page-break-after: always; 
            padding: 10px 0;
            border-bottom: 1px dashed #000;
        }

        .header { 
            font-weight: bold; 
            font-size: 14px; 
            margin-bottom: 2px; 
            text-transform: uppercase;
        }

        .serial-label {
            font-size: 10px;
            margin-top: 5px;
            display: block;
        }

        .token-no { 
            font-size: 28px; 
            font-weight: bold; 
            margin: 2px 0;
            border: 2px solid #000;
            display: inline-block;
            padding: 0 10px;
        }

        .qr-code { margin: 8px 0; }
        .qr-code img { display: block; margin: 0 auto; }

        .details { 
            text-align: left; 
            margin: 0 5px;
            font-size: 11px;
        }

        .divider { 
            border-top: 1px solid #000; 
            margin: 5px 0; 
        }

        .footer {
            font-size: 9px;
            margin-top: 8px;
            font-style: italic;
        }

        /* Prevent empty last page */
        .token-container:last-child {
            page-break-after: auto;
            border-bottom: none;
        }
    </style>
</head>
<body>
    @foreach($permit->teamMembers as $index => $member)
        <div class="token-container">
            <div class="header">ENTRY TOKEN</div>
            <div class="divider"></div>
            
            <span class="serial-label">DAILY SERIAL</span>
            <div class="token-no">
                #{{ $permit->daily_serial }}-{{ $index + 1 }}
            </div>

            <div class="qr-code">
                {{-- Ensure $qrCode is passed as base64 from controller --}}
                <img src="data:image/svg+xml;base64, {!! $qrCode !!}" width="110">
                <small style="display:block; margin-top:3px;">ID: {{ str_pad($permit->id, 5, '0', STR_PAD_LEFT) }}</small>
            </div>

            <div class="details">
                <strong>Group:</strong> {{ $permit->group_name }}<br>
                <strong>Name :</strong> {{ strtoupper($member->name) }}<br>
                <strong>Sites:</strong> {{ $visitSites }}<br>
                <strong>Valid:</strong> {{ $date }}
            </div>

            <div class="divider" style="margin-top:10px;"></div>
            <div class="footer">
                Please keep this token until exit.<br>
                Generated: {{ now()->format('H:i:s') }}
            </div>
        </div>
    @endforeach
</body>
</html>