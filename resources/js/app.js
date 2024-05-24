import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import 'flowbite'
import 'flatpickr'
import 'flatpickr/dist/themes/light.css';
import { initTabs } from 'flowbite';

Alpine.store('utils', {
    formatDateToLocal(dateString, currentFormat = 'F j, h:i K', differentYearFormat = 'F j, Y h:i K') {
        const date = new Date(dateString);
        const now = new Date();
        const format = (date.getFullYear() === now.getFullYear()) ? currentFormat : differentYearFormat;
        return flatpickr.formatDate(date, format);
    },

    isGreaterDate(op1, op2) {
        return op1.getFullYear() === op2.getFullYear() &&
               op1.getMonth() === op2.getMonth() &&
            op1.getDate() >= op2.getDate();
    },

    commonPlickrConf({ button = null }) {
        let selected = false;
    
        // const initialDateValue = initialDate();

        const conf =  {
            altInput: true,
            // defaultDate: initialDateValue,
            // enableTime: initialDateValue,
            // minDate: minDate,
            altFormat: 'F j, Y h:i K',
            dateFormat: 'Y-m-d H:i',

            onClose: function (selectedDates, dateStr, instance) {
                if (!selected && !this.defaultDate) {
                    instance.clear();
                }
            },
            onChange: (selectedDates, dateStr, instance) => {
                selected = true;
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                if (!isMobile && button) {
                    const btn = document.querySelector(`[x-ref=${button}]`);
                    btn.classList.remove('hidden');
                    btn.addEventListener('click', () => instance.close());
                    instance.calendarContainer.appendChild(btn);
                }
            }
        };
        return conf;
        // flatpickr(onElement,)
    }
});

 
Livewire.start()