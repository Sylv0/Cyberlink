let postDiv;
let postForm;

window.onload = () => {
    postDiv = document.querySelector('.row.posts');
    postForm = document.forms['postForm'];

    postForm.addEventListener('submit', e => {
        submitPost();
    });

    getPosts();
}

const submitPost = () => {
    let formData = new FormData();
    formData.append('title', postForm['postTitle'].value);
    formData.append('link', postForm['postLink'].value);
    formData.append('text', postForm['postText'].value);
    formData.append('author', postForm['postAuthor'].value);
    var request = new Request('app/posts/submit.php', {
        method: 'POST',
        body: formData
    })

    fetch(request)
    .then(function (data) {
        return data.json();
    })
    .then(data => {
        if (data['error']) {
            console.log("ERROR: " + data['errorInfo']);
        } else if(data['submited']){
            getLatestPost();
            postForm.reset();
        }
    })
    .catch(res => console.log(res));
}

const createPost = (post) => {
    //let votes = getVotes(post['postID']);
    let score = 0;
    let div = document.createElement('div');
    div.className = "col-md-12 col-lg-10 post-container";
    let postTemp =`
    <div class="card mt-4">
        <a target="_blank" href="${post['image_url']}" class="card-header">
            ${post['title']}
        </a>
        <div class="card-body row">
            <blockquote class="blockquote mb-0 col-10">
                <p>${post['postText']}</p>
                <footer class="blockquote-footer"><a href="profile.php?targetUser=${post['userID']}">${post['author']}</a> <cite title="Source Title">${post['postTime']}</cite> (${post['updateTime']})</footer>
            </blockquote>
            <blockquote class="col-2">
                <a onclick="return false;" href="#" class="btn btn-sm btn-primary active vote" data-postid="${post['postID']}" data-vote="1">&uArr;</a>
                <span class="voteScore" data-postid="${post['postID']}">0</span>
                <a onclick="return false;" href="#" class="btn btn-sm btn-primary active vote" data-postid="${post['postID']}" data-vote="-1">&dArr;</a>
            </blockquote>
        </div>
    </div>
    `;
    div.innerHTML = postTemp;
    if(post['image_url'] == undefined || post['image_url'] == ""){
        div.querySelector('a.card-header').setAttribute('href', '#');
        div.querySelector('a.card-header').setAttribute('onclick', 'return false;');
        div.querySelector('a.card-header').innerHTML += "(no link)";
    }
    return div;
}

const getPosts = () => {
    let formData = new FormData();
    formData.append('getAll', true);
    var request = new Request('app/posts/get.php', {
        method: 'POST',
        body: formData
    })

    fetch(request)
    .then(function (data) {
        return data.json();
    })
    .then(data => {
        if (data['error']) {
            console.log('ERROR: ' + data['errorInfo']);
        } else {
            data.forEach(post => {
                postDiv.insertBefore(createPost(post), postDiv.children[0]);
            });
        }
        getVotes();
    })
    .catch(res => console.log(res));
}

const getLatestPost = () => {
    let formData = new FormData();
    formData.append('getLatest', true);
    var request = new Request('app/posts/get.php', {
        method: 'POST',
        body: formData
    })

    fetch(request)
    .then(function (data) {
        return data.json();
    })
    .then(data => {
        if (data['error']) {
            console.log('ERROR: ' + data['errorInfo']);
        } else {
            postDiv.insertBefore(createPost(data), postDiv.children[0]);
        }
    })
    .catch(res => console.log(res));
}

const getVotes = (postID) => {
    let formData = new FormData();
    formData.append('getVotes', true);
    var request = new Request('app/posts/get.php', {
        method: 'POST',
        body: formData
    })

    fetch(request)
    .then(function (data) {
        return data.json();
    })
    .then(data => {
        console.log(data);
        data.forEach(vote => {
            let scoretarget = document.querySelector(`span.voteScore[data-postid="${vote['postID']}"]`);
            scoretarget.innerHTML = parseInt(scoretarget.innerHTML, 10)+parseInt(vote['vote'], 10);
            let votebuttontarget = document.querySelector(`a.btn.vote[data-postid="${vote['postID']}"][data-vote="${vote['vote']}"]`);
            votebuttontarget.classList.add('disabled');
        });
    })
    .catch(res => console.log(res));
}
