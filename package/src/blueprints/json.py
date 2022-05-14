from flask import Blueprint, jsonify, request
from datetime import datetime

from src.blueprints.classes.snmp_class import SwitchData

json = Blueprint(name="json", import_name=__name__)

import asyncio

@json.route("", methods=['GET'])
async def getJsonDataIPPort():
    """
    ---
    get:
      title: Data acquisition functions
      description: Port diagnostic data
      requestBody:
        content:
            application/json:
                schema: OutputSchema
                schema: 
                    type: object
                    properties:
                        ip:
                            type: string
                        port:
                            type: integer
      responses:
        '200':
          description: Port diagnostic data
          content:
            application/json:
                example:
                    ip: 127.0.0.1
                    port: 1
                    port_state:
                        errorIndication : none
                        errorStatus : none
                        errorIndex : 0
                        link_state : up
                        port_speed : yes
                        enabled_speed : yes

                    cable_diag_action:
                        errorIndication : none
                        errorStatus : none
                        errorIndex : 0

                    pairs_state:
                        errorIndication : none
                        errorStatus : none
                        errorIndex : 0
                        pair_1_status: yes
                        pair_2_status: yes

      tags:
          - Get Port Diagnostic Data
    """

    # if not current_user.is_authenticated:
    #     return current_app.login_manager.unauthorized()

    ip = request.args.get('ip')
    port = request.args.get('port')

    tasks = [SwitchData(ip).snmp_check_port_json(port)]
    results = await asyncio.gather(*tasks)

    return jsonify(results[0])
