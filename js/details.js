const big_img = document.getElementsByClassName('big_img')[0];
const small_img = document.getElementsByClassName('small_img');

Array.from(small_img).forEach(i => {
  i.addEventListener('click', (e)=> {
    Array.from(small_img).forEach(j => {
      j.style.border = 'none';
    });
    e.target.style.border = 'solid 3px var(--dark_purple)';
    big_img.src = e.target.src;
  });
});
