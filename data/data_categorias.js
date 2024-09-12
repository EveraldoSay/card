function getTestCategories() {
    return [
        { id: 1, categoria: 'Electrónica' },
        { id: 2, categoria: 'Ropa' },
        { id: 3, categoria: 'Hogar' },
        { id: 4, categoria: 'Juguetes' }
    ];
}

// Función para simular la llamada AJAX
function fetchCategories(callback) {
    setTimeout(() => {
        callback(JSON.stringify(getTestCategories()));
    }, 500); // Simula un retraso de 500ms
}