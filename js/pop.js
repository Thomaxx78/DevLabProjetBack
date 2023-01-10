const button = document.querySelector('.openbtn');
const modal = document.querySelector('.lemodal');
const close = document.querySelector('.closebtn')

button.addEventListener('click', () => {
    modal.classList.remove('hidden');
    button.classList.add('hidden');
});

close.addEventListener('click', () => {
    modal.classList.add('hidden');
    button.classList.remove('hidden');
});