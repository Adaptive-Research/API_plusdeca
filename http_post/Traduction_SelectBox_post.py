import requests

url = 'http://plusdeca.adaptive-api.fr/API/Show-SelectBox-Traductions'




myobj = [ ('Submit' , '1'),  ( 'ValueLangue' , 'FR' )  ]

x = requests.post(url, data = myobj)
print(x.text)

