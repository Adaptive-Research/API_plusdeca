import requests

url = 'http://API.test:8011/API/Show-Traductions'
url = 'http://plusdeca.api2/API/Show-Traductions'



myobj = [ ('Submit' , '1'),  ( 'ValueLangue' , 'FR' )  ]

x = requests.post(url, data = myobj)
print(x.text)

