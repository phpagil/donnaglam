window.addEventListener('load', function () {
  //   let chave = document.getElementById('key');
  //   let valor = document.getElementById('value');
  //   let salvar = document.getElementById('btnAdd');
  //   let limpar = document.getElementById('btnLimp');
  //   let conteudo = document.getElementById('conteudo');

  let user_email = document.getElementById('user_email');
  let user_name = document.getElementById('user_name');
  let user_lastname = document.getElementById('user_lastname');
  let user_cell = document.getElementById('user_cell');
  let user_document = document.getElementById('user_document');
  let user_password = document.getElementById('user_password');

  user_email.addEventListener('blur', function () {
    if (user_email !== '') {
      localStorage.setItem('user_email', user_email.value);
    }
  });

  user_name.addEventListener('blur', function () {
    if (user_name !== '') {
      localStorage.setItem('user_name', user_name.value);
    }
  });

  user_lastname.addEventListener('blur', function () {
    if (user_lastname !== '') {
      localStorage.setItem('user_lastname', user_lastname.value);
    }
  });

  user_cell.addEventListener('blur', function () {
    if (user_cell !== '') {
      localStorage.setItem('user_cell', user_cell.value);
    }
  });

  user_document.addEventListener('blur', function () {
    if (user_document !== '') {
      localStorage.setItem('user_document', user_document.value);
    }
  });

  user_password.addEventListener('blur', function () {
    if (user_password !== '') {
      localStorage.setItem('jwt_token', Base64.encode(user_password.value));
    }
  });

  //   salvar.addEventListener('click', function () {
  //     let input2 = valor.value;
  //     let input1 = chave.value;
  //     localStorage.setItem(input2, input1);
  //     exibir();
  //   });

  //   limpar.addEventListener('click', function () {
  //     localStorage.clear();
  //     exibir();
  //   });

  //   window.addEventListener('storage', function (event) {
  //     let key = event.key;
  //     let newValue = event.newValue;
  //     let oldValue = event.oldValue;
  //     let storageArea = event.storageArea;

  //     key.innerHTML(key + '\n' + newValue + '\n' + oldValue + '\n' + storageArea);
  //     exibir();
  //   });

  //   function exibir() {
  //     let str = '';
  //     for (let i = 0, len = localStorage.length; i < len; i++) {
  //       let key = localStorage.key(i);
  //       let valor = localStorage.getItem(key);
  //       str += `${[i + 1]} . ${key} : ${valor}<br>`;
  //     }

  //     valor.value = '';
  //     chave.value = '';
  //     conteudo.innerHTML = str;
  //   }

  //   exibir();
});
