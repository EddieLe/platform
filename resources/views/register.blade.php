<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
<!------ Include the above in your HEAD tag ---------->
    <body>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
        <form class="form-horizontal" action="{{ action('LoginController@createUser') }}" method="POST">
            <fieldset>
                <div id="legend">
                    <legend class="">Register</legend>
                </div>
                <div class="control-group">
                    <!-- Username -->
                    <label class="control-label"  for="username">Username</label>
                    <div class="controls">
                        <input type="text" id="username" name="username" placeholder="" class="input-xlarge" value="">
                        {{--<p class="help-block">Username can contain any letters or numbers, without spaces</p>--}}
                    </div>
                </div>

                <div class="control-group">
                    <!-- Password-->
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" id="password" name="password" placeholder="" class="input-xlarge" value="">
                        {{--<p class="help-block">Password should be at least 4 characters</p>--}}
                    </div>
                </div>

                {{--<div class="control-group">--}}
                    {{--<!-- Password -->--}}
                    {{--<label class="control-label"  for="password_confirm">Password (Confirm)</label>--}}
                    {{--<div class="controls">--}}
                        {{--<input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">--}}
                        {{--<p class="help-block">Please confirm password</p>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="control-group">
                    <!-- Button -->
                    <div class="controls">
                        <button class="btn btn-success">Register</button>
                        <br>
                        <br>
                        <a href="/bbin/login">登入頁</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </body>
</html>