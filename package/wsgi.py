"""Web Server Gateway Interface"""

#pip install apispec apispec_webframeworks marshmallow

##################
# FOR PRODUCTION
####################
from src.app import app
from src.blueprints.db.models import db
from src.blueprints.db.models import login

if __name__ == "__main__":
    ####################
    # FOR DEVELOPMENT
    ####################

    app.config['SECRET_KEY'] = '7b5b67df869fd1d345b5a3a5f5b6646028803056e239c77792417c3347b243c5'
    app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///.db'
    app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

    db.init_app(app)
    login.init_app(app)
    login.login_view = 'login.auth'

    @app.before_first_request
    def create_all():
        db.create_all()

    app.run(host='0.0.0.0', debug=True)