<main>
    <h1>Registrar Usuario</h1>
    <form action="<?=BASE_URL?>usuario/save" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required>

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" required>
        
        <label for="email">Correo</label>
        <input type="email" name="email" required>
        
        <label for="password">Contrase&ntilde;a</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Registrarse">
    </form>