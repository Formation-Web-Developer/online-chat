const messageHeader = document.getElementById('message-header');
const channels = document.getElementById('messages');
const message = document.getElementById('message');

const author = document.querySelectorAll('meta[name="pseudo"]')[0].getAttribute('content');
const channel = document.querySelectorAll('meta[name="channel"]')[0].getAttribute('content');

message.addEventListener('keyup', (event) => {
    if(event.key === 'Enter' && message.value.length > 0){
        sendMessage(author, channel, message.value);
        message.value = '';
    }
});

function getMessages(scrollForce = false)
{
    const ajax = new XMLHttpRequest();

    ajax.onreadystatechange = (ev) => {
        if(ajax.readyState === 4 && ajax.status === 200){
            const scroll = messageHeader.scrollTop >= (messageHeader.scrollHeight - messageHeader.clientHeight - 10);
            channels.innerHTML = '';
            JSON.parse(ajax.response).forEach(buildMessage);
            if(scroll || scrollForce){
                setTimeout(() => messageHeader.scroll(0, messageHeader.scrollHeight), 10)
            }
        }
    };

    ajax.open('GET', '/api/messages.php?id='+channel);
    ajax.send();
}

function buildMessage(message)
{
    const element = document.createElement('div');
    element.className = 'message';

    if(message.author){
        const author = document.createElement('h2');
        author.className = 'author';
        author.append(document.createTextNode(message.author));
        element.append(author);
    }

    element.append(document.createTextNode(message.message));
    channels.append(element);
}

function sendMessage(author, channel, message)
{
    if(author.length > 2){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = (ev) => {
            if(ajax.readyState === 4 && ajax.status === 200){
                document.getElementById('debug').innerHTML = ajax.response;
                getMessages(true);
            }
        };

        ajax.open('POST', '/api/messages.php');
        const data = new FormData();
        data.set('message', message);
        data.set('author', author);
        data.set('channel', channel);
        ajax.send(data);
    }
}

setInterval(getMessages, 1000);
getMessages(true);
