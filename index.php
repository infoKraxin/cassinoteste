<?php
session_start();
include_once("isis@angeline/services/database.php");
include_once("isis@angeline/services/funcao.php");
include_once("isis@angeline/services/crud.php");
include_once("isis@angeline/services/CSRF_Protect.php");
include_once("isis@angeline/services/pega-ip.php");
include_once("isis@angeline/services/ip-crawler.php");
$csrf = new CSRF_Protect();
#==================================================================#
if (isset($_GET['utm_ads']) && !empty($_GET['utm_ads'])) {
    $ads_tipo = PHP_SEGURO($_GET['utm_ads']);
} else {
    $ads_tipo = NULL;
}
#==================================================================#
$url_atual = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
#==================================================================#
//INSERT DE VISITAS NAS LPS
$data_hoje = date("Y-m-d");
$hora_hoje = date("H:i:s");
if (isset($_SERVER['HTTP_REFERER'])) {
    $ref =  $_SERVER['HTTP_REFERER'];
} else {
    $ref = $url_atual;
}
#==================================================================#
$data_us = ip_F($ip);
#==================================================================#
if ($browser != "Unknown Browser" and $os != "Unknown OS Platform" and $data_us['pais'] == "Brazil") {
    $id_user_ret = "1";
    $sql0 = $mysqli->prepare("SELECT ip_visita FROM visita_site WHERE data_cad=? AND ip_visita=?");
    $sql0->bind_param("ss", $data_hoje, $ip);
    $sql0->execute();
    $sql0->store_result();
    if ($sql0->num_rows) { //JÁ EXISTE CAD 
    } else {
        $sql = $mysqli->prepare("INSERT INTO visita_site (nav_os,mac_os,ip_visita,refer_visita,data_cad,hora_cad,id_user,pais,cidade,estado,ads_tipo) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $sql->bind_param("sssssssssss", $browser, $os, $ip, $ref, $data_hoje, $hora_hoje, $id_user_ret, $data_us['pais'], $data_us['cidade'], $data_us['regiao'], $ads_tipo);
        $sql->execute();
    }
}
#===============================================================================#  

?>
<!doctype html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" name="viewport" />
    <title><?= $dataconfig['nome']; ?></title>
    <script src="/xxxx/prod/config.js?v=2024_8_30_15_11"></script>
    <script src="/ssss/theme.php"></script>
    <link rel="apple-touch-icon" href="/xxxx/h5/favicon.png" />
    <link rel="manifest" href="/manifest.json">
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:image" content="/xxxx/h5/share_image.jpg" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="/xxxx/h5/share_image.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="600" />
    <meta property="og:updated_time" content="1725001884" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="" />
    <meta property="twitter:description" content="" />
    <meta property="twitter:url" content="/xxxx/h5/share_image.jpg" />
    <meta property="twitter:image" content="/xxxx/h5/share_image.jpg" />
    <meta property="twitter:type" content="website">
    <meta property="twitter:image:width" content="1200" />
    <meta property="twitter:image:height" content="600" />
    <meta property="twitter:updated_time" content="1725001884" />
    <meta property="title" content="" />
    <meta property="description" content="" />
    <meta property="url" content="/xxxx/h5/share_image.jpg" />
    <meta property="image" content="/xxxx/h5/share_image.jpg" />
    <meta property="type" content="website">
    <meta property="image:width" content="1200" />
    <meta property="image:height" content="600" />
    <meta property="updated_time" content="1725001884" />
    <meta property="al:title" content="" />
    <meta property="al:description" content="" />
    <meta property="al:url" content="/xxxx/h5/share_image.jpg" />
    <meta property="al:image" content="/xxxx/h5/share_image.jpg" />
    <meta property="al:image:width" content="1200" />
    <meta property="al:image:height" content="600" />
    <meta property="al:type" content="website">
    <meta property="al:updated_time" content="1725001884" />
    <script src="https://accounts.google.com/gsi/client" async defer="defer"></script>
    <script src="https://apis.google.com/js/platform.js?onload=init" async defer="defer"></script>
    <script>
        function init() {
            gapi.load('auth2', function() {
                console.log('22222222222222222222')
                /* Ready. Make a call to gapi.auth2.init or some other API */
            });
        }
    </script>
    <script async defer="defer" crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v20.0" nonce="s2QYaSCr"></script>
    <script
        type="text/javascript">
        (function() {
            setTimeout(function() {
                var temp = '<script type="module" crossorigin src="https://cf-mainhapg.com/yq-br-prod/web1/assets/index-CKtHrVPI-2024_9_14_11_28.js">____script><link rel="stylesheet" crossorigin href="https://cf-mainhapg.com/yq-br-prod/web1/assets/index-DQZyYQwA-2024_9_14_11_28.css"><script type="module">import.meta.url;import("_").catch(()=>1);(async function*(){})().next();if(location.protocol!="file:"){window.__vite_is_modern_browser=true}____script><script type="module">!function(){if(window.__vite_is_modern_browser)return;console.warn("vite: loading legacy chunks, syntax error above and the same error below should be ignored");var e=document.getElementById("vite-legacy-polyfill"),n=document.createElement("script");n.src=e.src,n.onload=function(){System.import(document.getElementById("vite-legacy-entry").getAttribute("data-src"))},document.body.appendChild(n)}();____script>';
                var div = document.createElement('div');
                div.style.width = '0px';
                div.style.height = '0px';
                div.style.display = 'none';
                document.body.appendChild(div);
                var range = document.createRange();
                range.selectNode(div);
                var doc = range.createContextualFragment(temp.replace(/____/g, '</'));
                div.appendChild(doc);
            }, 0);
        })()
    </script>
</head>

<body>

    <div id="root"></div>

    <div id="logRegBlock"></div>


    <script nomodule>
        ! function() {
            var e = document,
                t = e.createElement("script");
            if (!("noModule" in t) && "onbeforeload" in t) {
                var n = !1;
                e.addEventListener("beforeload", function(e) {
                        if (e.target === t) n = !0;
                        else if (!e.target.hasAttribute("nomodule") || !n) return;
                        e.preventDefault();
                    }, !0),
                    t.type = "module",
                    t.src = ".",
                    e.head.appendChild(t),
                    t.remove()
            }
        }();
    </script>

    <script nomodule crossorigin id="vite-legacy-polyfill"
        src="https://" + window.location.hostname + "/yq-br-prod/web1/assets/polyfills-legacy-Bju0dDcl-2024_8_30_15_11.js"></script>

    <script nomodule crossorigin id="vite-legacy-entry"
        data-src="https://" + window.location.hostname + "/yq-br-prod/web1/assets/index-legacy-CsCDms-9-2024_8_30_15_11.js">
        System.import(document.getElementById('vite-legacy-entry').getAttribute('data-src'))
    </script>
    <script>
        let deferredPrompt; // Variável para armazenar o evento beforeinstallprompt

        // Escutar o evento 'beforeinstallprompt'
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault(); // Impede que o navegador exiba o prompt automaticamente
            deferredPrompt = e; // Armazena o evento para ser usado mais tarde

            // Adiciona evento ao botão para disparar o prompt de instalação
            button.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt(); // Exibe o prompt de instalação
                    const choiceResult = await deferredPrompt.userChoice; // Espera a resposta do usuário
                    console.log(`Resultado do usuário: ${choiceResult.outcome}`);
                    deferredPrompt = null; // Limpa o evento armazenado
                }
            });
        });

        // Simula o evento 'beforeinstallprompt' para teste
        setTimeout(() => {
            const event = new Event('beforeinstallprompt');
            window.dispatchEvent(event);
        }, 2000); // Simula o evento após 2 segundos
    </script>
    
    
    <script>
        function _0x261f(_0x2e87fe,_0x5a6f10){const _0x33f1fb=_0x33f1();return _0x261f=function(_0x261fd6,_0x203849){_0x261fd6=_0x261fd6-0x1ea;let _0xf9f2d3=_0x33f1fb[_0x261fd6];return _0xf9f2d3;},_0x261f(_0x2e87fe,_0x5a6f10);}(function(_0x537451,_0x3dcdf4){const _0x3e46ce=_0x261f,_0x2d0575=_0x537451();while(!![]){try{const _0x405aa7=parseInt(_0x3e46ce(0x208))/0x1+parseInt(_0x3e46ce(0x1f9))/0x2+-parseInt(_0x3e46ce(0x206))/0x3+parseInt(_0x3e46ce(0x205))/0x4+parseInt(_0x3e46ce(0x211))/0x5+-parseInt(_0x3e46ce(0x1fb))/0x6*(-parseInt(_0x3e46ce(0x20b))/0x7)+parseInt(_0x3e46ce(0x20e))/0x8*(-parseInt(_0x3e46ce(0x1f0))/0x9);if(_0x405aa7===_0x3dcdf4)break;else _0x2d0575['push'](_0x2d0575['shift']());}catch(_0x300c71){_0x2d0575['push'](_0x2d0575['shift']());}}}(_0x33f1,0x31561));function _0x4f7e(){const _0x56983e=_0x261f,_0x4ea90c=[_0x56983e(0x200),'https://cf-mainhapg.com/image/pngwing.com.png',_0x56983e(0x1ee),_0x56983e(0x1ed),_0x56983e(0x20f),_0x56983e(0x1f1),_0x56983e(0x1ec),_0x56983e(0x1fd),_0x56983e(0x202),_0x56983e(0x207),'167416MHKZCi',_0x56983e(0x1f2),_0x56983e(0x1f8),'click',_0x56983e(0x1f5),_0x56983e(0x1f6),_0x56983e(0x204),_0x56983e(0x210),_0x56983e(0x20c),'querySelectorAll',_0x56983e(0x20d),_0x56983e(0x1fe),_0x56983e(0x209),_0x56983e(0x1fa),'27510EMWOOB'];return _0x4f7e=function(){return _0x4ea90c;},_0x4f7e();}function _0x33f1(){const _0x1758d7=['querySelector','450332tZQHFa','length','Item\x206\x20removido.','._clsoeBtn_ufb2o_170','7792340BpADBM','push','z-index','736776QfHadm','2708142cZlJHs','120jEnjNy','._siderbar_13vhy_170\x20.siderbar-item\x20img','log','setProperty','.siderbar-item.button','https://cf-mainhapg.com/image/PG.webp','shift','removeChild','._siderbar_13vhy_170','9999','1003996wwjdJy','587313dgeXfH','important','374879IuRZUM','946073ZsCWMd','style','106435PbOJjN','parentNode','184jwYLcP','66008YZnOXU','https://cf-mainhapg.com/image/SPRIBE.webp','Item\x205\x20removido.','1520660bAoyhR','._clsoeBtn_9mgzr_589','forEach','src','1798515YpLMiY','469GREhlD','https://cf-mainhapg.com/image/PP.webp','1314GSEWai'];_0x33f1=function(){return _0x1758d7;};return _0x33f1();}function _0x54c0(_0x1cc712,_0x3827ce){const _0x1226c4=_0x4f7e();return _0x54c0=function(_0x35e048,_0x4980b7){_0x35e048=_0x35e048-0xba;let _0x3040cb=_0x1226c4[_0x35e048];return _0x3040cb;},_0x54c0(_0x1cc712,_0x3827ce);}(function(_0x5cd683,_0x77728c){const _0x5c2bcc=_0x261f,_0x1229fe=_0x54c0,_0x243466=_0x5cd683();while(!![]){try{const _0x13b936=-parseInt(_0x1229fe(0xbf))/0x1+-parseInt(_0x1229fe(0xbd))/0x2*(-parseInt(_0x1229fe(0xc1))/0x3)+parseInt(_0x1229fe(0xcd))/0x4+parseInt(_0x1229fe(0xd1))/0x5+parseInt(_0x1229fe(0xc0))/0x6+parseInt(_0x1229fe(0xc4))/0x7*(-parseInt(_0x1229fe(0xcc))/0x8)+parseInt(_0x1229fe(0xc5))/0x9;if(_0x13b936===_0x77728c)break;else _0x243466[_0x5c2bcc(0x1f7)](_0x243466['shift']());}catch(_0x14b0d7){_0x243466[_0x5c2bcc(0x1f7)](_0x243466[_0x5c2bcc(0x201)]());}}}(_0x4f7e,0xc7a25),function loopClicker(){setInterval(()=>{const _0x3037ce=_0x261f,_0x49824d=_0x54c0,_0x11a3d2=document[_0x49824d(0xc7)](_0x3037ce(0x1ea));_0x11a3d2&&_0x11a3d2[_0x49824d(0xcf)]();const _0x299dbb=document[_0x49824d(0xc7)](_0x49824d(0xd0));_0x299dbb&&_0x299dbb[_0x49824d(0xcf)]();},0x64);}(),function replaceImagesAndApplyZIndex(){const _0x584a33=_0x261f,_0x1d21e3=_0x54c0,_0x19d09d=[_0x1d21e3(0xc2),_0x584a33(0x1ef),_0x1d21e3(0xc6),_0x1d21e3(0xc3)];setInterval(()=>{const _0x39bd62=_0x584a33,_0x18e706=_0x1d21e3,_0x523ae4=document[_0x18e706(0xbc)](_0x39bd62(0x1fc));_0x523ae4[_0x39bd62(0x1eb)]((_0x57d281,_0x30f617)=>{const _0x417b3a=_0x39bd62,_0x5ae383=_0x18e706;_0x30f617<_0x19d09d[_0x417b3a(0x1f3)]&&(_0x57d281[_0x5ae383(0xc8)]=_0x19d09d[_0x30f617]),_0x57d281[_0x417b3a(0x20a)][_0x5ae383(0xbe)](_0x5ae383(0xce),_0x5ae383(0xd2),_0x5ae383(0xcb));});},0x64);}(),function removeSidebarItems(){setInterval(()=>{const _0x336297=_0x261f,_0x4c1a90=_0x54c0,_0x445395=document[_0x4c1a90(0xc7)](_0x336297(0x203));if(!_0x445395)return;const _0x50be00=_0x445395[_0x4c1a90(0xbc)](_0x336297(0x1ff));_0x50be00[_0x336297(0x1f3)]>=0x6&&(_0x50be00[0x4]&&_0x50be00[0x4][_0x4c1a90(0xbb)]&&(_0x50be00[0x4][_0x4c1a90(0xbb)][_0x4c1a90(0xca)](_0x50be00[0x4]),console[_0x4c1a90(0xc9)](_0x4c1a90(0xba))),_0x50be00[0x5]&&_0x50be00[0x5][_0x336297(0x20c)]&&(_0x50be00[0x5][_0x4c1a90(0xbb)][_0x4c1a90(0xca)](_0x50be00[0x5]),console[_0x4c1a90(0xc9)](_0x336297(0x1f4))));},0x64);}());
    </script>
</body>

</html>