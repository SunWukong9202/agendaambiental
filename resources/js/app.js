import './bootstrap';
//import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import 'flowbite'
// import 'flatpickr'
// import 'flatpickr/dist/themes/light.css';
// import { initTabs } from 'flowbite';

// Alpine.store('utils', {
//     formatDateToLocal(dateString, currentFormat = 'F j, h:i K', differentYearFormat = 'F j, Y h:i K') {
//         const date = new Date(dateString);
//         const now = new Date();
//         const format = (date.getFullYear() === now.getFullYear()) ? currentFormat : differentYearFormat;
//         return flatpickr.formatDate(date, format);
//     },

//     isGreaterDate(op1, op2) {
//         return op1.getFullYear() === op2.getFullYear() &&
//                op1.getMonth() === op2.getMonth() &&
//             op1.getDate() >= op2.getDate();
//     },

//     commonPlickrConf({ button = null }) {
//         let selected = false;
    
//         // const initialDateValue = initialDate();

//         const conf =  {
//             altInput: true,
//             // defaultDate: initialDateValue,
//             // enableTime: initialDateValue,
//             // minDate: minDate,
//             altFormat: 'F j, Y h:i K',
//             dateFormat: 'Y-m-d H:i',

//             onClose: function (selectedDates, dateStr, instance) {
//                 if (!selected && !this.defaultDate) {
//                     instance.clear();
//                 }
//             },
//             onChange: (selectedDates, dateStr, instance) => {
//                 selected = true;
//                 const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
//                 if (!isMobile && button) {
//                     const btn = document.querySelector(`[x-ref=${button}]`);
//                     btn.classList.remove('hidden');
//                     btn.addEventListener('click', () => instance.close());
//                     instance.calendarContainer.appendChild(btn);
//                 }
//             }
//         };
//         return conf;
//         // flatpickr(onElement,)
//     }
// });


// Inside a global script file (e.g., app.js or a custom JS file loaded in the layout)
window.laravelRulePort = function(value, rule, target, message) {

    if (rule === 'required') {
        return value.trim() !== '';
    }

    if (rule.startsWith('min:')) {
        let minValue = parseInt(rule.split(':')[1], 10);
        return value.length >= minValue;
    }
    
    if (rule.startsWith('max:')) {
        let maxValue = parseInt(rule.split(':')[1], 10);
        return value.length <= maxValue;
    }

    if (rule === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    }
    // Add more rule checks as needed
    return true; // Return true if rule is not defined
};

function overrideNativeMessages() {

}

// Array of default messages and Spanish translations with placeholders for constraints
window.validationMessages = {
    required: {
        en: "Please fill out this field.",
        es: "Por favor, complete este campo."
    },
    email: {
        en: "Please enter a valid email address.",
        es: "Por favor, ingrese una dirección de correo electrónico válida."
    },
    url: {
        en: "Please enter a valid URL.",
        es: "Por favor, ingrese una URL válida."
    },
    number: {
        en: "Please enter a number.",
        es: "Por favor, ingrese un número."
    },
    min: {
        en: "Please select a value that is no less than {min}.",
        es: "Por favor, seleccione un valor que sea igual o mayor que {min}."
    },
    max: {
        en: "Please select a value that is no greater than {max}.",
        es: "Por favor, seleccione un valor que sea menor o igual que {max}."
    },
    minlength: {
        en: "Please lengthen this text to {minLength} characters or more.",
        es: "Por favor, alargue este texto a {minLength} caracteres o más."
    },
    maxlength: {
        en: "Please shorten this text to no more than {maxLength} characters.",
        es: "Por favor, acorte este texto a no más de {maxLength} caracteres."
    },
    pattern: {
        en: "Please match the requested format.",
        es: "Por favor, coincida con el formato solicitado."
    }
};

//Livewire.start()
