<div id="debug"></div>
<div class="container">
    <a href="/api/messages.php?id=<?=$_GET['id']?>">Récupérer les données en JSON</a>
    <div id="message-header">
        <div id="messages"></div>
    </div>
    <div class="message-container">
        <form action="" id="messageForm" autocomplete="off" onsubmit="return false">
            <input type="text" name="message" id="message" placeholder="Envoyer un message...">
        </form>
    </div>
</div>
