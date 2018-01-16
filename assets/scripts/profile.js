window.onload = () => {
    const updateForm = document.forms['updateUserForm'];

    updateForm['urlcheck'].addEventListener('click', e => {
        if(e.target.checked){
            document.forms['updateUserForm']['avatar'].setAttribute('type', 'text');
            document.forms['updateUserForm']['avatar'].setAttribute('placeholder', 'Paste URL');
        } else {
            document.forms['updateUserForm']['avatar'].setAttribute('type', 'file');
            document.forms['updateUserForm']['avatar'].removeAttribute('placeholder');      
        }
    });

    document.querySelectorAll(".editPostCheck").forEach(box => {
        box.addEventListener('click', e => {
            let postID = e.target.getAttribute("data-postid");
            let post = document.querySelector(`div.post[data-postid="${postID}"]`);
            let postTitle = document.querySelector(`.post[data-postid="${postID}"] .postTitle`);
            let postText = document.querySelector(`.post[data-postid="${postID}"] .postText`);
            let updateTime = document.querySelector(`.post[data-postid="${postID}"] span.updateTime`);
            let editTitle = document.querySelector(`.post[data-postid="${postID}"] .editTitle`);
            let editText = document.querySelector(`.post[data-postid="${postID}"] .editText`);
            
            postTitle.classList.toggle('d-none');
            postText.classList.toggle('d-none');
            editTitle.classList.toggle('d-none');
            editText.classList.toggle('d-none');
            if(e.target.checked){
                editTitle.setAttribute('value', postTitle.innerHTML);
                editText.innerHTML = postText.innerHTML;
            } else {
                let formData = new FormData();
                formData.append('title', editTitle.value);
                formData.append('text', editText.value);
                formData.append('postID', post.getAttribute('data-postid'));
                var request = new Request('app/posts/update.php', {
                    method: 'POST',
                    body: formData
                })

                fetch(request)
                .then(function (data) {
                    return data.json();
                })
                .then(data => {
                    postTitle.innerHTML = data['newData']['title'];
                    postText.innerHTML = data['newData']['postText'];
                    updateTime.innerHTML = data['newData']['updateTime'];
                })
                .catch(res => console.log(res));
            }
        });
    });
}