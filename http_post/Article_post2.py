import requests

#url = 'http://API.test:8011/API/Modifier-Article'
url = 'http://plusdeca.api2/API/Modifier-Article'



myobj = [ ('Submit' , '1'),  ( 'debug' , '1' ) , ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'), ( 'idAncestor' , '1' ) ,  ( 'Article_Title' , 'test45' ) , ( 'Article_Text' , 'test55' ) ]

x = requests.post(url, data = myobj)
print(x.text)

