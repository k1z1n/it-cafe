import axios from 'axios';
document.getElementById('verifyCodeForm').addEventListener('submit', function (event) {
    event.preventDefault();

    let form = document.getElementById('verifyCodeForm');
    let formData = new FormData(form);

    axios.post(form.action, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(function (response) {
            console.log('кутак баш')
        })
        .catch(function (error) {
            // Обработка ошибок
            let errorMessage = error.response.data.error;
            $('#errorMessage').text(errorMessage);
        });
});
