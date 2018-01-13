let postDiv;
let postForm;

window.onload = () => {
    postDiv = document.querySelector('.row.posts');
    postForm = document.forms['postForm'];

    postForm.addEventListener('submit', e => {
        submitPost();
    });

    getPosts();
    getVotes();
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
        //console.log(data);
        if (data['error']) {
            console.log(data['errorInfo']);
        } else if(data['submited']){
            getLatestPost();
            postForm.reset();
        }
    })
    .catch(res => console.log(res));
}

const createPost = (post) => {
    let div = document.createElement('div');
    div.className = "col-md-12 col-lg-10 post-container";
    let postTemp =`
    <div class="card mt-4">
        <a href="${post['imageURL']}" class="card-header" onclick="return false;">
            ${post['title']}
        </a>
        <div class="card-body row">
            <blockquote class="blockquote mb-0 col-10">
            <p>${post['postText']}</p>
            <footer class="blockquote-footer"><a href="${post['author']}">${post['author']}</a> <cite title="Source Title">${post['postTime']}</cite> (${post['updateTime']})</footer>
            </blockquote>
            <blockquote class="col-2"><a href="#" class="btn btn-sm btn-primary voteUp">&uArr;</a> 0 <a href="#" class="btn btn-sm btn-primary voteUp">&dArr;</a></blockquote>
        </div>
    </div>
    `;
    div.innerHTML = postTemp;
    if(post['imageURL'] == undefined){
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
        //console.log(data);
        if (data['error']) {
            console.log(data['errorInfo']);
        } else {
            data.forEach(post => {
                postDiv.insertBefore(createPost(post), postDiv.children[0]);
            });
        }
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
        //console.log(data);
        if (data['error']) {
            console.log('ERROR');
        } else {
            postDiv.insertBefore(createPost(data), postDiv.children[0]);
        }
    })
    .catch(res => console.log(res));
}

const getVotes = () => {
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
    })
    .catch(res => console.log(res));
}