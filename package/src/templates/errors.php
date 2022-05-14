<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> Errors </title>
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

        .header {display:flex; justify-content:flex-start; font-size: 20px; width:100%; height: 150px;}
        .butts {display:flex; flex-direction:column; justify-content: center; height: 150px; width: 200px; margin-left:20px;}
        .butt_href {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:left; background:#cfebf3; border:0px; border-radius:10px; display: flex; align-items:center; padding:1px 6px;}
        .icon {width:22px; height:22px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        .href {font-size: 26px; vertical-align: middle; color:#020428; }

        .butt_logout {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:right; background:#cfebf3; 
            border:0px; border-radius:10px; display: flex; align-items:center; Justify-content: flex-start; padding:1px 6px;}
        .logout_icon {width:26px; height:26px; vertical-align: middle; padding-right:10px; margin-left:10px;}
  
        .greet {display:flex; justify-content: center; font-size: 45px; height:150px; width:1236px;}

        .date_content {text-align: left; width:1380px; margin:auto; margin-bottom:2px; margin-left:210px;}
        .date {margin-bottom:-14px; }
        .cards {display: flex; flex-wrap: wrap; justify-content: center; align-items: center; align-content: center; margin-top:0px;}
        .card {display: inline-block; padding:20px; font-size: 20px; text-align:center; margin:10px; border-radius:10px; width:420px; background:#F6F7F8; box-shadow:0 2px 10px rgba(132, 106, 106, .3)}

        .ip {font-size: 30px; text-align:center; color:#B3404A; vertical-align: middle;}
        .ip_limit {border-bottom: 1px solid rgba(132, 106, 106, .3);}
        .ip:hover {border-bottom: 3px solid #846A6A !important;}
        .ip_icon {width:40px; height:40px; vertical-align: middle;}

        .row {font-size: 20px; text-align:left; border-bottom: 1px solid rgba(132, 106, 106, .3);}
        .data {padding:5px;}

  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">
                    
                    <a class="button butt_href" href="errors">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <span class="href"> Errors </span>
                    </a>

                    <a class="button butt_href" href="data">
                        <img class="icon" src = "{{url_for('static', filename='files.png')}}"> </img>
                        <span class="href"> Data </span>
                    </a>
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

        <div class="date_content">
            <h1 class="date"> {{ date }} </h1>
        </div>

        {% for res in result %}
        <div class="cards">
            {% if res.errorIndication or res.errorStatus %}
                {% for i in range(3) %}
                <div class="card">
                    <table>

                        <thead>
                            <tr>
                                <th colspan="2"> 
                                    <img class="ip_icon" src = "{{url_for('static', filename='ip.png')}}">
                                </th>                  
                            </tr>

                            <tr>
                                <th colspan="2" class="ip_limit">
                                    <a href=errors/{{res.ip}} class="ip"> {{ res.ip }} </a> 
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            {% if res.errorIndication %}
                                <tr class="row"> 
                                    <td class="data"> errorIndication </td>
                                    <td class="data"> {{ res.errorIndication }} </td>
                                </tr>

                            {% elif res.errorStatus %}
                                <tr class="row"> 
                                    <td class="data"> errorStatus </td>
                                    <td class="data"> {{ res.errorStatus }} </td>
                                </tr> 

                                <tr class="row"> 
                                    <td class="data"> errorIndex </td>
                                    <td class="data"> {{ res.errorIndex }} </td>
                                </tr>
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                {% endfor %}
            {% endif %}
        </div>
        {% endfor %}
    </body>
</html>