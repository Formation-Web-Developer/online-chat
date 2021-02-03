<div id="debug"></div>
<div class="container">
    <a href="/api/channels.php">Récupérer les données en JSON</a>
    <h1>Démonstration d'un chat en ligne avec <span class="info">AJAX</span>.</h1>
    <section class="section-channels">
        <input type="text" name="pseudo" id="pseudo" placeholder="Choisissez un pseudo">
        <span class="error" id="pseudoError"></span>
    </section>
    <section class="section-channels">
        <h2>Créer un salon textuel</h2>
        <span class="error" id="channelError"></span>
        <div class="new-channel">
            <input type="text" name="name" placeholder="Nom du channel *" id="newChannelName">
            <!--<input type="password" name="password" placeholder="Mot de passe (non requis)" id="newChannelPassword">-->
            <button id="newChannelCreate">Créer</button>
        </div>
    </section>
    <section class="section-channels">
        <h2>Listes des salons textuels</h2>
        <div id="channels"></div>
    </section>
</div>
