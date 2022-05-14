from flask import jsonify

link_state = {"1" : "other", "2" : "link-pass", "3" : "link-fail"}
port_speed = {}
enabled_port = {"1" : "other", "2" : "disabled", "3" : "enabled"}

class Answer(object):
    def __init__(self):
        self.errorIndication = None
        self.errorStatus = None
        self.errorIndex = 0
        self.varBinds = []

    def save_answer(self, errorIndication, errorStatus, errorIndex, varBinds):
        if errorIndication:
                self.errorIndication = errorIndication
        elif errorStatus:
                self.errorStatus = errorStatus
                self.errorIndex = errorIndex
        else:
            for name, val in varBinds:
                self.varBinds.append(val.prettyPrint())

    def save_pair_answer(self, errorIndication, errorStatus, errorIndex, varBinds):
        if errorIndication:
                self.errorIndication = errorIndication
        elif errorStatus:
                self.errorStatus = errorStatus
                self.errorIndex = errorIndex
        else:
            for name, val in varBinds:
                self.varBinds.append(val.prettyPrint())

    def return_diag_result(self, errorIndication, errorStatus, errorIndex, varBinds):
        res = {"errorIndication":None, 
            "errorStatus": None, 
            "errorIndex": None, 
            "results": []}

        if errorIndication:
                res["errorIndication"] = errorIndication
        elif errorStatus:
                res["errorStatus"] = errorStatus
                res["errorIndex"] = errorIndex
        else:
            for name, val in varBinds:
                res["results"].append(val.prettyPrint())
        return res

    def return_pairs_result(self, errorIndication, errorStatus, errorIndex, varBinds, port):
        res = {"errorIndication": None,
               "errorStatus": None,
               "errorIndex": None,
               "results": []}

        if errorIndication:
            res["errorIndication"] = errorIndication
        elif errorStatus:
            res["errorStatus"] = errorStatus
            res["errorIndex"] = errorIndex
        else:
            for name, val in varBinds:
                if (int(port) == int(name[-1])):
                    res["results"].append(int(val))
        return res

    def decode_port_state(self, res):
        r = res["results"]
        res["port_state_values"] = {"link_state":link_state[r[0]], "port_speed":r[1], "enabled_port": enabled_port[r[2]] }
        res.pop("results")
        return res

    def decode_pairs_state(self, res):
        r = res["results"]
        res["pairs_state_values"] = {"pair1_status":r[0], "pair2_status":r[1] }
        res.pop("results")
        return res

    def save_errors(self, errorIndication, errorStatus, errorIndex):
        if errorIndication:
                self.errorIndication = errorIndication
        elif errorStatus:
                self.errorStatus = errorStatus
                self.errorIndex = errorIndex

    def get_array_result(self):
        return {"errorIndication":self.errorIndication, "errorStatus": self.errorStatus, "errorIndex": self.errorIndex, "varBinds": self.varBinds}
