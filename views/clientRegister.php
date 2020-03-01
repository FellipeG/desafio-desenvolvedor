<?php 

    include_once(__DIR__ . '/../utils/functions.php');

    siteHeader();

    navBar();

?>

    <div class="container">
        <form id="formClientGetData">
            <h1 class="h3 mb-3 mt-3 font-weight-normal">Cadastro de Cliente</h1>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" />
            </div>
            <button type="button" class="btn btn-primary" onclick="new Client().registerClient()">Cadastrar</button>
        </form>
    </div>

<?php

    siteFooter();

?>