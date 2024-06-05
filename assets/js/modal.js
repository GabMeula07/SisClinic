const btn = document.querySelector('#novo_agendamento');
const btnClose = document.querySelector('#close');
const modal = document.querySelector('.modal');

btn.addEventListener('click', ()=>{
    modal.classList.toggle('closed');
})
btnClose.addEventListener('click', ()=>{
    modal.classList.toggle('closed');
})