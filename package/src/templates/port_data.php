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

        .header {display:flex; justify-content:flex-start; font-size: 20px; width:100%; height: 150px;}
        .butts {display:flex; flex-direction:column; justify-content: center; height: 150px; width: 200px; margin-left:20px;}
        .butt_href {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:left; background:#cfebf3; border:0px; border-radius:10px; display: flex; align-items:center; padding:1px 6px;}
        .icon {width:22px; height:22px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        .href {font-size: 26px; vertical-align: middle; color:#020428;}

        .butt_logout {width:180px; height:50px; margin:8px 0px 8px 0px; text-align:right; background:#cfebf3; 
            border:0px; border-radius:10px; display: flex; align-items:center; Justify-content: flex-start; padding:1px 6px;}
        .logout_icon {width:26px; height:26px; vertical-align: middle; padding-right:10px; margin-left:10px;}
        
    
        .greet {display:flex; justify-content: center; font-size: 45px; height:150px; width:1236px;}

        .port_content {text-align: center; margin-left:220px; display:flex; align-items:center; justify-content: flex-start; margin-top:-25px; }
        .port {color:#020428; vertical-align: middle; font-size: 45px;}
        .cards {display: flex; flex-wrap: wrap; justify-content: flex-start; align-items: center; align-content: center; margin-top:-30px; margin-left:210px;}
        .card {display: inline-block; padding:20px; font-size: 20px; text-align:center; margin:10px; border-radius:10px; 
        width:990px; background:#F6F7F8; box-shadow:0 2px 10px rgba(132, 106, 106, .3); background: linear-gradient(#cfebf3 123px, #F6F7F8 123px);}

        .date {font-size: 30px; text-align:center; color:#020428; vertical-align: middle; margin:0px;}
        .date_limit {border-bottom: 1px solid rgba(132, 106, 106, .3);}

        .date_icon {width:40px; height:40px;}
        .port_icon {width:53px; height:53px; margin-right:10px;}
        .port_num {font-size: 30px; text-align:right; color:#020428; vertical-align: middle; margin:0px;}

        .row {font-size: 20px; text-align:left; border-bottom: 1px solid rgba(2, 4, 40, .3);}
        .data {padding:5px;}

  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">

                    <a class="button butt_href" href="../../errors">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <span class="href"> Errors </span>
                    </a>

                    <a class="button butt_href" href="../../data">
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

        <div class="port_content">
            <img class="port_icon" src = "{{url_for('static', filename='usbport.png')}}">
            <strong> <p class="port"> PORT {{port}} </p> </strong>
        </div>

        {% for res in result %}
        <div class="cards">
            <div class="card">
                <table>

                    <thead>
                        <tr>
                            <th colspan="2" class="date_limit"> 
                                <img class="date_icon" src = "{{url_for('static', filename='date_icon.png')}}">
                                <p class="date"> {{ date }} </p>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                            {% for resp in res.answers %}
                                {% if resp.errorIndication %}
                                    <tr class="row"> 
                                        <td class="data"> errorIndication </td>
                                        <td class="data"> {{ resp.errorIndication }} </td>
                                    </tr>

                                {% elif resp.errorStatus %}
                                    <tr class="row"> 
                                        <td class="data"> errorStatus </td>
                                        <td class="data"> {{ resp.errorStatus }} </td>
                                    </tr> 

                                    <tr class="row"> 
                                        <td class="data"> errorIndex </td>
                                        <td class="data"> {{ resp.errorIndex }} </td>
                                    </tr>
                                    
                                {% else %}
                                    {% for varBind in resp.varBinds %}
                                        <tr class="row"> 
                                            <td class="data"> varBind </td>
                                            <td class="data"> {{ varBind }} </td>
                                        </tr>
                                    {% endfor %}
                                {% endif %}

                            {% endfor %}

                        </tbody>

                </table>
                </div>
            </div>
        {% endfor %}
        </div>
    </body>
</html>