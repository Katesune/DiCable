# -*- coding: utf-8 -*-

from src.blueprints.classes.snmp_answer import Answer
from flask import jsonify

from telnetlib import STATUS
from turtle import speed
from pysnmp.hlapi import *
from ipaddress import *
from datetime import datetime
import asyncio
import random
import json

settings_file = "settings.txt"

#with open(settings_file) as file:
   # community,port,OID = [row.strip() for row in file]
#1.3.6.1.2.1.1.5.0
community = 'derfnutfo'  
port = 161

link_state_oid = '.1.3.6.1.4.1.171.11.117.1.1.2.3.1.1.5' # link STATUS
port_speed_oid = '.1.3.6.1.4.1.171.11.117.1.1.2.3.2.1.5' # port speed
enabled_port_oid = '.1.3.6.1.4.1.171.11.117.1.1.2.3.2.1.4' # enabled port

port_diag_action_oid = '.1.3.6.1.4.1.171.12.58.1.1.1.12' # port diag action
table_with_inform_oid = '.1.3.6.1.4.1.171.12.58.1.1.1' # table with inform

pair_1_status_oid = '.1.3.6.1.4.1.171.12.58.1.1.1.4' # pair 1 status
pair_1_length_oid = '.1.3.6.1.4.1.171.12.58.1.1.1.8' # pair 1 lenght

pair_2_status_oid = '.1.3.6.1.4.1.171.12.58.1.1.1.5' # pair 2 status
pair_2_length_oid = '.1.3.6.1.4.1.171.12.58.1.1.1.9' # pair 2 lenght

OIDmany = '.1.3.6.1.2.1.1.9.1.2'
OIDtest = '.1.3.6.1.2.1.2.1' 
OIDtestsec = '.1.3.6.1.2.1.2.2.1.2'  
OIDset = '.1.3.6.1.2.1.1.5'

#.1.3.6.1.4.1.171.12.58.1.1.1.4

