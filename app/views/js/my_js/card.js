document.addEventListener("DOMContentLoaded", function () {
    const quantityInput = document.querySelector('#card_quantity_input input');
    const plusButton = document.querySelector('.quantity__button_plus');
    const minusButton = document.querySelector('.quantity__button_minus');
    const checkboxInputs = document.querySelectorAll('#card_checkbox_input .checkbox__input');
    const priceContainer = document.querySelector('#card-other-price');
    const quantityContainer = document.querySelector('.quantity');
    const itemId = quantityContainer.dataset.itemId;

    // Функция для отправки данных на сервер
    function sendData() {
        const quantity = quantityInput.value;

        // Получаем состояние чекбоксов
        const selectedOptions = Array.from(checkboxInputs)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Формируем данные для отправки
        const payload = {
            quantity: quantity,
            selectedOptions: selectedOptions,
            itemId: itemId,
        };
        console.log(payload);
        
        // Отправляем данные через fetch
        fetch('update-price', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.text();
        })
        .then(html => {
            // console.log(html);
            priceContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    }

    // Обработчик для инпута
    quantityInput.addEventListener('input', sendData);

    // Обработчик для кнопки "плюс"
    plusButton.addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10) || 0;
        // quantityInput.value = currentValue + 1;
        sendData(); // Отправляем данные после изменения
    });

    // Обработчик для кнопки "минус"
    minusButton.addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10) || 0;
        if (currentValue > 0) {
            // quantityInput.value = currentValue - 1;
            sendData(); // Отправляем данные после изменения
        }
    });

    // Обработчик для чекбоксов
    checkboxInputs.forEach(checkbox => {
        checkbox.addEventListener('change', sendData);
    });
});