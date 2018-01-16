window.onload = () => {
    document.forms['updateUserForm']['urlcheck'].addEventListener('click', e => {
        if(e.target.checked){
            document.forms['updateUserForm']['avatar'].setAttribute('type', 'text');
            document.forms['updateUserForm']['avatar'].setAttribute('placeholder', 'Paste URL');
        } else {
            document.forms['updateUserForm']['avatar'].setAttribute('type', 'file');
            document.forms['updateUserForm']['avatar'].removeAttribute('placeholder');      
        }
    });
    document.querySelector(".editPostCheck").addEventListener('click', e => {
        let postID = e.target.getAttribute("data-postid");
        let post = document.querySelector(`div.post[data-postid="${postID}"]`);
        let postTitle = document.querySelector(`.post[data-postid="${postID}"] .postTitle`);
        let postText = document.querySelector(`.post[data-postid="${postID}"] .postText`);
        
        

        if(e.target.checked){

        } else {

        }
    });
}