class SwitchData(object):
    def __init__(self, ip):
        self.ip = ip
        self.results = {"ip": ip, "answers" :[]}
    
    def snmp_getcmd(self):
        return (nextCmd(SnmpEngine(),
                       CommunityData(community),
                       UdpTransportTarget((self.ip, port)),
                       ContextData(),
                       ObjectType(ObjectIdentity(OIDmany)), lexicographicMode=False))


    async def snmp_get(self):

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(OIDtest)), 
            ObjectType (ObjectIdentity(OIDtestsec)), 
            lexicographicMode=False):

            answer = Answer()
            answer.save_answer(errorIndication, errorStatus, errorIndex, varBinds)
            self.results["answers"].append(answer)

        return self.results

    async def snmp_check_state(self):
        # Отправка запроса для получения инф. о статусе линка, скорости порта, доступности порта 

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(link_state_oid + '.'+ str(port) + '.1')),
            ObjectType(ObjectIdentity(port_speed_oid + '.'+ str(port) + '.1')),
            ObjectType(ObjectIdentity(enabled_port_oid + '.'+ str(port) + '.1')),
            lexicographicMode=False):
            print(varBinds)

            answer = Answer()
            answer.save_answer(errorIndication, errorStatus, errorIndex, varBinds)
            self.results["answers"].append(answer)

        return self.results

    async def snmp_set_diag(self):
        # Запрос для запуска диагностики порта

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in setCmd(SnmpEngine(), 
            CommunityData('private'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(port_diag_action_oid+'.'+str(port)), Integer(2)),
            lexicographicMode=False):

            answer = Answer()
            answer.save_answer(errorIndication, errorStatus, errorIndex, varBinds)
            self.results["answers"].append(answer)

        #return self.results

    async def snmp_get_diag_pairs(self):
        # Запрос для получения диагностики 1 и 2 пары

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(OIDtest)), 
            ObjectType(ObjectIdentity(OIDtestsec)),
            lexicographicMode=False):

            answer = Answer()
            answer.save_answer(errorIndication, errorStatus, errorIndex, varBinds)
            self.results["answers"].append(answer)

    async def snmp_check_port(self, port):

        # await asyncio.sleep(random.randint(0, 2) * 0.001)
        # for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
        #     CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
        #     ObjectType(ObjectIdentity(OIDtest)), ObjectType (ObjectIdentity(OIDtestsec)), ObjectType (ObjectIdentity(OIDtestsec)), 
        #     lexicographicMode=False):

        #     answer = Answer()
        #     answer.save_answer(errorIndication, errorStatus, errorIndex, varBinds)
        #     self.results["answers"].append(answer)

        await self.snmp_check_state()
        await self.snmp_set_diag()
        await self.snmp_get_diag_pairs()

        return self.results

    async def snmp_check_port_json(self, port):
        # Запрос для получения json данных по порту
        date = datetime.strptime("21/11/06 16:30", "%d/%m/%y %H:%M")

        result = {"ip":self.ip, "port":port, "date":date, "port_state" :{}, "cable_diag_action":{}, "pairs_state":{}}
        answer = Answer()

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(link_state_oid + '.'+ str(port) + '.1')),
            ObjectType(ObjectIdentity(port_speed_oid + '.'+ str(port) + '.1')),
            ObjectType(ObjectIdentity(enabled_port_oid + '.'+ str(port) + '.1')),
            lexicographicMode=False):
            print(varBinds)


            result["port_state"] = answer.return_diag_result(errorIndication,errorStatus,errorIndex,varBinds)
            # result["port_state"] = answer.decode_port_state(result["port_state"])

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in setCmd(SnmpEngine(), 
            CommunityData('private'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(port_diag_action_oid+'.'+str(port)), Integer(2)),
            lexicographicMode=False):

            result["cable_diag_action"] = answer.return_diag_result(errorIndication,errorStatus,errorIndex,varBinds)
        
        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(pair_1_length_oid)),
            ObjectType(ObjectIdentity(pair_2_length_oid)),
            lexicographicMode=False):

            r = answer.return_pairs_result(
                errorIndication, errorStatus, errorIndex, varBinds, port)

            if (len(r) != 0):
                result["pairs_state"] = r

            if (len(result["pairs_state"]["results"]) != 0):
                result["pairs_state"] = answer.decode_pairs_state(result["pairs_state"])
                return result

        return result
    
    async def snmp_get_next_err(self):
        # Запрос на ошибки

        await asyncio.sleep(random.randint(0, 2) * 0.001)
        for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
            CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
            ObjectType(ObjectIdentity(OIDtest)), lexicographicMode=False):
            
            answer = Answer()
            answer.save_errors(errorIndication, errorStatus, errorIndex)
            self.results["answers"].append(answer)

        return self.results

    def getError(self):
        return self.results
    
    def getRespose(self):
        return self.varBinds

    # async def snmp_get_next(self):
    #     result = {"ip":self.ip, "errorIndication":None, "errorStatus":None, "errorIndex":0, "varBinds":[]}

    #     await asyncio.sleep(random.randint(0, 2) * 0.001)
    #     for (errorIndication,errorStatus,errorIndex,varBinds) in nextCmd(SnmpEngine(), 
    #         CommunityData('public'), UdpTransportTarget((self.ip, 161)), ContextData(), 
    #         ObjectType(ObjectIdentity(OIDtest)), ObjectType (ObjectIdentity(OIDtestsec)), lexicographicMode=False):

    #         self.errorIndication, self.errorStatus, self.errorIndex, self.varBinds = errorIndication,errorStatus,errorIndex,varBinds

    #         if self.errorIndication:
    #             result["errorIndication"] = self.errorIndication
    #         elif self.errorStatus:
    #             result["errorStatus"] = self.errorStatus
    #         else:
    #             for varBind in self.varBinds:
    #                 result["varBinds"].append(varBind)

    #     return result
