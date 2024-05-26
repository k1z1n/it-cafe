document.getElementById('verifyCodeForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем отправку формы

    // Получаем значение из поля ввода
    var code = document.getElementById('verificationCode').value;

    // Получаем CSRF-токен
    let token = document.head.querySelector('meta[name="csrf-token"]').content;

    // Отправляем AJAX запрос на сервер для валидации кода
    fetch('/auth/verify-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token // Убедитесь, что токен передается правильно
        },
        body: JSON.stringify({ verificationCode: code }) // Передаем код в теле запроса
    })
        .then(response => {
            // Проверяем статус ответа
            if (response.ok) {
                return response.json(); // Парсим ответ как JSON, если статус ответа 200-299
            } else {
                throw new Error('Ошибка HTTP: ' + response.status); // Выбрасываем ошибку, если статус не 200-299
            }
        })
        .then(data => {
            // Если есть ошибка, показать ее на странице
            if (data.error) {
                document.getElementById('errorMessage').innerText = data.error;
            } else {
                // Если ошибки нет
                if (data.success) {
                    // Переход на страницу '/'
                    window.location.href = '/';
                } else {
                    // Если success не равен true, отправить форму
                    event.target.submit();
                }
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            // Обработка ошибки, например, показ сообщения об ошибке пользователю
            document.getElementById('errorMessage').innerText = 'Произошла ошибка при отправке запроса. Пожалуйста, попробуйте еще раз.';
            if (error.message.includes('422')) {
                document.getElementById('errorMessage').innerText = 'Неверный код';
            }
        });
});
