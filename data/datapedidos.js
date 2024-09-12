function getTestData() {
    return [
        { id: 1, usuario: 101, fecha_pedido: '2024-09-01T14:00', total: 250.00, estado: 'pendiente' },
        { id: 2, usuario: 102, fecha_pedido: '2024-09-02T10:30', total: 100.50, estado: 'completado' },
        { id: 3, usuario: 103, fecha_pedido: '2024-09-03T12:45', total: 75.75, estado: 'cancelado' },
        { id: 4, usuario: 104, fecha_pedido: '2024-09-04T09:00', total: 200.00, estado: 'pendiente' }
    ];
}

// Función para simular la llamada AJAX
function fetchPedidos(callback) {
    setTimeout(() => {
        callback(JSON.stringify(getTestData()));
    }, 500); // Simula un retraso de 500ms
}