<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> Data </title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@300&display=swap" rel="stylesheet">
  <style>
        html, body {font-family: 'Mukta', sans-serif; background:#EEF0F2; color:#353B3C; margin:0; padding:0;}
        a {text-decoration: none;}
        a:link {}
        a:visited {}
        a:hover {}
        table {border-collapse: collapse;}

        .header {display:flex; justify-content:flex-start; font-size: 20px; background:#846A6A; width:100%; height: 150px;}
        .butts {display:flex; flex-direction:column; justify-content: center; height: 150px; width: 220px;}
        .butt_href {display:block; width:220px; height:50px; margin:8px 0px 8px 0px;text-align:left;}
        .icon {width:22px; height:22px; vertical-align: middle; padding-right:5px;}
        .href {font-size: 25px; vertical-align: middle; color:#846A6A;}
        
        .butt_logout {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:right; background:#cfebf3; 
            border:0px; border-radius:10px; display: flex; align-items:center; Justify-content: flex-start; padding:1px 6px;}
        .logout_icon {width:26px; height:26px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        
        .greet {display:flex; justify-content: center; font-size: 45px; color:#EEF0F2; height:150px; width:1236px;}

        .ip_content {text-align: left; width:1380px; margin:auto; margin-bottom:2px;}
        .ip {margin-bottom:-14px;}
        .cards {display: flex; flex-wrap: wrap; justify-content: center; align-items: center; align-content: center; margin-top:0px;}
        .card {display: inline-block; padding:20px; font-size: 20px; text-align:center; margin:10px; border-radius:10px; width:420px; background:#F6F7F8; box-shadow:0 2px 10px rgba(132, 106, 106, .3)}

        .date {font-size: 30px; text-align:center; color:#846A6A; vertical-align: middle; margin:0px;}
        .date_limit {border-bottom: 1px solid rgba(132, 106, 106, .3);}
        .date_icon {width:33px; height:33px; vertical-align: middle;}

        .row {font-size: 20px; text-align:left; border-bottom: 1px solid rgba(132, 106, 106, .3);}
        .data {padding:5px;}

  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">
                    <button class="butt_href">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <a class="href" href="../errors"> Errors </a>
                    </button>

                    <button class="butt_href">
                        <img class="icon" src = "{{url_for('static', filename='files.png')}}"> </img>
                        <a class="href" href="../data"> Data </a> 
                    </button>

                </div>

                <div class="greet">
                    <p> Errors </p>
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

        <!-- <div class="greet">
                <p> Data </p>
        </div> -->

        <div class="ip_content">
            <h1 class="ip"> {{ results.ip }} </h1>
        </div>

        {% for res in result %}
        <div class="cards">
            {% for i in range(3) %}
            <div class="card">
                <table>

                    <thead>
                        <tr>
                            <th colspan="2" class="date_limit"> 
                                <img class="date_icon" src = "{{url_for('static', filename='time_icon.png')}}">
                                <p class="date"> {{ date }} </p>
                            </th>
                        </tr>
                    </thead>
                    
                    {% for err in res.answers %}
                    <tbody>
                        <tr class="row"> 
                            <td class="data"> errorIndication </td>
                            <td class="data"> {{ err.errorIndication }} </td>
                        </tr>

                        <tr class="row"> 
                            <td class="data"> errorStatus </td>
                            <td class="data"> {{ err.errorStatus }} </td>
                        </tr> 

                        <tr class="row"> 
                            <td class="data"> errorIndex </td>
                            <td class="data"> {{ err.errorIndex }} </td>
                        </tr>

                    </tbody>
                    {% endfor %}
                </table>
                </div>
            {% endfor %}
            </div>
        {% endfor %}
        </div>
    </body>
</html>