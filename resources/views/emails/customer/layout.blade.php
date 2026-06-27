<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $subject ?? '' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f4f5;
            color: #18181b;
            font-size: 14px;
            line-height: 1.6;
        }

        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e4e4e7;
        }

        .header {
            padding: 32px 40px;
            border-bottom: 1px solid #f4f4f5;
        }

        .header .org-name {
            font-size: 18px;
            font-weight: 700;
            color: #18181b;
        }

        .body {
            padding: 40px;
        }

        .body h1 {
            font-size: 20px;
            font-weight: 600;
            color: #18181b;
            margin-bottom: 16px;
        }

        .body p {
            color: #52525b;
            margin-bottom: 12px;
        }

        .amount-box {
            background: #f4f4f5;
            border-radius: 6px;
            padding: 20px 24px;
            margin: 24px 0;
        }

        .amount-box .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #a1a1aa;
            margin-bottom: 4px;
        }

        .amount-box .amount {
            font-size: 28px;
            font-weight: 700;
            color: #18181b;
        }

        .amount-box .due {
            font-size: 12px;
            color: #71717a;
            margin-top: 4px;
        }

        .footer {
            padding: 24px 40px;
            border-top: 1px solid #f4f4f5;
            font-size: 12px;
            color: #a1a1aa;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            @if($organization->logo_url)
                <img
                    src="{{ $organization->logo_url }}"
                    alt="{{ $organization->name }}"
                    style="max-height:48px;max-width:160px;"
                />
            @else
                <div class="org-name">
                    {{ $organization->name ?? $organization->org_code }}
                </div>
            @endif
        </div>

        <div class="body">
            @yield('content')
        </div>

        <div class="footer">
            {{ $organization->name ?? $organization->org_code }}
            @if($organization->email) · {{ $organization->email }}@endif
            @if($organization->phone) · {{ $organization->phone }}@endif
            <br />
            @if($organization->activeSubscription?->plan?->slug === 'free')
                <span style="margin-top:8px;display:block;">
                    Powered by BillBase
                </span>
            @endif
        </div>
    </div>
</body>
</html>