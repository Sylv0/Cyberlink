window.onload = () => {

    let regUserForm = document.forms['regUserForm'];
    let loginUserForm = document.forms['loginUserForm'];

    regUserForm['username'].addEventListener('input', e => {
        console.log(regUserForm['username'].value);
    });

    document.forms['regUserForm'].addEventListener('submit', e => {
        //event.preventDefault();
        if(document.forms['regUserForm']['passw'].value != document.forms['regUserForm']['passw_repeat'].value){
            document.forms['regUserForm']['passw_repeat'].classList.add('bg-warning');
            setTimeout(() => {
                document.forms['regUserForm']['passw_repeat'].classList.remove('bg-warning');                
            }, 1000);
            return false;
        }
        let formData = new FormData();
        formData.append('username', regUserForm['username'].value);
        formData.append('email', regUserForm['email'].value);
        formData.append('passw', regUserForm['passw'].value);
        var request = new Request('app/users/register.php', {
            method: 'POST',
            body: formData,
        })

        fetch(request)
            .then(function (data) {
                return data.json();
            })
            .then(data => {
                console.log(data);
                if (data['error']) {
                    document.querySelector(".loginError").classList.add('open');
                    document.querySelector(".loginError span").innerHTML = data['errorInfo'];
                } else {
                    loginUserForm['email'].value = regUserForm['email'].value;
                    loginUserForm['passw'].value = regUserForm['passw'].value;
                    regUserForm.reset();
                }
            })
            .catch(res => console.log(res));
    });

    document.querySelector('.btn-loginUser').addEventListener('click', event => {
        event.preventDefault();
        let formData = new FormData();
        formData.append('email', loginUserForm['email'].value);
        formData.append('passw', loginUserForm['passw'].value);
        formData.append('session_id', loginUserForm['sessid'].value);
        var request = new Request('app/auth/login.php', {
            method: 'POST',
            body: formData,
        })

        fetch(request)
            .then(function (data) {
                return data.json();
            })
            .then(data => {
                console.log(data);
                if (data['error']) {
                    document.querySelector(".loginError").classList.add('open');
                    document.querySelector(".loginError span").innerHTML = data['errorInfo'];
                } else {
                    window.location = ".";
                }
            })
            .catch(res => console.log("res"));
    });
}
