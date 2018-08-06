<html>
    <head>
        <style>
            /*    --------------------------------------------------
            :: Login Section
            -------------------------------------------------- */
            #login {
                padding-top: 50px
            }
            #login .form-wrap {
                width: 30%;
                margin: 0 auto;
            }
            #login h1 {
                color: #1fa67b;
                font-size: 18px;
                text-align: center;
                font-weight: bold;
                padding-bottom: 20px;
            }
            #login .form-group {
                margin-bottom: 25px;
            }
            #login .checkbox {
                margin-bottom: 20px;
                position: relative;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                -o-user-select: none;
                user-select: none;
            }
            #login .checkbox.show:before {
                content: '\e013';
                color: #1fa67b;
                font-size: 17px;
                margin: 1px 0 0 3px;
                position: absolute;
                pointer-events: none;
                font-family: 'Glyphicons Halflings';
            }
            #login .checkbox .character-checkbox {
                width: 25px;
                height: 25px;
                cursor: pointer;
                border-radius: 3px;
                border: 1px solid #ccc;
                vertical-align: middle;
                display: inline-block;
            }
            #login .checkbox .label {
                color: #6d6d6d;
                font-size: 13px;
                font-weight: normal;
            }
            #login .btn.btn-custom {
                font-size: 14px;
                margin-bottom: 20px;
            }
            #login .forget {
                font-size: 13px;
                text-align: center;
                display: block;
            }

            /*    --------------------------------------------------
                :: Inputs & Buttons
                -------------------------------------------------- */
            .form-control {
                color: #212121;
            }
            .btn-custom {
                color: #fff;
                background-color: #1fa67b;
            }
            .btn-custom:hover,
            .btn-custom:focus {
                color: #fff;
            }

            /*    --------------------------------------------------
                :: Footer
                -------------------------------------------------- */
            #footer {
                color: #6d6d6d;
                font-size: 12px;
                text-align: center;
            }
            #footer p {
                margin-bottom: 0;
            }
            #footer a {
                color: inherit;
            }
        </style>
        <style>
            .new-select {
                display: inline-block;
            }
        </style>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });        </script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!------ Include the above in your HEAD tag ---------->
    </head>

    <body>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-wrap">
                            <h1>BBIN Login</h1>
                            <form role="form" action="/user/login" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="key" class="sr-only"></label>
                                    <input type="text" name="account" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="key" class="sr-only"></label>
                                    <input type="password" name="password" id="key" class="form-control" value="">
                                </div>
                                    <div style="text-align:center">
                                        <li class="new-select">
                                            <div class="checkbox checkbox-circle">
                                                <input id="radio1" class="styled" type="radio" name="lang" value="zh-TW" checked>
                                                <input type="hidden" name="currency" value="CNY" checked>
                                                <label for="radio1" class="font-bolder">繁(zh-TW)
                                                </label>
                                            </div>
                                        </li>
                                        <li class="new-select">
                                            <div class="checkbox checkbox-circle">
                                                <input id="radio2" class="styled" type="radio" name="lang" value="zh-CN">
                                                <label for="radio2" class="font-bolder">簡(zh-CN)
                                                </label>
                                            </div>
                                        </li>
                                        <li class="new-select">
                                            <div class="checkbox checkbox-circle">
                                                <input id="radio3" class="styled" type="radio" name="lang" value="en-US">
                                                <label for="radio3" class="font-bolder">英(en-US)
                                                </label>
                                            </div>
                                        </li>
                                    </div>

                                <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Login">
                            </form>
                            <a href="/bbin/register">註冊</a>
                            <hr>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Recovery password</h4>
                    </div>
                    <div class="modal-body">
                        <p>Type your email account</p>
                        <input type="email" name="recovery-email" id="recovery-email" class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-custom">Recovery</button>
                    </div>
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div> <!-- /.modal -->

        {{--<footer id="footer">--}}
 {{----}}
        {{--</footer>--}}
    </body>

</html>
