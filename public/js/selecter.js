const select = document.getElementById('selecter');
const input = document.getElementById('id_county');

select.addEventListener('change', sync);

function sync(){
    input.value = select.value; 
}

sync();