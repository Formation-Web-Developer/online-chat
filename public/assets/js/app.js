const pseudo = document.getElementById('pseudo');
const pseudoError = document.getElementById('pseudoError');
const channelError = document.getElementById('channelError');
const newChannelName = document.getElementById('newChannelName');
const newChannelCreate = document.getElementById('newChannelCreate');
const channels = document.getElementById('channels');

pseudo.addEventListener('keyup', (ev) => {
    if(pseudo.value.length > 2){
        pseudo.classList.remove('input-error');
        pseudoError.innerText = '';
    }
});
pseudo.addEventListener('blur', checkPseudo);

newChannelName.addEventListener('keyup', (ev) => {
    if(newChannelName.value.length > 3){
        newChannelName.classList.remove('input-error');
        channelError.innerText = '';
    }
});

newChannelCreate.addEventListener('click', (ev) => {
   ev.preventDefault();
   if(checkPseudo()){
       if(newChannelName.value.length > 3){
           newChannel(newChannelName.value);
           newChannelName.classList.remove('input-error');
           channelError.innerText = '';
       }else {
           newChannelName.classList.add('input-error');
           channelError.innerText = 'Le nom du channel doit faire plus de 3 caractères.';
       }
   }
});

function checkPseudo()
{
    if(pseudo.value.length > 2){
        pseudo.classList.remove('input-error')
        pseudoError.innerText = '';
        return true;
    }
    pseudoError.innerText = 'Ce champs doit-être renseigné !';
    pseudo.classList.add('input-error')
    return false;
}

function newChannel(channel){
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = (ev) => {
        if(ajax.status === 200 && ajax.readyState === 4){
            loadResponse(JSON.parse(ajax.response));
        }
    }
    ajax.open('POST', '/api/channels.php');
    const data = new FormData();
    data.set('create', 'true');
    data.set('author', pseudo.value);
    data.set('channel', channel);
    ajax.send(data);
}

function loadResponse(response)
{
    switch (response.type)
    {
        case 'redirect':
            window.location.href = response.href;
            return;
        case 'author':
            pseudoError.innerText = response.message;
            pseudo.classList.add('input-error')
            return;
        case 'channel':
            channelError.innerText = response.message;
            newChannelName.classList.add('input-error');
            return;
    }
}

function getChannels()
{
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = (event) => {
        if(ajax.readyState === 4 && ajax.status === 200){
            channels.innerHTML = '';
            JSON.parse(ajax.response).forEach(buildChannel);
        }
    }
    ajax.open('GET','/api/channels.php');
    ajax.send();
}

function buildChannel(channel)
{
    const header = document.createElement('div');
    header.classList.add('channel-header');

    const name = document.createElement('h3');
    name.classList.add('channel-name');
    name.append(document.createTextNode(channel.name));

    const owner = document.createElement('span');
    owner.classList.add('channel-owner');
    owner.append(document.createTextNode('Créateur: '+channel.author));

    const count = document.createElement('p');
    count.classList.add('channel-messages');
    count.append(document.createTextNode('Nombre de messages: '+channel.messages));

    header.append(name, owner, count);

    const footer = document.createElement('div');
    footer.classList.add('channel-footer');

    const button = document.createElement('button');
    button.append(document.createTextNode('Se connecter'));
    button.addEventListener('click', (ev) => window.location.href = '/channel.php?id='+channel.id+'&pseudo='+encodeURI(pseudo.value));
    footer.append(button);

    const parent = document.createElement('div');
    parent.classList.add('channel');
    parent.append(header, footer);

    channels.append(parent);
}

setInterval(getChannels, 5000);
getChannels();
