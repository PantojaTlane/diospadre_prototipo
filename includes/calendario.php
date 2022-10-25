<!--Aqui mostramos este modal con una condicion en PHP si existe el correo en la url-->
<section id="section-reservacion">
    <div id="reservacion-modal">
        <a href="bienvenida.php?<?=$bienvenida?>"><i class="fa-solid fa-rectangle-xmark" id="closeReser"></i></a>
        <h1>Define tu <span>dia</span> de llegada</h1>
        <i class="fa-sharp fa-solid fa-calendar-days"></i>
        <form action="bienvenida.php?compra=true&<?=$bienvenida?>" method="post" id="formDate">
            <input type="date" name="date" id="date">
            <input type="submit" value="Pagar" id="btnPagar" disabled class="disable-btnpagar">
        </form>
    </div>
</section>