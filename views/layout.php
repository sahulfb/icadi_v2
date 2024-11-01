<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTITUTO ICADI - <?php echo $titulo; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php 
            if (is_auth() && strpos($_SERVER['REQUEST_URI'], '/admin') === 0) {
                include_once __DIR__ . '/templates/admin-sidebar.php';
            }
    ?>
      <div class="main-content <?php echo strpos($_SERVER['REQUEST_URI'], '/admin') === 0 ? 'sliding':''?>">
      <?php
      include_once __DIR__ .'/templates/header.php';
      echo $contenido;
      include_once __DIR__ .'/templates/footer.php';
      ?>
  </div>
  <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV['PUBLICA']; ?>"></script>
    <script src="/build/js/main.min.js" defer></script>

    <script>
        function cargarR(form) {
            grecaptcha.ready(function() {
                grecaptcha.execute("<?php echo $_ENV['PUBLICA']; ?>", {action: 'formulario'}).then(function(token) {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'token');
                    input.setAttribute('value', token);
                    form.appendChild(input);
                    form.submit();
                });
            });
        }

        let submit = document.querySelector("#btnSubmit");
        let form_diplomas = document.querySelector("#form__diplomas");

        if(submit) {
            submit.addEventListener("click", function(e) {
                e.preventDefault();
                cargarR(form_diplomas);
            });
        }
    </script>
</body>
</html>