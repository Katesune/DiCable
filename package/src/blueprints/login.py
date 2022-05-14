from flask import Flask, request, render_template, redirect, Blueprint
from flask_login import current_user, login_user, logout_user
from src.blueprints.db.models import login, UserModel, db

login = Blueprint(name="login", import_name=__name__)

@login.route('/login', methods = ['POST', 'GET'])
def auth():
    if current_user.is_authenticated:
        return redirect('/api/data')
    
    if request.method == 'POST':
        email = request.form['email']
        user = UserModel.query.filter_by(email = email).first()
        if user is not None and user.check_password(request.form['password']):
            login_user(user)
            return redirect('/api/data')

    return render_template('login.php', message='Enter your login information')

@login.route('/register', methods=['POST', 'GET'])
def register():

    if current_user.is_authenticated:
        if current_user.type == "admin":
            admins = UserModel.query.filter_by(type = "admin").order_by(UserModel.remove)
            employees = UserModel.query.filter_by(type = "employee").order_by(UserModel.remove)

            if request.method == 'POST':

                if 'remove' in request.form:
                    id = request.form['remove']
                    print(id)
                    user = UserModel.query.filter_by(id=id).first()
                    user.remove = 1
                    return render_template('register.php', admins = admins, employees = employees)

                if 'recover' in request.form:
                    id = request.form['recover']
                    user = UserModel.query.filter_by(id=id).first()
                    user.remove = 0
                    return render_template('register.php', admins = admins, employees = employees)

                email = request.form['email']
                username = request.form['username']
                type = request.form['type']

                if 'change' in request.form:
                    id = request.form['change']
                    user = UserModel.query.filter_by(id=id).first()
                    user.email = email
                    user.username = username
                    user.type = type
                    return render_template('register.php', admins = admins, employees = employees)

                password = request.form['password']

                if UserModel.query.filter_by(email=email).first():
                    return render_template('register.php', message='This email is already in the system', admins = admins, employees = employees)
            
                user = UserModel(email=email, username=username, type=type)
                user.set_password(password)

                db.session.add(user)
                db.session.commit()
                return render_template('register.php', message="New user added successfully", admins = admins, employees = employees)
            return render_template('register.php', message="Create a new user", admins = admins, employees = employees)
        else:
            return redirect('/api/data')

    return render_template('register.php', message="Create a new user")


@login.route('/logout')
def logout():
    logout_user()
    return redirect('/auth/login')
