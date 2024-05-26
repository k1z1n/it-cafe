// Проверяем наличие элемента с id 'openModalButton'
let createSms = document.getElementById('createSms')
let sendSmsForm = document.getElementById('sendSmsForm')
let sendSms = document.getElementById('sendSms')
let openModalButton = document.getElementById('openModalButton');
let closeModalButton = document.getElementById('closeModal');
let createModal = document.getElementById('createModal');
if (openModalButton) {
    openModalButton.addEventListener('click', function () {
        let createModal = document.getElementById('createModal');
        if (createModal) {
            createModal.classList.remove('hidden');
        }
    });
}

// Проверяем наличие элемента с id 'closeModal
if (closeModalButton) {
    closeModalButton.addEventListener('click', function () {
        let createModal = document.getElementById('createModal');
        if (createModal) {
            createModal.classList.add('hidden');
        }
    });
}

// function closeCreate() {
//     if (createSms) {
//         createSms.addEventListener('click', function (event) {
//             if (event.target === this) {
//                 this.classList.add('hidden');
//             }
//         });
//     }
// }
//
// function closeStart(closeStart) {
//     closeStart.addEventListener('click', function () {
//         createModal.classList.add('hidden');
//
//     });
// }
//
// if (createModal) {
//     createModal.addEventListener('click', function (event) {
//         if (event.target === this) {
//             this.classList.add('hidden');
//         }
//     });
// }
// if (sendSms) {
//     sendSms.addEventListener('click', function (event) {
//         createSms.classList.remove('hidden')
//         createModal.classList.add('hidden')
//     })
// }
//
// if (createSms) {
//     createSms.addEventListener('click', function (event) {
//         if (event.target === this) {
//             this.classList.add('hidden');
//         }
//     });
// }
