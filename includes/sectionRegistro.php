<section id="sectionRegistro" class="hide-section-registro">
    <button id="btnRegistro">
        <?php if(!isset($_GET['code'])): ?>
        <a href="<?= $client->createAuthUrl() ?>"><img src="./img/logo.svg" alt="google">Iniciar sesión con Google</a>
        <?php endif;?>
    </button>    
</section>