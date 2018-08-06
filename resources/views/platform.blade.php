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
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
                <div style="height:90px;text-align:center;line-height:50px;">
                    　<h3>平台商會員帳戶管理</h3>
                </div>
                <br>
                <hr>
                <div class="row">
                    <div class="col-xs-14">
                        <div>帳號： <span style="color: blue"> {{ $account }}</span></div>
                        <div>目前帳戶餘額： <span style="color: red">{{ $point }} </span></div>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-xs-4">
                                <form action="/transfer" method="post">
                                    {{ csrf_field() }}
                                        <span class="input-group-addon">儲值</span>
                                        <input type="hidden" class="form-control" name="account" value="{{ $account }}">
                                        <input type="hidden" class="form-control" name="action" value="in">
                                        <input type="text" class="form-control" name="point" value="">
                                        <input type="submit" class="btn btn-primary mb-2" value="儲值">
                                </form>
                            </div>
                            <div class="col-xs-4">
                                <form action="/transfer" method="post">
                                    {{ csrf_field() }}
                                    <span class="input-group-addon">轉入遊戲商戶</span>
                                    <input type="hidden" class="form-control" name="account" value="{{ $account }}">
                                    <input type="hidden" class="form-control" name="action" value="transfer">
                                    <input type="text" class="form-control" name="point" value="">                                                                                                <input type="submit" class="btn btn-primary mb-2" value="轉入">
                                </form>
                            </div>
                            <div class="col-xs-4">
                                <form action="/transfer" method="post">
                                    {{ csrf_field() }}
                                    <span class="input-group-addon">提取</span>
                                    <input type="hidden" class="form-control" name="account" value="{{ $account }}">
                                    <input type="hidden" class="form-control" name="action" value="out">
                                    <input type="text" class="form-control" name="point" value="">                                                                                               <input type="submit" class="btn btn-primary mb-2" value="提取">
                                </form>
                            </div>
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="height:500px;text-align:center;line-height:50px;">
            　<button type="button" class="btn btn-danger">進入IN彩票</button>
            <br>
              <a href="/bbin/logout">登出</a>
        </div>
    </body>

</html>
