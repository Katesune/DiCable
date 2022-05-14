from pysnmp.hlapi import *
from ipaddress import *
from datetime import datetime
from flask import Blueprint, jsonify, request, make_response, render_template, current_app
from flask_login import login_required, current_user

from src.blueprints.classes.snmp_class import SwitchData

data = Blueprint(name="data", import_name=__name__)

import asyncio

filename = 'ip_data\checked_ip_list.txt'

def chek_adress(ip):
    try:
        ip_address(ip)
    except ValueError:
        return False
    else:
        return True
    
def get_ips():
    with open(filename) as file:
        ip_list = [row.strip() for row in file]
    for ip in ip_list:
        if not chek_adress(ip):
            ip_list.remove(ip)
    return ip_list

@data.route("/data",  methods=['GET'])
async def getAllData():

    if not current_user.is_authenticated:
        return current_app.login_manager.unauthorized()

    ip_list = get_ips()
    tasks = [SwitchData(ip_list[i]).snmp_get() for i in range(0, len(ip_list))]
    results = await asyncio.gather(*tasks)
    date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")
 
    return render_template('data.php', result=results, date = date)

# @data.route("/data/<ip>")
# async def getDataIP(ip):
#     tasks = [SwitchData(ip).snmp_get_next()]
#     results = await asyncio.gather(*tasks)
#     date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

#     return render_template('data_ip_template.php', title='Test', result=results, date = date, ip=ip)

@data.route("/data/<ip>")
async def getDataIP(ip):
    if not current_user.is_authenticated:
        return current_app.login_manager.unauthorized()

    return render_template('ip_data.php', ports=26, ip=ip)

@data.route("/data/<ip>/<port>")
async def getDataIPPort(ip, port):
    if not current_user.is_authenticated:
        return current_app.login_manager.unauthorized()

    tasks = [SwitchData(ip).snmp_check_port(port)]
    results = await asyncio.gather(*tasks)
    date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

    return render_template('port_data.php', result=results, date = date, ip=ip, port=port)

@data.route("/data/json/<ip>/<port>", methods=['GET'])
async def getJsonDataIPPort(ip, port):
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

    tasks = [SwitchData(ip).snmp_check_port_json(port)]
    results = await asyncio.gather(*tasks)
    date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

    # return jsonify(str(results[0]))
    return jsonify({"errorIndication":"hello"})

@data.route("/json", methods=['GET'])
def hello():
    return jsonify({"errorIndication":"hello"})

@data.route("/errors")
async def getErrors():
    if not current_user.is_authenticated:
        return current_app.login_manager.unauthorized()

    ip_list = get_ips()
    tasks = [SwitchData(ip_list[i]).snmp_get_next_err() for i in range(0, len(ip_list))]
    results = await asyncio.gather(*tasks)
    date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

    return render_template('errors.php', title='Test', result=results, date = date)

@data.route("/errors/<ip>")
async def getErrrsApi(ip):
    if not current_user.is_authenticated:
        return current_app.login_manager.unauthorized()

    tasks = [SwitchData(ip).snmp_get_next_err()]
    results = await asyncio.gather(*tasks)
    date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

    return render_template('ip_errors.php', title='Test', result=results, date = date, ip=ip)


# @data.route('/test', methods=['GET'])
# def test():
#     """
#     ---
#     get:
#       description: Port diagnostic data
#       requestBody:
#         content:
#             application/json:
#                 schema: 
#                     type: object
#                     properties:
#                         ip:
#                             type: string
#                         port:
#                             type: integer
#       responses:
#         '200':
#           description: Port diagnostic data
#           content:
#             application/json:
#                 example:
#                     ip: 127.0.0.1
#                     port: 1
#                     results:
#                         port_state:
#                             errorIndication : none
#                             errorStatus : none
#                             errorIndex : 0
#                             link_state : up
#                             port_speed : yes
#                             enabled_speed : yes

#                         cable_diag_action:
#                             errorIndication : none
#                             errorStatus : none
#                             errorIndex : 0

#                         pairs_state:
#                             errorIndication : none
#                             errorStatus : none
#                             errorIndex : 0
#                             pair_1_status: yes
#                             pair_2_status: yes

#       tags:
#           - calculation
#     """

#     output = {"msg": "I'm the test endpoint from blueprint_x."}
#     return jsonify(output)

# define the blueprint
# data = Blueprint(name="data", import_name=__name__)

# filename = 'checked_ip_list.txt'
# ip_list = []

# community = 'public'  
# ip_address_host = '192.168.88.1'  
# port = 23
# OID = '1.3.6.1.2.1.1.5.0' 

# hell=[]
# h = [1, 2, 3, 4, 5, 6]

# def chek_adress(ip):
#     try:
#         ip_address(ip)
#     except ValueError:
#         return False
#     else:
#         return True
    
# def get_ips():
#     with open(filename) as file:
#         ip_list = [row.strip() for row in file]
#     for ip in ip_list:
#         if not chek_adress(ip):
#             ip_list.remove(ip)

# @data.errorhandler(404)
# def not_found(error):
#     return make_response(jsonify({'error': 'Not found'}), 404)

# # add view function to the blueprint
# # @data.route("/api/data")
# # async def task_create():
# #     ip_list = get_ips()
# #     tasks = [next(request(ip_list[i])) for i in range(1, len(ip_list))]
# #     results = await asyncio.gather(*tasks)
        
# #     response = list(results)
# #     return jsonify(response)

# # @data.route("/ip")
# # async def request(ip):
# #     await asyncio.sleep(random.randint(0, 2) * 0.001)
# #     #time_now = str(datetime.fromtimestamp(1576280665))
# #     result = getCmd(SnmpEngine(),
# #                    CommunityData(community),
# #                    UdpTransportTarget((ip, port)),
# #                    ContextData(),
# #                    ObjectType(ObjectIdentity(OID)))

# @data.route('/switches/<i>')
# async def ping(i):
#     await asyncio.sleep(random.randint(0, 2) * 0.001)
#     j = int(i)
#     hell.append(h[j])
#     time_now = str(datetime.fromtimestamp(1576280665))
#     """
#     ---
#     get:
#       description: test endpoint
#       responses:
#         '200':
#           description: call successful
#           content:
#             application/json:
#               schema: OutputSchema
#       tags:
#           - testing
#     """
#     return {hell[j-1] : str(j) + ' message at ' + time_now }
    
# @data.route('/', methods=['GET'])
# async def pingping():
#     tasks = [ping(i) for i in range(4)]
#     results = await asyncio.gather(*tasks)
        
#     response = list(results)
    
#     """
#     ---
#     get:
#       description: test endpoint
#       responses:
#         '200':
#           description: call successful
#           content:
#             application/json:
#               schema: OutputSchema
#       tags:
#           - testing
#     """

#     return response
    #render_template('templates/index.html', title='Test', user=response)
