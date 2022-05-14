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

        .header {display:flex; justify-content:flex-start; font-size: 20px; width:100%; height: 150px;}
        .butts {display:flex; flex-direction:column; justify-content: center; height: 150px; width: 200px; margin-left:20px;}
        .butt_href {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:left; background:#cfebf3; border:0px; border-radius:10px; display: flex; align-items:center; padding:1px 6px;}
        .icon {width:22px; height:22px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        .href {font-size: 26px; vertical-align: middle; color:#020428;}
        .greet {display:flex; justify-content: center; font-size: 45px; height:150px; width:1236px;}

        .butt_logout {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:right; background:#cfebf3; 
            border:0px; border-radius:10px; display: flex; align-items:center; Justify-content: flex-start; padding:1px 6px;}
        .logout_icon {width:26px; height:26px; vertical-align: middle; padding-right:10px; margin-left:10px;}

        .ip_content {text-align: left; width:1380px; margin:auto; margin-bottom:2px;}
        .ip {margin-bottom:-14px;}
        .cards {display: flex; flex-wrap: wrap; justify-content: flex-start; align-items: center; align-content: center; margin-top:35px; margin-left:210px;}
        .card {display: flex; justify-content: center; align-items: center; align-content: center; padding:20px; font-size: 20px; text-align:center; margin:10px; border-radius:10px; width:150px; height:100px; box-shadow:0 2px 10px rgba(132, 106, 106, .3)}

        .port_num {font-size: 30px; text-align:center; color:#020428; font-weight:600; vertical-align: middle; margin:0px;}
        .port_limit { width:220px; display:flex; flex-direction:column; justify-content: center; align-items: center; align-content: center;}
        .port_icon {width:67px; height:67px; vertical-align: middle;}

        .row {font-size: 20px; text-align:left; border-bottom: 1px solid rgba(132, 106, 106, .3);}
        .data {padding:5px;}

  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">

                    <a class="button butt_href" href="../errors">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <span class="href"> Errors </span>
                    </a>

                    <a class="button butt_href" href="../data">
                        <img class="icon" src = "{{url_for('static', filename='files.png')}}"> </img>
                        <span class="href"> Data </span>
                    </a>

                </div>

                <div class="greet">
                    <p> {{ ip }} </p>
                </div>

                <div class="butts">

                    {% if current_user.type=="admin" %}
                        <a class="button butt_logout" href="../../../auth/register">
                            <img class="logout_icon" src = "{{url_for('static', filename='logout.png')}}"> </img>
                            <span class="href"> Admin </span>
                        </a>
                    {% endif %}

                    <a class="button butt_logout" href="../../../auth/logout">
                        <img class="logout_icon" src = "{{url_for('static', filename='logout.png')}}"> </img>
                        <span class="href"> Logout </span>
                    </a>
                </div>

        </header>

        <div class="cards">
        {% for i in range(1, ports + 1) %}
            <div class="card">
                <a href={{ip}}/{{i}} class="button">
                    <div class="port_limit">
                        <img class="port_icon" src = "{{url_for('static', filename='usbport.png')}}">
                        <p class="port_num"> {{ i }} </p>
                    </div>
            </div>
            {% endfor %}
        </div>

    </body>
</html>