const burger_menu = document.getElementsByClassName('burger_menu')[0];
const side_bar = document.getElementsByClassName('side_bar')[0];
const close_side_bar = document.getElementsByClassName('close_side_bar')[0];


burger_menu.addEventListener('click', ()=> {
    side_bar.style.opacity = '1';
    burger_menu.style.opacity = '0';
})

close_side_bar.addEventListener('click', ()=> {
    side_bar.style.opacity = '0';
    burger_menu.style.opacity = '1';

})
