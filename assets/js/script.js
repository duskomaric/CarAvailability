let currentStep = 'step2';
let selectedCar = '';
let selectedCarAmount = '';
let additionalDriver = '';
let babySeat = '';
let firstName = '';
let lastName = '';

function nextStep(step) {
    document.getElementById(currentStep).style.display = 'none';
    document.getElementById(step).style.display = 'block';
    currentStep = step;
}

function prevStep(step) {
    document.getElementById(currentStep).style.display = 'none';
    document.getElementById(step).style.display = 'block';
    currentStep = step;
}

function selectCar(carModel, carAmount) {

    console.log('selectCar function called with:', carModel, carAmount);
    selectedCar = carModel;
    selectedCarAmount = carAmount;
    document.getElementById('review-selected-car').textContent = selectedCar;
    document.getElementById('review-selected-car-amount').textContent = selectedCarAmount;
    nextStep('step3');
}

// Function to update additional driver, baby seat, first name, and last name
function updateOptions() {
    additionalDriver = document.querySelector('input[name="additional_driver"]').value;
    babySeat = document.querySelector('input[name="baby_seat"]').value;
    firstName = document.querySelector('input[name="first_name"]').value;
    lastName = document.querySelector('input[name="last_name"]').value;

    document.getElementById('review-additional-driver').textContent = additionalDriver;
    document.getElementById('review-baby-seat').textContent = babySeat;
    document.getElementById('review-first-name').textContent = firstName;
    document.getElementById('review-last-name').textContent = lastName;
}

// Attach the updateOptions function to input change events
document.querySelector('input[name="additional_driver"]').addEventListener('input', updateOptions);
document.querySelector('input[name="baby_seat"]').addEventListener('input', updateOptions);
document.querySelector('input[name="first_name"]').addEventListener('input', updateOptions);
document.querySelector('input[name="last_name"]').addEventListener('input', updateOptions);