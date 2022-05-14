from flask import Flask, jsonify
from flask_sqlalchemy import SQLAlchemy

from src.blueprints.swagger import swagger_ui_blueprint, SWAGGER_URL
from src.blueprints.data import data
from src.blueprints.login import login
from src.blueprints.json import json
import sys

db = SQLAlchemy()
app = Flask(__name__)

app.register_blueprint(login , url_prefix="/auth")
app.register_blueprint(data, url_prefix="/api")
app.register_blueprint(json, url_prefix="/json")

from src.api_spec import spec

with app.test_request_context():
    # register all swagger documented functions here
    
    for fn_name in app.view_functions:
        if fn_name == 'static':
            continue
        print(f"Loading swagger docs for function: {fn_name}")
        view_fn = app.view_functions[fn_name]
        spec.path(view=view_fn)

@app.route("/api/swagger.json")
def create_swagger_spec():
    return jsonify(spec.to_dict())

from src.blueprints.swagger import swagger_ui_blueprint, SWAGGER_URL
app.register_blueprint(swagger_ui_blueprint, url_prefix=SWAGGER_URL)