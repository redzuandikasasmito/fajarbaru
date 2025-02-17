<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      canvas {
          width: 100% !important;
          height: 100% !important;
      }
      .sales-gradient {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .card-gradient {
            background: linear-gradient(to right, #60a5fa, #3b82f6);
            transition: all 0.3s ease;
        }

        .card-gradient:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(59,130,246,0.3);
        }

        .gradient-blue {
        background: linear-gradient(to right, #3b82f6, #1e40af);
        }
        .gradient-green {
            background: linear-gradient(to right, #10b981, #047857);
        }
        .gradient-purple {
            background: linear-gradient(to right, #8b5cf6, #6d28d9);
        }
        .gradient-red {
            background: linear-gradient(to right, #ef4444, #b91c1c);
        }
            
  </style>
    <title>@yield('page-title', 'FajarBaru-Pos')</title>
</head>