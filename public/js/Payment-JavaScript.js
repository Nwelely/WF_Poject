document.addEventListener('DOMContentLoaded', () => {
    toggleNewCardInputs(document.querySelector('.card-select-input'));
});

document.addEventListener('DOMContentLoaded', function () {
    const monthInput = document.getElementById('month-input');
    const yearInput = document.getElementById('year-input');
    const currentYear = new Date().getFullYear();

    for (let month = 1; month <= 12; month++) {
        const option = document.createElement('option');
        option.value = month < 10 ? `0${month}` : month;
        option.textContent = month < 10 ? `0${month}` : month;
        monthInput.appendChild(option);
    }

    for (let year = currentYear; year <= currentYear + 10; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearInput.appendChild(option);
    }
});
document.querySelector('.card-number-input').oninput = () => {
    document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
};

document.querySelector('.card-holder-input').oninput = () => {
    document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
};

document.querySelector('.month-input').oninput = () => {
    document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
};

document.querySelector('.year-input').oninput = () => {
    document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
};

document.querySelector('.cvv-input').onmouseenter = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
};

document.querySelector('.cvv-input').onmouseleave = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
};

document.querySelector('.cvv-input').oninput = () => {
    document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
};

const cardSelectInput = document.querySelector('.card-select-input');
if (cardSelectInput) {
    cardSelectInput.onchange = (event) => {
        const selectedCard = event.target.value;
        if (selectedCard&&(selectedCard != 'new')) {
            document.querySelector('.card-number-input').disabled = true;
            document.querySelector('.card-holder-input').disabled = true;
            document.querySelector('.month-input').disabled = true;
            document.querySelector('.year-input').disabled = true;
            document.querySelector('.cvv-input').disabled = true;
        } else {
            document.querySelector('.card-number-input').disabled = false;
            document.querySelector('.card-holder-input').disabled = false;
            document.querySelector('.month-input').disabled = false;
            document.querySelector('.year-input').disabled = false;
            document.querySelector('.cvv-input').disabled = false;
        }
    };
}

function validateCreditCard() {
    const errors = [];
    const selectedCard = document.querySelector('.card-select-input').value;

    if (selectedCard === 'new') {
        const cardNumber = document.querySelector('.card-number-input').value;
        const cardHolder = document.querySelector('.card-holder-input').value;
        const expMonth = document.querySelector('.month-input').value;
        const expYear = document.querySelector('.year-input').value;
        const cvv = document.querySelector('.cvv-input').value;

        if (cardNumber.length !== 16 || isNaN(cardNumber)) {
            errors.push("Invalid card number!");
        }
        if (!cardHolder || !/^[a-zA-Z\s]+$/.test(cardHolder)) {
            errors.push("Invalid card holder name!");
        }
        if (cardHolder.trim() === "") {
            errors.push("Card holder name cannot be empty!");
        }
        if (expMonth === "month") {
            errors.push("Please select expiration month!");
        }
        if (expYear === "year") {
            errors.push("Please select expiration year!");
        }
        if (cvv.length !== 3 && cvv.length !== 4 || isNaN(cvv)) {
            errors.push("Invalid CVV!");
        }
    }

    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false;
    }
    return true;
}

function toggleNewCardInputs(selectElement) {
    const selectedValue = selectElement.value;
    const newCardInputs = document.querySelectorAll('.card-number-input, .card-holder-input, .month-input, .year-input, .cvv-input, .last4digits-input');

    if (selectedValue === 'new') {
        newCardInputs.forEach(input => input.disabled = false);
    } else {
        newCardInputs.forEach(input => input.disabled = true);
    }
}




// Check and apply stored dark mode preference on page load
document.addEventListener('DOMContentLoaded', function () {
    const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
    const darkModeButton = document.querySelector('.darkmode-button');
    
    if (isDarkMode) {
      document.body.classList.add('dark-mode');
      darkModeButton.textContent = 'Light Mode';
    } else {
      document.body.classList.remove('dark-mode');
      darkModeButton.textContent = 'Dark Mode';
    }
  });

