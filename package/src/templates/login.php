<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> Data </title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@300&display=swap" rel="stylesheet">
  <style>
        html, body {font-family: 'Mukta', sans-serif; background:#EEF0F2; color:#020428; margin:0; padding:0;}
        a {text-decoration: none;}
        a:link {}
        a:visited {}
        a:hover {}
        table {border-collapse: collapse;}
        thead {border-spacing:0px; cellspacing: 0px;}
        label {font-size: 20px;} 

        .header {display:flex; justify-content:flex-start; font-size: 20px; width:100%; height: 150px;}
        .butts {display:flex; flex-direction:column; justify-content: center; height: 150px; width: 200px; margin-left:20px;}
        .butt_href {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:left; background:#cfebf3; border:0px; border-radius:10px; display: flex; align-items:center; padding:1px 6px;}
        .icon {width:22px; height:22px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        .href {font-size: 26px; vertical-align: middle; color:#020428;}
        /* .greet {font-size: 45px; text-align:center; width:100%; margin-top:-180px !important; color:#EEF0F2; height:180px;} */
        .greet {display:flex; justify-content: center; font-size: 45px; height:150px; width:1236px;}

        .card {width:1236px; display: flex; justify-content:flex-start; margin-left:220px; margin-top:50px;}
        .login_forms {display: flex; flex-direction: column; justify-content:center; align-items: center; align-content: center; 
            width:500px; padding:20px; border-radius:10px;
            background:#cfebf3;}
        .form {width:420px; height: 50px; font-size: 20px; border-radius:10px; margin:10px; border:0px; padding-left:15px;}
        .salute {height: 50px; font-size: 30px;}
        .user_icon {width:45px; height:45px;}
        .remember {display: flex; justify-content:flex-start; width:437px; margin:10px 10px 10px 20px;}
        .choose {transform:scale(2); opacity:0.9; margin-right:15px; }
        .login_butt {background:#020428; color:#EEF0F2; width:437px;}

  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">
                    
                    <a class="button butt_href" href="data">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <span class="href"> Errors </span>
                    </a>

                    <a class="button butt_href" href="errors">
                        <img class="icon" src = "{{url_for('static', filename='files.png')}}"> </img>
                        <span class="href"> Data </span>
                    </a>

                </div>

                <div class="greet">
                    <p> Authentication </p>
                </div>

           </header>

        <div class="card">

                <form class="box login_forms" method="POST" action="/auth/login">

                    <div class="salute">
                        <img class="user_icon" src = "{{url_for('static', filename='user.png')}}">
                    </div>

                    {% if message %}
                        <div class="salute">
                            <span> {{ message }} </span>
                        </div>
                    {% endif %}

                    <div class="field">
                        <div class="control">
                            <input class=" form input is-large" type="email" name="email" placeholder="Your Email" autofocus="">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input class="form input is-large" type="password" name="password" placeholder="Your Password">
                        </div>
                    </div>

                    <div class="remember">
                        <label class="checkbox">
                            <input type="checkbox" class="choose"> 
                            Remember me
                        </label>
                    </div>

                    <button class="login_butt form button is-block is-info is-large is-fullwidth">Login</button>

                </form>
        </div>

    </body>
</html>