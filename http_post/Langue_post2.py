import requests

url = 'http://API.test:8011/API/Show-Langue'



myobj = [ ('Submit' , '1'),  ( 'debug' , '1' ) , ('token', '12;4e5b931f3b4a354bef48743b34f594cd69cbe2eaecf2969e70311ceaa842') ]

x = requests.post(url, data = myobj)
print(x.text)

