const phone = document.getElementById('phone');
const email = document.getElementById('email');
const td_phone = document.getElementsByClassName('td_phone')[0];
const td_email = document.getElementsByClassName('td_email')[0];
const send = document.getElementById('send');

phone.addEventListener('focusout', (e)=> {
  let re = /(\s*\(?0\d{4}\)?(\s*|-)\d{3}(\s*|-)\d{3}\s*)|(\s*\(?0\d{3}\)?(\s*|-)\d{3}(\s*|-)\d{4}\s*)|(\s*(7|8)(\d{7}|\d{3}(\-|\s{1})\d{4})\s*)/g;
  redGreen(td_phone, re.test(e.target.value));
});

email.addEventListener('focusout', (e)=> {
  let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  let ok = re.test(String(e.target.value).toLowerCase());
  redGreen(td_email, ok);
});

function redGreen(item, tf){
  if (tf){
    item.style.border = 'solid 2px green';
    item.className = 'tick';
    send.disabled = false;
  } else {
    item.style.border = 'solid 2px red';
    item.className = 'cross';
    send.disabled = true;
  };
}
