from apispec import APISpec
from apispec.ext.marshmallow import MarshmallowPlugin
from apispec_webframeworks.flask import FlaskPlugin
from marshmallow import Schema, fields

# Create an APISpec
spec = APISpec(
    title="Switch Data",
    version="1.0.0",
    openapi_version="3.0.2",
    plugins=[FlaskPlugin(), MarshmallowPlugin()],
)

# Define schemas
class InputSchema(Schema):
    ip = fields.String(description="IP address.", required=True)
    port = fields.Integer(description="Port number.", required=True)

class PortStateSchema(Schema):
    hidden = True
    errorIndication = fields.String(description="errorIndication.", required=True)
    errorStatus = fields.String(description="errorStatus.", required=True)
    errorIndex = fields.Integer(description="errorIndex.", required=True)
    link_state = fields.String(description="link_state.", required=True)
    port_speed = fields.String(description="port_speed.", required=True)
    enabled_speed = fields.String(description="enabled_speed.", required=True)

class CableDiagActionSchema(Schema):
    errorIndication = fields.String(description="errorIndication.", required=True)
    errorStatus = fields.String(description="errorStatus.", required=True)
    errorIndex = fields.Integer(description="errorIndex.", required=True)

class PairsStateSchema(Schema):
    errorIndication = fields.String(description="errorIndication.", required=True)
    errorStatus = fields.String(description="errorStatus.", required=True)
    errorIndex = fields.Integer(description="errorIndex.", required=True)
    pair_1_status = fields.String(description="pair_1_status.", required=True)
    pair_2_status = fields.String(description="pair_2_status.", required=True)

class ResultsSchema(Schema):
    port_state = fields.List(fields.Nested(PortStateSchema), required=True)
    cable_diag_action = fields.List(fields.Nested(CableDiagActionSchema), required=True)
    pairs_state = fields.List(fields.Nested(PairsStateSchema), required=True)

class OutputSchema(Schema):
    ip = fields.String(description="IP address.", required=True)
    port = fields.Integer(description="Port number.", required=True)
    results = fields.List(fields.Nested(ResultsSchema), required=True)

spec.components.schema("Input", schema=InputSchema)
spec.components.schema("Output", schema=OutputSchema)

# add swagger tags that are used for endpoint annotation
# tags = [
#             {'name': 'test functions',
#              'description': 'For testing the API.'
#             },
#             {'name': 'Data acquisition functions',
#              'description': 'Functions for data acquisition.'
#             },
#        ]

# for tag in tags:
#     print(f"Adding tag: {tag['name']}")
#     spec.tag(tag)