<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Games Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #ddd; padding:8px; }
        th { background:#f3f4f6; text-align:left; }
    </style>
</head>
<body>
    <h2>Games Export</h2>
    @if($search)
        <div>Search: {{ $search }}</div>
    @endif
    @if($platform_id)
        <div>Platform ID: {{ $platform_id }}</div>
    @endif
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Release Year</th>
                <th>Platform</th>
                <th style="text-align:right">Money spent (₱)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->title }}</td>
                    <td>{{ $game->release_year }}</td>
                    <td>{{ $game->platform->name ?? 'N/A' }}</td>
                    <td style="text-align:right">{{ number_format($game->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:12px;font-size:11px;color:#666;">Exported: {{ now()->format('Y-m-d H:i:s') }}</div>
</body>
</html>
