<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 offset-3" style="margin-top:60px; background: lightgray; border-radius: 20px; padding: 50px">
                <form action="{{route('login.page')}}" method="post">
                    @csrf
                    <div class="text-center">
                        <h1>Login</h1>
                    </div>
                    <div data-mdb-input-init class="form-outline mt-4">
                        <label class="form-label ms-2" for="form2Example1">Email</label>
                        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                    </div>

                    <div data-mdb-input-init class="form-outline mt-4">
                        <label class="form-label ms-2" for="form2Example2">Password</label>
                        <input type="password" name="password" id="form2Example2" class="form-control"  placeholder="Password"/>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-primary btn-block" style="width:100px">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
