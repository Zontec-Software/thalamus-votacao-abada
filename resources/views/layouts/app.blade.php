<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Votação - Melhor Abadá')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .logo {
            max-width: 200px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #667eea;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 600;
        }

        .btn-apuracao {
            display: block;
            width: 100%;
            padding: 15px;
            background: #764ba2;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-apuracao:hover {
            background: #5a3a7a;
        }

        .funcionarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .funcionario-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid transparent;
        }

        .funcionario-card:active {
            transform: scale(0.95);
        }

        .funcionario-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .funcionario-thumb {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            background: #e0e0e0;
        }

        .funcionario-nome {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            word-wrap: break-word;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-sim {
            background: #28a745;
            color: white;
        }

        .btn-sim:hover {
            background: #218838;
        }

        .btn-nao {
            background: #dc3545;
            color: white;
        }

        .btn-nao:hover {
            background: #c82333;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #667eea;
        }

        /* Ranking */
        .ranking-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .ranking-posicao {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-right: 15px;
            min-width: 40px;
        }

        .ranking-info {
            flex: 1;
        }

        .ranking-nome {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .ranking-votos {
            color: #666;
            font-size: 14px;
        }

        .total-votos {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #667eea;
            color: white;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @php
                $logoExtensions = ['png', 'svg', 'jpg', 'jpeg'];
                $logoPath = null;
                foreach ($logoExtensions as $ext) {
                    $path = public_path("images/logo.{$ext}");
                    if (file_exists($path)) {
                        $logoPath = asset("images/logo.{$ext}");
                        break;
                    }
                }
            @endphp
            @if($logoPath)
                <img src="{{ $logoPath }}" alt="Roboflex Logo" class="logo">
            @endif
        </div>
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>

