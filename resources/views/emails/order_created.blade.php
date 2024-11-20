<!DOCTYPE html>
<html>
<head>
    <title>Pedido Registrado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            background-color: #f4b400;
            padding: 20px;
            color: white;
        }
        .content {
            margin: 20px;
        }
        .content p {
            margin-bottom: 10px;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🎂 Delivery Tortitas 🎂</h1>
</div>

<div class="content">
    <p>¡Hola! Tu pedido ha sido registrado con éxito. Aquí tienes los detalles:</p>

    <div class="order-details">
        <ul>
            <li><strong>Código del Pedido:</strong> {{ $order->order_code }}</li>
            <li><strong>Evento:</strong> {{ $order->event->name }}</li>
            <li><strong>Fecha del Evento:</strong> {{ $order->event_date }}</li>
            <li><strong>Dirección de Envío:</strong> {{ $order->shipping_address }}</li>
        </ul>
    </div>

    <p>Por favor, espera nuestra confirmación. Nos pondremos en contacto contigo en breve para coordinar cualquier detalle adicional de tu pedido.</p>
    <p>¡Gracias por elegir <strong>Delivery Tortitas</strong> para endulzar tu día especial!</p>
</div>

<div class="footer">
    <p>Este es un mensaje generado automáticamente. Si necesitas asistencia, contacta con nosotros al <strong>serviciocliente@deliverytortitas.com</strong>.</p>
</div>

</body>
</html>
