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

        .card {display: flex; flex-wrap: wrap; justify-content:flex-start; align-items: flex-start; align-content: center; margin-left:200px;}

        .employees_cards {display: flex; flex-direction:column; justify-content:flex-start; align-items: flex-start; align-content: center; margin: 10px 0px 10px 220px;}

        .admins_cards { display: flex;flex-direction:column; justify-content:center; align-content: center; margin-top:10px; margin-left:20px;}

        .user_card {display: flex; justify-content:center; align-items: center; border-radius:10px;
             background:linear-gradient(to right, #cfebf3 72%, #020428 28%);; padding:10px;}

        .user_data {padding:15px 0px 15px 15px; background:#EEF0F2; margin:7px; border-radius:10px; border:0px; font-size: 15px; font-weight:500;}

        .login_forms {display: flex; flex-direction: column; justify-content:center; align-items: center; align-content: center; 
            width:500px; padding:20px; border-radius:10px;
            background:#cfebf3; margin-top:10px; margin-left:20px;}
        .form {width:420px; height: 50px; font-size: 20px; border-radius:10px; margin:10px; border:0px; padding-left:15px;}
        .select_form {width:440px; height: 50px; font-size: 20px; border-radius:10px; margin:10px; border:0px; padding-left:15px; padding-right:15px;}
        .salute {height: 50px; font-size: 30px;}
        .user_icon {width:45px; height:45px;}
        .login_butt {background:#020428; color:#EEF0F2; width:437px;}

        .action_butt {width:50px; height:50px; background:#cfebf3; border-radius:10px; display: flex; justify-content:center; align-items: center; align-content: center; margin:5px;}
        .action_icon {color:rgba(205, 214, 219, 0); border:0px; width:40px; height:40px; padding:0px;}

        .change_icon {background:url('/static/change.png') no-repeat center center; background-size: auto 80%;}
        .remove_icon {background:url('/static/delete.png') no-repeat center center; background-size: auto 80%;}
        .recover_icon {background:url('/static/recovery.png') no-repeat center center; background-size: auto 80%;}

        .username {width:100px;}
        .email {width:180px;}
        .type {width:120px;}
        .remove {font-weight:600; width:80px;}


  </style>
</head>

    <body>

        <header class="header">
                <div class="butts">
                    
                    <a class="button butt_href" href="../api/errors">
                        <img class="icon" src = "{{url_for('static', filename='errors.png')}}"> </img>
                        <span class="href"> Errors </span>
                    </a>

                    <a class="button butt_href" href="../api/data">
                        <img class="icon" src = "{{url_for('static', filename='files.png')}}"> </img>
                        <span class="href"> Data </span>
                    </a>

                </div>

                <div class="greet">
                    <p> Admin Page </p>
                </div>

           </header>

        <div class="card">

                <form class="box login_forms" method="POST" action="/auth/register">

                    <div class="salute">
                        <img class="user_icon" src = "{{url_for('static', filename='user.png')}}">
                    </div>

                    <div class="salute">
                        <span> {% if message %} {{message}} {% else %} Create a new user {% endif %}</span>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input class=" form input is-large" type="email" name="email" placeholder="Your Email" autofocus="">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input class=" form input is-large" type="username" name="username" placeholder="Your Name" autofocus="">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <select class="select_form input is-large" type="type" name="type" placeholder="Account Type" autofocus="">
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input class="form input is-large" type="password" name="password" placeholder="Your Password">
                        </div>
                    </div>

                    <button class="login_butt form button is-block is-info is-large is-fullwidth">Register</button>

                </form>

                <div class="admins_cards">
                    <h1> Admins </h1>
                {% if admins %}
                    {% for admin in admins %}
                        <form class="user_card" method="POST" action="/auth/register">
                     
                            <input class = "user_data username" type="username" name="username" value={{admin.username}} placeholder={{admin.username}} autofocus=""  />
                        
                            <input class = "user_data email" type="email" name="email" value={{admin.email}} placeholder={{admin.email}} autofocus=""  />
                         
                            <!-- <div class = "user_data">
                                {{admin.type}}
                            </div> -->
                            
                            <select class="user_data type" type="type" name="type" placeholder={{admin.type}} autofocus="">
                                    <option value="admin" selected>Admin</option>
                                    <option value="employee">Employee</option>
                            </select>

                            <div class = "user_data remove">
                                {% if admin.remove %}
                                    Deleted
                                {% else %}
                                    Active
                                {% endif %}
                            </div>

                            <div class="action_butt">
                                <input class = "user_data action_icon change_icon" type="submit" name="change" value={{admin.id}} />
                            </div>

                            <div class="action_butt">
                                <input class = "user_data action_icon remove_icon" type="submit" name="remove" value={{admin.id}} />
                            </div>

                            <div class="action_butt">
                                <input class = "user_data action_icon recover_icon" type="submit" name="recover" value={{admin.id}} />
                            </div>
                            
                        </form>
                    {% endfor %}
                {% endif %}

            </div>

            
        </div>
        
        <div class="employees_cards">
            <h1> Employees </h1>
            {% if employees %}
                {% for employee in employees %}
                    <form class="user_card" method="POST" action="/auth/register">

                        <input class = "user_data username" type="username" name="username" value={{employee.username}} placeholder={{employee.username}} autofocus=""  />
                       
                        <input class = "user_data email" type="email" name="email" value={{employee.email}} placeholder={{employee.email}} autofocus=""  />

                        <select class="user_data type" type="type" name="type" placeholder={{employee.type}} autofocus="">
                                <option value="admin">Admin</option>
                                <option value="employee" selected>Employee</option>
                        </select>

                        <div class = "user_data remove">
                            {% if employee.remove %}
                                Deleted
                            {% else %}
                                Active
                            {% endif %}
                        </div>

                        <div class="action_butt">
                            <input class = "user_data action_icon change_icon" type="submit" name="change" value={{employee.id}} />
                        </div>

                        <div class="action_butt">
                            <input class = "user_data action_icon remove_icon" type="submit" name="remove" value={{employee.id}} />
                        </div>

                        <div class="action_butt">
                            <input class = "user_data action_icon recover_icon" type="submit" name="recover" value={{employee.id}} />
                        </div>
                            
                    </form>
                {% endfor %}
            {% endif %}
        </div>

    </body>
</html>