<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DameSender - Unsuscribe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


</head>

<body>


    <header class="text-white">
        <div class="container text-center">
            <img src="/img/mail.png" class="img-fluid" style="width: 100px;height:100px">

        </div>
    </header>

    <div class="container">

        <div class="d-flex justify-content-center">
            <div class="panel">
                <div class="panel-body">
                    <div class="brand">
                        <h2 class="">Unsubscribe from this service
                            <!-- / Darse de baja de este servicio-->
                        </h2>
                    </div>
                    <form method="POST" action="/unsuscribe">
                        @csrf
                        <input type="hidden" name="campaing" value="{{ $campaing }}">
                        <input type="hidden" name="code" value="{{ $code }}">
                        <p>We're sad to see you go! Please take a moment to tell us why you've decided to unsubscribe.
                            <!-- / ¡Nos entristece verte partir! Tómese un momento para decirnos por qué decidió cancelar la suscripción.-->
                        </p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="motive" id="flexRadioDefault1"
                                value="Don't want to receive your messages anymore">
                            <label class="form-check-label" for="flexRadioDefault1">
                                I don't want to receive these messages anymore / Ya no quiero recibir estos mensajes.
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="motive" id="flexRadioDefault2"
                                value="I never signup for this list" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                I never signed up for this list / Nunca me inscribí en esta lista
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="motive" id="flexRadioDefault3"
                                value="I received too many messages" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                I received too many messages / Recibí demasiados mensajes
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="motive" id="flexRadioDefault4"
                                value="These messages are spam" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                These messages are spam / Estos mensajes son spam
                            </label>
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-danger" type="submit">
                                Yes, unsubscribe me / Si, dame de baja
                            </button>
                        </div>

                        </span><span class="ladda-spinner"></span></button>
                    </form>

                </div>
            </div>
        </div>

    </div>


    <nav class="navbar fixed-bottom navbar-light bg-dark">
        <div class="container-fluid">
            <p class="text-center text-white">Copyright &copy; DameSender</p>

        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>




</body>

</html>
