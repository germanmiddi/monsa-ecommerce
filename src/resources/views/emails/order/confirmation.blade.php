<!-- resources/views/emails/order.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu compra!</h1>
        </div>
        <div class="content">
            <p>Estimado/a {{ $client->name }},</p>
            <p>Hemos recibido tu pedido y está siendo procesado. A continuación, encontrarás los detalles de tu compra:</p>
            
            <h2>Resumen del pedido</h2>
            {{-- <p><strong>Número de pedido:</strong> {{ $order->id }} <a href="{{ @php(env('APP_URL').'/order/detail?orderId='.$orderId ) }}" target="_blank" >Segui el estado de tu pedido aquí</a> </p> --}}
            <p><strong>Número de pedido:</strong> {{ $order->id }} <a href="{{ env('APP_URL').'/order/detail?orderId='.$order->id }}" target="_blank">Segui el estado de tu pedido aquí</a></p>
            <p><strong>Fecha de compra:</strong> {{ $order->created_at }}</p>
            
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->nombre }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->price, 2) }}</td>
                        <td>$ {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Subtotal:</strong></td>
                    <td>$ {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Gastos de envío:</strong></td>
                    <td>$ {{ number_format($order->delivery_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                    <td>$ {{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
            
            <h2>Información de envío</h2>
            <p><strong>Dirección de envío:</strong><br>
            {{ $client->name }}<br>
            {{ $client->address }}<br>
            {{ $client->city }}, {{ $client->postal_code }}<br>
            {{ $client->country }}</p>
            
            <p><strong>Método de envío:</strong> {{ $shipment->method ?? 'Estándar' }} - <a href="{{ $shipment->tracking_url }}" target="_blank">Seguir envio aquí. </a></p>
            <p><strong>Tiempo estimado de entrega:</strong> {{ $shipment->estimated_delivery ?? '3-5 días hábiles' }}</p>
            
            <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos respondiendo a este correo o llamando a nuestro servicio de atención al cliente.</p>
            
            <p>¡Gracias por comprar en {{ config('app.name') }}!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>