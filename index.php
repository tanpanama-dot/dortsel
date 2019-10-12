<?php
session_start(); #list: key, msisdn, otp, secret_token
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Pencari Proxy © 2019</title>
    <link rel="shortcut icon" href="https://resources.1337route.cf/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
</head>
<?php
    date_default_timezone_set('Asia/Jakarta');
    
    require_once('config.php');
    require('class.php');
    
    $err    = NULL;
    $ress   = NULL;
    
    if (isset($_POST) and isset($_POST['do'])){
        
        switch($_POST['do']){
            
            default: die(); exit(); break;

            case "CHANGE":{
                $key    = $_SESSION['key'];
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_SESSION['tipe'];
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            case "LOGOUT":{
                
                $key            = $_SESSION['key'];
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $otp            = $_SESSION['otp'];
                $secret_token   = $_SESSION['secret_token'];
                
                
                $tsel = new MyTsel();
                $tsel->logout($secret_token, $tipe);
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            
            case "GETOTP":{
                $key    = $_POST['key'];
                $msisdn = $_POST['msisdn'];
                
                
                if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                if ($tsel->get_otp($msisdn) == "SUKSES"){
                    
                    session_regenerate_id();
                    $_SESSION['key'] = $key;
                    $_SESSION['msisdn'] = $msisdn;                    
                    session_write_close();

                }
                else
                {
                    $err = "Error: msisdn salah";
                }
            }
            break;
            
            case "LOGIN":{
                $key    = $_SESSION['key'];
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_POST['tipe'];
                $otp    = $_POST['otp'];
                
                //if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                $login = $tsel->login($msisdn, $otp, $tipe);
                
                
                if (strlen($login) > 0){

                    $secret_token               = trim(preg_replace('/\s+/', ' ', $login));
                    $_SESSION['otp']            = $otp;
                    $_SESSION['secret_token']   = $secret_token;
                    $_SESSION['tipe']           = $tipe;
                    
                    
                } else {
                    //echo $login;
                    $err = $login;
                }

                
            }
            break;
            
            case "BUY_PKG":{
                $key            = $_SESSION['key'];
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $secret_token   = $_SESSION['secret_token'];
                $pkgid          = $_POST['pkgid'];
                $transactionid  = $_POST['transactionid'];
                
                switch($_POST['pkgid']){
                case '1':
                    $pkgidman = $_POST['pkgidman'];
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgidman."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgidman, $transactionid, $tipe);
                break;
                default:
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgid."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgid, $transactionid, $tipe);
                }
                
            }
            break;
            
        }
        
    }
?>
<link href="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
<link href="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">

<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<link href="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

<link href="https://colorlib.com/etc/regform/colorlib-regform-4/css/main.css" rel="stylesheet" media="all">
<!-- ################################ 1 ################################ -->
<?php if (!isset($_SESSION['key']) and !isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['secret_token']) ){ ?>
<body>
<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
<div class="wrapper wrapper--w680">
<div class="card card-4">
<div class="card-body">
<h2 class="title">Dor Tsel V2 Team Pencari Proxy 2019</h2>
    <form method="POST">
    <pre>
<div class="row row-space">
<div class="col-2">
<div class="input-group">
<label class="label">Nomer Hp</label>
<input type="number" class="input--style-4" name="msisdn" placeholder="628xxx">
</div>
</div>
<div class="col-2">
<div class="input-group">
<label class="label">Key</label>
<input type="text" class="input--style-4" name="key">
</div>
</div>
</div>
<div class="p-t-15">
<input class="btn btn--radius-2 btn--blue" name="do" value="GETOTP" type="submit"></input>
</div>
<!-- <input type="submit" name="do" value="GETOTP"></input> -->
<?php if(!empty($err)) echo $err ?> 
    </pre>
</form>
</div>
</div>
</div>
</div>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/jquery/jquery.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/select2/select2.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/datepicker/moment.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/datepicker/daterangepicker.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/js/global.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script type="9ece4f9225c52590d5b1d255-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/95c75768/cloudflare-static/rocket-loader.min.js" data-cf-settings="9ece4f9225c52590d5b1d255-|49" defer=""></script>
</body>

<!-- ################################ 2 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['tipe']) and !isset($_SESSION['secret_token'])){ ?>
<body>
<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
<div class="wrapper wrapper--w680">
<div class="card card-4">
<div class="card-body">
<h2 class="title">Dor Tsel V2 Team Pencari Proxy 2019</h2>
    <form method="POST">
    <pre>
<div class="row row-space">
<div class="col-2">
<div class="input-group">
<label class="label">Channel</label>
<div class="p-t-10">
<label class="radio-container m-r-45">VMP
<input type="radio" checked="checked" name="tipe" value="vmp.telkomsel.com">
<span class="checkmark"></span>
</label>
<label class="radio-container">VMP Prepod
<input type="radio" name="tipe" value="vmp-preprod.telkomsel.com">
<span class="checkmark"></span>
</label>
</div>
</div>
<!-- <input type="radio" name="tipe" value="vmp.telkomsel.com" checked> VMP&nbsp;&nbsp;<input type="radio" name="tipe" value="vmp-preprod.telkomsel.com"> VMP Prepod<br> -->
<div class="col-2">
<div class="input-group">
<label class="label">Msisdn</label>
<input type="text" class="input--style-4" value="<?= $_SESSION['msisdn']; ?>" name="phone">
</div>
</div>
</div>
<div class="p-t-15">
<input class="btn btn--radius-2 btn--blue" name="do" value="CHANGE" type="submit"></input>
</div>
<div class="input-group">
<!--   <input type="submit" name="do" value="CHANGE"></input> -->
<label class="label">Enter Otp</label>
<input type="number" class="input--style-4" name="otp">
</div>
</div>
<div class="p-t-15">
<input class="btn btn--radius-2 btn--blue" name="do" value="LOGIN" type="submit"></input>
</div>
<!-- <input type="submit" name="do" value="LOGIN"></input> -->
<?php if(!empty($err)) echo $err ?>
    </pre>
    </form>
</div>
</div>
</div>
</div>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/jquery/jquery.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/select2/select2.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/datepicker/moment.min.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/vendor/datepicker/daterangepicker.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script src="https://colorlib.com/etc/regform/colorlib-regform-4/vendor/js/global.js" type="9ece4f9225c52590d5b1d255-text/javascript"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="9ece4f9225c52590d5b1d255-text/javascript"></script>
<script type="9ece4f9225c52590d5b1d255-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/95c75768/cloudflare-static/rocket-loader.min.js" data-cf-settings="9ece4f9225c52590d5b1d255-|49" defer=""></script>

</body>


<!-- ################################ 3 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and isset($_SESSION['otp']) and isset($_SESSION['tipe']) and isset($_SESSION['secret_token'])){ ?>
<body>
<form method="POST">
<fieldset>
Key:&nbsp;<?= $_SESSION['key']."<br>" ?>
Msisdn:&nbsp;<?= $_SESSION['msisdn']."<br>" ?>
OTP:&nbsp;<?= $_SESSION['otp']."<br>" ?>
<input type="submit" name="do" value="LOGOUT"></input>
<hr>
<h3><u>Buy Package</u></h3>
PILIH&nbsp;PAKET:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pkgid" onchange="if (this.value=='1'){this.form['pkgidman'].style.visibility='visible'}else {this.form['pkgidman'].style.visibility='hidden'};" style="width: 50%;">
  <option value="00009382">OMG! 1GB 2hari Rp 10</option>
  <option value="00007333">OMG! 30gb 30k</option>
  <option value="1">Manual ID</option>
</select><br>
PKGID:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pkgidman"  style="width: 50%; visibility:hidden;"></input><br>
TRANSACTIONID:<input type="text" name="transactionid" style="width: 50%;" value="A301180826192021277131740"></input><br>
<input type="submit" name="do" value="BUY_PKG"></input><br><br>
<?php if(!empty($ress)) echo $ress ?>
<hr>
</fieldset>
</form>
</body>
<?php } ?>
