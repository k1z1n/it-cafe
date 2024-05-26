let createMap = document.getElementById('createMap')
let mapDelivery = document.getElementById('mapDelivery')
let close = document.getElementById('close');
if (createMap) {
    createMap.addEventListener('click', function () {
        mapDelivery.classList.remove('hidden');
    });
}

if (closeMap) {
    closeMap.addEventListener('click', function () {
        mapDelivery.classList.add('hidden');
    });
}
if (mapDelivery) {
    mapDelivery.addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
}
