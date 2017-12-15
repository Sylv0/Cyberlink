window.onload = () => {
    document.querySelector('#regUsername').addEventListener('input', e => {
        console.log(document.querySelector('#regUsername').value);
    });

    document.forms['regUserForm'].addEventListener('submit', e => {
        alert('Form Submited');
    });

    document.querySelector('.btn-regUser').addEventListener('click', event=>{
        //event.preventDefault();
        let formData = new FormData();
        formData.append('username', document.querySelector('#regUsername').value);
        formData.append('email', document.querySelector('#regEmail').value);
        formData.append('passw', document.querySelector('#regPassw').value);
        var request = new Request('app/users/register.php', {
            method: 'POST',
            body: formData,
          })
        
          fetch(request)
          .then(function(data) {
            return data.json();
          })
          .then(data=>{
              console.log(data);
                if(data['error']){
                    document.querySelector(".loginError").classList.add('open');
                    document.querySelector(".loginError span").innerHTML = data['errorInfo'];
                }
            })
          .catch(res=>console.log(res));
    });

    document.querySelector('.btn-loginUser').addEventListener('click', event=>{
        event.preventDefault();
        let formData = new FormData();
        formData.append('email', document.querySelector('#loginEmail').value);
        formData.append('passw', document.querySelector('#loginPassw').value);
        var request = new Request('app/auth/login.php', {
            method: 'POST',
            body: formData,
          })
        
          fetch(request)
          .then(function(data) {
            return data.json();
          })
          .then(data=>{
              console.log(data);
                if(data['error']){
                    document.querySelector(".loginError").classList.add('open');
                    document.querySelector(".loginError span").innerHTML = data['errorInfo'];
                }
            })
          .catch(res=>console.log("res"));
    });
}